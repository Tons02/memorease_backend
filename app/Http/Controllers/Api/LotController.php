<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LotRequest;
use App\Http\Resources\LotResource;
use App\Models\ActivityLog;
use App\Models\Lot;
use App\Models\Reservation;
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

    public function streamVideo($folder, $filename)
    {
        // Validate folder to prevent directory traversal
        $allowedFolders = ['lot', 'cemeteries', 'messages'];

        if (!in_array($folder, $allowedFolders)) {
            abort(403, 'Access denied');
        }

        $path = storage_path("app/public/{$folder}/" . $filename);

        if (!file_exists($path)) {
            abort(404, 'Video not found');
        }

        $fileSize = filesize($path);
        $mimeType = mime_content_type($path);
        $range = request()->header('Range');

        if (!$range) {
            return response()->file($path, [
                'Content-Type' => $mimeType,
                'Accept-Ranges' => 'bytes',
                'Content-Length' => $fileSize,
            ]);
        }

        list($param, $rangeValue) = explode('=', $range);

        if (strtolower(trim($param)) != 'bytes') {
            return response('Invalid range parameter', 400);
        }

        $rangeParts = explode('-', $rangeValue);
        $start = intval($rangeParts[0]);
        $end = isset($rangeParts[1]) && $rangeParts[1] !== '' ? intval($rangeParts[1]) : $fileSize - 1;

        if ($start > $end || $start >= $fileSize || $end >= $fileSize) {
            return response('', 416)
                ->header('Content-Range', "bytes */$fileSize");
        }

        $length = $end - $start + 1;

        $stream = new \Symfony\Component\HttpFoundation\StreamedResponse(function () use ($path, $start, $length) {
            $fp = fopen($path, 'rb');
            fseek($fp, $start);

            $buffer = 8192;
            $bytesRead = 0;

            while (!feof($fp) && $bytesRead < $length && connection_status() == 0) {
                $bytesToRead = min($buffer, $length - $bytesRead);
                echo fread($fp, $bytesToRead);
                $bytesRead += $bytesToRead;
                flush();
            }

            fclose($fp);
        });

        $stream->setStatusCode(206);
        $stream->headers->set('Content-Type', $mimeType);
        $stream->headers->set('Content-Length', $length);
        $stream->headers->set('Content-Range', "bytes $start-$end/$fileSize");
        $stream->headers->set('Accept-Ranges', 'bytes');

        return $stream;
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
            "downpayment_price"  => $request->downpayment_price,
            // "reserved_until" => $request->reserved_until,
            "price" => $request->price,
            "is_land_mark" => $request->is_land_mark,
        ]);

        ActivityLog::create([
            'action' => 'Create Lot ' . $create_lot->lot_number,
            'user_id' => auth()->user()->id,
        ]);

        return $this->responseCreated('Lot Successfully Created', $create_lot);
    }


    public function update(LotRequest $request, $id)
    {
        $lot = Lot::find($id);

        if (!$lot) {
            return $this->responseUnprocessable('', 'Invalid ID provided for updating. Please check the ID and try again.');
        }

        // Check if the lot is already reserved and not available for editing
        $already_reserved = Reservation::where('lot_id', $id)
            ->whereIn('status', ['pending', 'approved', 'paid'])
            ->exists();

        if ($already_reserved) {
            return $this->responseUnprocessable('This lot is already reserved and cannot be edited.', '');
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
        // $lot->reserved_until = $request->reserved_until;
        $lot->price = $request->price;
        $lot->downpayment_price = $request->downpayment_price;
        $lot->is_land_mark = $request->is_land_mark;

        if (!$lot->isDirty()) {
            return $this->responseSuccess('No Changes', $lot);
        }

        $lot->save();

        
        ActivityLog::create(attributes: [
            'action' => 'Update Lot ' . $lot->lot_number,
            'user_id' => auth()->user()->id,
        ]);
        return $this->responseSuccess('Lot successfully updated', $lot);
    }



    public function archived(Request $request, $id)
    {
        $lot = Lot::withTrashed()->find($id);

        if (!$lot) {
            return $this->responseUnprocessable('', 'Invalid id please check the id and try again.');
        }

        // Check if the lot is already reserved and not available for editing
        $already_reserved = Reservation::where('lot_id', $id)
            ->whereIn('status', ['pending', 'approved', 'paid'])
            ->exists();

        if ($already_reserved) {
            return $this->responseUnprocessable('This lot is already reserved and cannot be edited.', '');
        }

        if ($lot->deleted_at) {

            $lot->restore();

            return $this->responseSuccess('lot successfully restore', $lot);
        }

        if (!$lot->deleted_at) {

            $lot->delete();
                
            ActivityLog::create(attributes: [
                'action' => 'Delete Lot ' . $lot->number,
                'user_id' => auth()->user()->id,
            ]);

            return $this->responseSuccess('lot successfully deleted', $lot);
        }
    }
}
