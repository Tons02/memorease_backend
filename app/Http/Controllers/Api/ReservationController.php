<?php

namespace App\Http\Controllers\Api;

use App\Events\ApprovedReservation;
use App\Events\LotReserved;
use App\Exports\ReservationSales;
use App\Http\Controllers\Controller;
use App\Http\Requests\CancelReservationRequest;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\WalkInRequest;
use App\Http\Resources\ReservationResource;
use App\Mail\ReservationSuccessMail;
use App\Mail\WalkInReservationMail;
use App\Models\ActivityLog;
use App\Models\AuditTrails;
use App\Models\Lot;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class ReservationController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $status = $request->query('status');
        $pagination = $request->query('pagination');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        $reservation = Reservation::when($status === 'inactive', function ($query) {
            $query->onlyTrashed();
        })
            ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                $query->whereBetween('reserved_at', [$start_date, $end_date]);
            })
            ->orderBy('created_at', 'desc')
            ->useFilters()
            ->dynamicPaginate();

        if (!$pagination) {
            ReservationResource::collection($reservation);
        } else {
            $reservation = ReservationResource::collection($reservation);
        }

        return $this->responseSuccess('Reservation display successfully', $reservation);
    }

    public function store(ReservationRequest $request)
    {
        $request->file('proof_of_payment');
        $proof_of_payment = $request->file('proof_of_payment')?->store('proof_of_payment', 'public');

        $lot_id = $request->lot_id;
        if (!auth()->user()) {
            return $this->responseUnprocessable('Please Login Before you reserve.',);
        }

        //limit to one pending
        $check_reservation = Reservation::where('user_id', auth()->user()->id)->where('status', 'pending')->count();

        if ($check_reservation >= 1) {
            return $this->responseUnprocessable('Please Finish your pending reservation first.', '');
        }

         $lot_details = Lot::where('id', $lot_id)->first();

        // Create Reservation
        $create_reservation = Reservation::create([
            'lot_id' => $lot_id,
            'user_id' => auth()->user()->id,
            'total_downpayment_price' => $request->total_downpayment_price,
            'proof_of_payment' => $proof_of_payment,
            'reserved_at' => Carbon::now(), // also remove the space in the key
            'expires_at' => Carbon::now()->addDay(1),
        ]);


        $lot = Lot::findOrFail($request->lot_id);
        $lot->update(['status' => 'reserved']);

        ActivityLog::create([
            'action' => 'Reserve Lot ' . $lot_details->lot_number,
            'user_id' => auth()->user()->id,
        ]);

        // Fire Event
        event(new LotReserved($lot));

        // Send Email
        Mail::to(auth()->user()->email)->send(new ReservationSuccessMail($create_reservation));
      

        return $this->responseCreated('Reservation Successfully Created', $create_reservation);
    }

    public function walk_in(WalkInRequest $request)
    {
        $request->file('proof_of_payment');
        $proof_of_payment = $request->file('proof_of_payment')?->store('proof_of_payment', 'public');

        $lot = Lot::find($request->lot_id);
        if (!$lot) {
            return $this->responseUnprocessable('', 'Invalid ID provided for reservation. Please check the ID and try again.');
        }

        $lot->update(['status' => 'sold']);

        $create_user = User::create([
            "profile_picture" => "default_profile.jpg",
            "fname" => $request["fname"],
            "mi" => $request["mi"],
            "lname" => $request["lname"],
            "suffix" => $request["suffix"],
            "gender" => $request["gender"],
            "mobile_number" => $request["mobile_number"],
            "birthday" => $request["birthday"],
            "address" => $request["address"],
            "username" => $request["username"],
            "email" => $request["email"],
            "password" => $request["username"],
            "role_type" => "customer",
            "email_verified_at" => Carbon::now(),
        ]);

        // Create Reservation
        $create_reservation = Reservation::create([
            'lot_id' => $lot->id,
            'user_id' => $create_user->id,
            'total_downpayment_price' => $lot->downpayment_price,
            'proof_of_payment' => $proof_of_payment,
            'status' => "approved",
            'reserved_at' => Carbon::now(),
            'approved_date' => Carbon::now(),
            'approved_id' => auth()->id()
        ]);

        // Fire Event
        event(new LotReserved($lot));

        if ($request->email) {
            // Send Email
            $create_user->notify(new \App\Notifications\WalkInReservationNotification(
                $create_user,
                $create_reservation,
                $lot,
                $request["username"]
            ));
        }

        $create_audit_trail = AuditTrails::create([
            "lot_id" => $lot->id,
            "current_owner_id" => $create_user->id,
        ]);

        // to the customer
        ActivityLog::create([
            'action' => 'Walkin Reservation Reserve Lot ID ' . $lot->id,
            'user_id' => $create_user->id,
        ]);

        // log of who created the transanction
        ActivityLog::create([
            'action' => 'Create Walkin Reservation for Lot ID ' . $lot->id,
            'user_id' => auth()->user()->id,
        ]);

        return $this->responseCreated('Reservation Successfully Created', $create_reservation);
    }

    public function approve(Request $request, $id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return $this->responseUnprocessable('', 'Invalid ID provided for updating. Please check the ID and try again.');
        }

        if ($reservation->status == "canceled") {
            return $this->responseUnprocessable('Already Canceled', '');
        }

        if ($reservation->status == "rejected") {
            return $this->responseUnprocessable('', 'Already Rejected Cant be Approved');
        }

        if ($reservation->status == "approved") {
            return $this->responseUnprocessable('', 'Already Approved Cant be Approve again');
        }


        $lot = Lot::findOrFail($reservation->lot_id);

        $reservation->status = 'approved';
        $reservation->approved_date = Carbon::now();
        $reservation->approved_id = auth()->id();

        $lot->status = 'sold';

        $reservation->save();

        $lot->save();

        $create_audit_trail = AuditTrails::create([
            "lot_id" => $lot->id,
            "current_owner_id" => $reservation->user_id,
        ]);

        
        // log of who approve the transanction
        ActivityLog::create([
            'action' => 'Approved Reservation ID:  ' . $reservation->id,
            'user_id' => auth()->user()->id,
        ]);


        event(new LotReserved($lot));

        return $this->responseSuccess('Successfully Approved', $reservation);
    }


    public function cancel(Request $request, $id)
    {
        $reservation = Reservation::find($id);

          $request->validate([
            'remarks' => 'required|string',
        ]);

        if (!$reservation) {
            return $this->responseUnprocessable('Invalid ID provided for updating. Please check the ID and try again.', '');
        }

        if ($reservation->status == "canceled") {
            return $this->responseUnprocessable('Already Canceled', '');
        }

        if ($reservation->status == "approved") {
            return $this->responseUnprocessable('Already Approved Cant be Canceled', '');
        }


        $lot = Lot::findOrFail($reservation->lot_id);

        $reservation->status = 'canceled';
        $reservation->remarks = $request->remarks;

        $lot->status = 'available';

        $reservation->save();

        $lot->save();

        // log of who approve the transanction
        ActivityLog::create([
            'action' => 'Cancel Reservation ID ' . $reservation->id,
            'user_id' => auth()->user()->id,
        ]);


        event(new LotReserved($lot));

        return $this->responseSuccess('Successfully Canceled', $reservation);
    }

    public function reject(Request $request, $id)
    {
        $reservation = Reservation::find($id);

        $request->validate([
            'remarks' => 'required|string',
        ]);

        if (!$reservation) {
            return $this->responseUnprocessable('', 'Invalid ID provided for updating. Please check the ID and try again.');
        }

        if ($reservation->status == "canceled") {
            return $this->responseUnprocessable('Already Canceled', '');
        }

        if ($reservation->status == "approved") {
            return $this->responseUnprocessable('Already Approved Cant be Reject', '');
        }


        $lot = Lot::findOrFail($reservation->lot_id);

        $reservation->status = 'rejected';
        $reservation->remarks = $request->remarks;
        $reservation->approved_id = auth()->id();

        $lot->status = 'available';

        $reservation->save();

        $lot->save();

        // log of who approve the transanction
        ActivityLog::create([
            'action' => 'Reject Reservation ID ' . $reservation->id,
            'user_id' => auth()->user()->id,
        ]);


        event(new LotReserved($lot));

        return $this->responseSuccess('Successfully Rejected', $reservation);
    }

    public function reservation_sales(Request $request)
    {
        $start_date = Carbon::parse($request->query('start_date'))->startOfDay();
        $end_date = Carbon::parse($request->query('end_date'))->endOfDay();

        $reservations = Reservation::selectRaw('DATE(approved_date) as day, SUM(total_downpayment_price) as total_sales')
            ->whereBetween('approved_date', [$start_date, $end_date])
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get();

        return $this->responseSuccess('Reservation sales display successfully', $reservations);
    }

    public function total_number_of_reservation_this_month(Request $request)
    {
        $status = $request->query('status');

        $reservations = Reservation::where('status', $status)
            ->whereMonth('reserved_at', Carbon::now()->month)
            ->whereYear('reserved_at', Carbon::now()->year)
            ->count();

        return $this->responseSuccess(
            'Reservation count displayed successfully',
            $reservations
        );
    }

    public function reservation_export(Request $request)
    {
        $status = $request->query('status');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        // $query = Reservation::with('lot', 'customer','approved');

        //     if ($status) {
        //         $query->where('status', $status);
        //     }

        //     if ($start_date && $end_date) {
        //         $query->whereBetween('reserved_at', [$start_date, $end_date]);
        //     }

        //     return $query->get();

        return Excel::download(
            new ReservationSales($status, $start_date, $end_date),
            'Reservation Sales.xlsx'
        );
    }

    public function get_audit_trail(Request $request) {
        $status = $request->query('status');

        $AuditTrails = AuditTrails::with(['lot', 'current_owner'])->when($status === 'inactive', function ($query) {
            $query->onlyTrashed();
        })
            ->orderBy('created_at', 'desc')
            ->useFilters()
            ->dynamicPaginate();
            
        return $this->responseSuccess('Audit Trail display successfully', $AuditTrails);
    }
    
    public function transfer_lot(Request $request, $id)
    {
        $audit = AuditTrails::with(['current_owner', 'lot'])->findOrFail($id);

        // Validate that the authenticated user is the current owner
        if (auth()->user()->id !== $audit->current_owner_id) {
            return $this->responseBadRequest('You are not authorized to transfer this lot. Only the current owner can transfer ownership.');
        }

        $validated = $request->validate([
            'new_owner_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) use ($audit) {
                    if ($value == $audit->current_owner_id) {
                        $fail('Cannot transfer lot to the same owner.');
                    }
                },
            ],
        ]);

        // Get the current owner (authenticated user)
        $currentUser = auth()->user();

        $currentOwnerName = trim(
            $currentUser->fname . ' ' .
            ($currentUser->mi ? $currentUser->mi . ' ' : '') .
            $currentUser->lname .
            ($currentUser->suffix ? ' ' . $currentUser->suffix : '')
        );

        // ---- GET NEW OWNER NAME ----
        $newOwner = User::find($validated['new_owner_id']);
        $newOwnerName = trim(
            $newOwner->fname . ' ' .
            ($newOwner->mi ? $newOwner->mi . ' ' : '') .
            $newOwner->lname .
            ($newOwner->suffix ? ' ' . $newOwner->suffix : '')
        );
        // ----------------------------

        // Get existing previous owners array
        $existingPreviousOwners = $audit->previous_owner ?? [];

        // Convert to array if stored as string
        if (is_string($existingPreviousOwners)) {
            $existingPreviousOwners = [$existingPreviousOwners];
        }

        // Add the current owner to the previous owners array
        $existingPreviousOwners[] = $currentOwnerName;

        // Save
        $audit->previous_owner = $existingPreviousOwners;
        $audit->current_owner_id = $validated['new_owner_id'];
        $audit->save();

        // ---- CREATE ACTIVITY LOG WITH FULL NAME ----
        ActivityLog::create([
            'action'  => "Transferred lot to {$newOwnerName}",
            'user_id' => auth()->user()->id,
        ]);
        // --------------------------------------------

        return $this->responseSuccess('Transfer Lot successfully', $audit);
    }



    public function activity_log(Request $request){
        $status = $request->query('status');

        $ActivityLog = ActivityLog::with('user')->when($status === 'inactive', function ($query) {
            $query->onlyTrashed();
        })
            ->orderBy('created_at', 'desc')
            ->useFilters()
            ->dynamicPaginate();
            
        return $this->responseSuccess('Activity Log display successfully', $ActivityLog);
    }

}
