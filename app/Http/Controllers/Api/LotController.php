<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LotRequest;
use App\Http\Resources\LotResource;
use App\Models\Lot;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LotController extends Controller
{
    use ApiResponse;
    public function index(Request $request)
    {
        $status = $request->query('status');
        $pagination = $request->query('pagination');

        $Lot = Lot::when($status === "inactive", function ($query) {
            $query->onlyTrashed();
        })
            ->orderBy('created_at', 'desc')
            ->useFilters()
            ->dynamicPaginate();

        if (!$pagination) {
            LotResource::collection($Lot);
        } else {
            $Lot = LotResource::collection($Lot);
        }

        return $this->responseSuccess('Lot display successfully', $Lot);
    }

    public function store(LotRequest $request)
    {
        // Handle lot_image (first image)
        $lot_image = $request->file('lot_image')?->store('lot', 'public');

        // Handle second, third, and fourth images
        $second_lot_image = $request->file('second_lot_image')?->store('lot', 'public');
        $third_lot_image = $request->file('third_lot_image')?->store('lot', 'public');
        $fourth_lot_image = $request->file('fourth_lot_image')?->store('lot', 'public');

        // Create the lot record
        $create_lot = Lot::create([
            "lot_image" => $lot_image,
            "second_lot_image" => $second_lot_image,
            "third_lot_image" => $third_lot_image,
            "fourth_lot_image" => $fourth_lot_image,
            "lot_number" => $request->lot_number,
            "description" => $request->description,
            "coordinates" => is_string($request->coordinates)
                ? json_decode($request->coordinates, true)
                : $request->coordinates,
            "status" => $request->status,
            "reserved_until" => $request->reserved_until,
            "price" => $request->price,
            "is_land_mark" => $request->is_land_mark,
        ]);

        return $this->responseCreated('Lot Successfully Created', $create_lot);
    }


    public function update(LotRequest $request, $id)
    {
        $lot = Lot::find($id);

        if (!$lot) {
            return $this->responseUnprocessable('', 'Invalid ID provided for updating. Please check the ID and try again.');
        }

        // Handle lot_image replacement
        if ($request->hasFile('lot_image')) {
            if ($lot->lot_image && Storage::disk('public')->exists($lot->lot_image)) {
                Storage::disk('public')->delete($lot->lot_image);
            }
            $lot->lot_image = $request->file('lot_image')->store('lot', 'public');
        }

        // Handle second_lot_image replacement
        if ($request->hasFile('second_lot_image')) {
            if ($lot->second_lot_image && Storage::disk('public')->exists($lot->second_lot_image)) {
                Storage::disk('public')->delete($lot->second_lot_image);
            }
            $lot->second_lot_image = $request->file('second_lot_image')->store('lot', 'public');
        }

        // Handle third_lot_image replacement
        if ($request->hasFile('third_lot_image')) {
            if ($lot->third_lot_image && Storage::disk('public')->exists($lot->third_lot_image)) {
                Storage::disk('public')->delete($lot->third_lot_image);
            }
            $lot->third_lot_image = $request->file('third_lot_image')->store('lot', 'public');
        }

        // Handle fourth_lot_image replacement
        if ($request->hasFile('fourth_lot_image')) {
            if ($lot->fourth_lot_image && Storage::disk('public')->exists($lot->fourth_lot_image)) {
                Storage::disk('public')->delete($lot->fourth_lot_image);
            }
            $lot->fourth_lot_image = $request->file('fourth_lot_image')->store('lot', 'public');
        }

        // Update other fields
        $lot->lot_number = $request->lot_number;
        $lot->description = $request->description;
        $lot->coordinates = is_string($request->coordinates)
            ? json_decode($request->coordinates, true)
            : $request->coordinates;
        $lot->status = $request->status;
        $lot->reserved_until = $request->reserved_until;
        $lot->price = $request->price;
        $lot->downpayment_price = $request->downpayment_price;
        $lot->is_land_mark = $request->is_land_mark;

        if (!$lot->isDirty()) {
            return $this->responseSuccess('No Changes', $lot);
        }

        $lot->save();

        return $this->responseSuccess('Lot successfully updated', $lot);
    }



    public function archived(Request $request, $id)
    {
        $lot = Lot::withTrashed()->find($id);

        if (!$lot) {
            return $this->responseUnprocessable('', 'Invalid id please check the id and try again.');
        }

        if ($lot->deleted_at) {

            $lot->restore();

            return $this->responseSuccess('lot successfully restore', $lot);
        }

        if (!$lot->deleted_at) {

            $lot->delete();

            return $this->responseSuccess('lot successfully deleted', $lot);
        }
    }
}
