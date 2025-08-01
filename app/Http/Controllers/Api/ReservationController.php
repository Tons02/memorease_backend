<?php

namespace App\Http\Controllers\Api;

use App\Events\ApprovedReservation;
use App\Events\LotReserved;
use App\Http\Controllers\Controller;
use App\Http\Requests\CancelReservationRequest;
use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Lot;
use App\Models\Reservation;
use Carbon\Carbon;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $status = $request->query('status');
        $pagination = $request->query('pagination');

        $reservation = Reservation::when($status === 'inactive', function ($query) {
            $query->onlyTrashed();
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

        // Fire Event
        event(new LotReserved($lot));

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

        $lot->status = 'sold';

        $reservation->save();

        $lot->save();


        event(new LotReserved($lot));

        return $this->responseSuccess('Successfully Approved', $reservation);
    }


    public function cancel(Request $request, $id)
    {
        $reservation = Reservation::find($id);

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

        $lot->status = 'available';

        $reservation->save();

        $lot->save();


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

        $lot->status = 'available';

        $reservation->save();

        $lot->save();


        event(new LotReserved($lot));

        return $this->responseSuccess('Successfully Rejected', $reservation);
    }
}
