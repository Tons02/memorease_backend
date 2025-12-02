<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CemeteriesRequest;
use App\Http\Resources\CemeteryResource;
use App\Models\ActivityLog;
use App\Models\Cemeteries;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CemeteriesController extends Controller
{
    use ApiResponse;
    public function index(Request $request)
    {
        $status = $request->query('status');

        $Cemeteries = Cemeteries::when($status === "inactive", function ($query) {
            $query->onlyTrashed();
        })
            ->orderBy('created_at', 'desc')
            ->useFilters()
            ->dynamicPaginate();

        return $this->responseSuccess('Cemeteries display successfully', CemeteryResource::collection($Cemeteries));
    }

    public function store(CemeteriesRequest $request)
    {
        if (Cemeteries::exists()) {
            return $this->responseUnprocessable('', 'Unable to create: a cemetery already exists.');
        }

        $path = $request->file('profile_picture')?->store('cemeteries', 'public');

        // Create new cemetery
        $create_cemeteries = Cemeteries::create([
            'profile_picture' => $path,
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'coordinates' => $request->coordinates,
        ]);

        return $this->responseCreated('Cemetery Successfully Created', $create_cemeteries);
    }


    public function update(CemeteriesRequest $request, $id)
    {
        $cemetery = Cemeteries::find($id);

        if (!$cemetery) {
            return $this->responseUnprocessable('', 'Invalid ID provided for updating. Please check the ID and try again.');
        }

        if ($request->hasFile('profile_picture')) {
            if ($cemetery->profile_picture && Storage::disk('public')->exists($cemetery->profile_picture)) {
                Storage::disk('public')->delete($cemetery->profile_picture);
            }

            $path = $request->file('profile_picture')->store('cemeteries', 'public');
            $cemetery->profile_picture = $path;
        }

        // Assign values
        $cemetery->name = $request->name;
        $cemetery->description = $request->description;
        $cemetery->location = $request->location;

        // Only update coordinates if provided in the request
        if ($request->filled('coordinates')) {
            $cemetery->coordinates = $request->coordinates;
        }

        $cemetery->save();


        ActivityLog::create([
            'action' => 'Update Cemetery Information',
            'user_id' => auth()->user()->id,
        ]);


        return $this->responseSuccess('Cemetery successfully updated', $cemetery);
    }

    public function archived(Request $request, $id)
    {
        $cemeteries = Cemeteries::withTrashed()->find($id);

        if (!$cemeteries) {
            return $this->responseUnprocessable('', 'Invalid id please check the id and try again.');
        }

        if ($cemeteries->deleted_at) {

            $cemeteries->restore();

            return $this->responseSuccess('Cemetery successfully restore', $cemeteries);
        }

        if (!$cemeteries->deleted_at) {

            $cemeteries->delete();

            return $this->responseSuccess('Cemetery successfully archive', $cemeteries);
        }
    }
}
