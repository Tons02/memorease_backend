<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeceasedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "lot_image" => [
                "required",
            ],
            'lot_id' => [
                'required',
                Rule::exists('lots', 'id')->where(function ($query) {
                    $query->where('status', 'sold');
                }),
            ],
            "fname" => [
                "required",
            ],
            "lname" => [
                "required",
            ],
            "gender" => [
                "required",
            ],
            "birthday" => [
                "required",
            ],
            "death_date" => [
                "required",
            ],
            "death_certificate" => [
                "required",
            ],
        ];
    }

    public function messages()
    {
        return [
            "lot_id.exists" => "The selected Lot ID is invalid or not sold yet.",
        ];
    }
}
