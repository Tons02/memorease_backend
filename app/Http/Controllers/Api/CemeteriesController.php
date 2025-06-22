<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CemeteriesRequest;
use App\Models\Cemeteries;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;

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

        return $this->responseSuccess('Cemeteries display successfully', $Cemeteries);
    }

    public function store(CemeteriesRequest $request)
    {
        $create_cemeteries = Cemeteries::create([
            "name" => $request->name,
            "location" => $request->location,
            "description" => $request->description,
            "profile_picture" => $request->profile_picture,
            "background_picture" => $request->background_picture,
        ]);

        return $this->responseCreated('Cemetery Successfully Created', $create_cemeteries);
    }

    public function update(CemeteriesRequest $request, $id)
    {
        $cemeteries = Cemeteries::find($id);

        if (!$cemeteries) {
            return $this->responseUnprocessable('', 'Invalid ID provided for updating. Please check the ID and try again.');
        }

        $cemeteries->name = $request['name'];
        $cemeteries->location = $request['location'];
        $cemeteries->description = $request['description'];
        $cemeteries->profile_picture = $request['profile_picture'];
        $cemeteries->background_picture = $request['background_picture'];

        if (!$cemeteries->isDirty()) {
            return $this->responseSuccess('No Changes', $cemeteries);
        }

        // Save updated cemeteries
        $cemeteries->save();

        return $this->responseSuccess('Cemetery successfully updated', $cemeteries);
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
