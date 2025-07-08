<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        $lot_id =  $request->lot_id;

        // Create Reservation
        $create_reservation = Reservation::create([
            'lot_id' =>  $lot_id,
            'user_id' => $request->user_id,
            'total_downpayment_price' => $request->total_downpayment_price,
            'proof_of_payment' => $proof_of_payment,
            'reserved_at ' => Carbon::now(),
            'expires_at' => Carbon::now()->addDay(1),
        ]);

        Lot::where('id', $request->lot_id)->update([
            'status' => 'reserved',
        ]);

        return $this->responseCreated('Reservation Successfully Created', $create_reservation);
    }

    public function update(ReservationRequest $request, $id) {}
}
