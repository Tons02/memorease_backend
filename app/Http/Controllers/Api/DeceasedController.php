<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeceasedRequest;
use App\Http\Resources\DeceasedResource;
use App\Models\Deceased;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeceasedController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $status = $request->query('status');
        $pagination = $request->query('pagination');

        $Deceased = Deceased::with('lot')
            ->when($status === "inactive", function ($query) {
                $query->onlyTrashed();
            })
            ->orderBy('created_at', 'desc')
            ->useFilters()
            ->dynamicPaginate();

        if (!$pagination) {
            DeceasedResource::collection($Deceased);
        } else {
            $Deceased = DeceasedResource::collection($Deceased);
        }

        return $this->responseSuccess('Deceased display successfully', $Deceased);
    }

    public function store(DeceasedRequest $request)
    {

        return $request->file('lot_image');
        $lot_image = $request->file('lot_image')?->store('lot_image', 'public');
        $death_certificate = $request->file('death_certificate')?->store('death_certificate', 'public');

        // Create Deceased
        $create_deceased = Deceased::create([
            'lot_image' => $lot_image,
            'lot_id' => $request->lot_id,
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'suffix ' => $request->suffix,
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'death_date' => $request->death_date,
            'burial_date' => $request->burial_date,
            'death_certificate' => $death_certificate,
        ]);

        return $this->responseCreated('Deceased Successfully Created', $create_deceased);
    }

    public function update(Request $request, $id)
    {
        $update_deceased = Deceased::find($id);

        if (!$update_deceased) {
            return $this->responseUnprocessable('', 'Invalid ID provided for updating. Please check the ID and try again.');
        }

        // Handle lot_image replacement
        if ($request->hasFile('lot_image')) {
            if ($update_deceased->lot_image && Storage::disk('public')->exists($update_deceased->lot_image)) {
                Storage::disk('public')->delete($update_deceased->lot_image);
            }
            $update_deceased->lot_image = $request->file('lot_image')->store('lot_image', 'public');
        }

        // Handle death_certificate replacement
        if ($request->hasFile('death_certificate')) {
            if ($update_deceased->death_certificate && Storage::disk('public')->exists($update_deceased->death_certificate)) {
                Storage::disk('public')->delete($update_deceased->death_certificate);
            }
            $update_deceased->death_certificate = $request->file('death_certificate')->store('death_certificate', 'public');
        }

        // Update only fields that are not null (optional safety)
        $update_deceased->lot_id = $request->lot_id;
        $update_deceased->fname = $request->fname;
        $update_deceased->mname = $request->mname;
        $update_deceased->lname = $request->lname;
        $update_deceased->suffix = $request->suffix;
        $update_deceased->gender = $request->gender;
        $update_deceased->birthday = $request->birthday;
        $update_deceased->death_date = $request->death_date;
        $update_deceased->burial_date = $request->burial_date;

        $update_deceased->save();

        return $this->responseCreated('Deceased record updated successfully.', $update_deceased);
    }

    public function archived(Request $request, $id)
    {
        $deceased = Deceased::withTrashed()->find($id);

        if (!$deceased) {
            return $this->responseUnprocessable('', 'Invalid id please check the id and try again.');
        }

        if ($deceased->deleted_at) {

            $deceased->restore();

            return $this->responseSuccess('Cemetery successfully restore', $deceased);
        }

        if (!$deceased->deleted_at) {

            $deceased->delete();

            return $this->responseSuccess('Cemetery successfully archive', $deceased);
        }
    }
}
