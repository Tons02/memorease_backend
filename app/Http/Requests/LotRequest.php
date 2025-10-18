<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LotRequest extends FormRequest
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
            "description" => [
                "required",
            ],
            "lot_number" => [
                "required",
                "string",
                // Rule::unique('lots', 'lot_number')
                //     ->ignore($this->route('id'))
                //     ->whereNull('deleted_at'),
            ],
            "lot_image" => [
                "nullable",
                "image",
                "mimes:jpeg,png,jpg,gif,svg",
            ],
            "coordinates" => [
                "required",
            ],
            "status" => [
                "in:available,pending,reserved,sold,land_mark"
            ],
            "reserved_until" => [
                "nullable",
            ],
            'price' => [
                'required_if:is_land_mark,0',
                // 'numeric',
                'nullable',
                // 'regex:/^\d{1,10}(\.\d{1,2})?$/',
            ],
            'downpayment_price' => [
                'required_if:is_land_mark,0',
                'numeric',
                'nullable',
                'regex:/^\d{1,10}(\.\d{1,2})?$/',
                'lte:price',
            ],
            'is_land_mark' => ['required', 'in:0,1'],
        ];
    }
}
