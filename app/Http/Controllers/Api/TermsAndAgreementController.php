<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TermsAndAgreementRequest;
use App\Models\TermsAndAgreement;
use Essa\APIToolKit\Api\ApiResponse;
use Illuminate\Http\Request;

class TermsAndAgreementController extends Controller
{
    use ApiResponse;
    public function index(Request $request)
    {
        $status = $request->query('status');

        $TermsAndAgreement = TermsAndAgreement::when($status === 'inactive', function ($query) {
            $query->onlyTrashed();
        })
            ->orderBy('created_at', 'desc')
            ->useFilters()
            ->dynamicPaginate();

        return $this->responseSuccess('Terms and agreement display successfully', $TermsAndAgreement);
    }

    public function store(TermsAndAgreementRequest $request)
    {
        // Check if there is already a record
        $exists = TermsAndAgreement::exists();

        if ($exists) {
            return $this->responseConflictError(
                'Terms and agreement already exists. You can only have one record.',

            );
        }
        $create_terms = TermsAndAgreement::create([
            "terms" => $request["terms"],
        ]);

        return $this->responseCreated('Terms and agreement Successfully Created', $create_terms);
    }

    public function update(TermsAndAgreementRequest $request, $id)
    {
        $terms = TermsAndAgreement::find($id);

        if (!$terms) {
            return $this->responseUnprocessable('', 'Invalid ID provided for updating. Please check the ID and try again.');
        }

        $terms->terms = $request["terms"];

        if (!$terms->isDirty()) {
            return $this->responseSuccess('No Changes', $terms);
        }

        $terms->save();

        return $this->responseSuccess('Terms and agreement successfully updated', $terms);
    }

    public function archived(Request $request, $id)
    {

        $terms = TermsAndAgreement::withTrashed()->find($id);

        if (!$terms) {
            return $this->responseUnprocessable('', 'Invalid id please check the id and try again.');
        }

        if ($terms->deleted_at) {

            $terms->restore();
            return $this->responseSuccess('terms successfully restore', $terms);
        }

        if (!$terms->deleted_at) {

            $terms->delete();
            return $this->responseSuccess('terms successfully archive', $terms);
        }
    }
}
