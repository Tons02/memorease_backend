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
                Rule::unique('lots', 'lot_number')
                    ->ignore($this->route('id'))
                    ->whereNull('deleted_at'),
            ],
            'lot_image' => [
                'required',              // Make it required (optional if not mandatory)
                'file',                  // Ensure it's a file
                'image',                 // Ensure it's an image
                'mimes:jpeg,png,jpg,gif', // Allowed types
                'max:10120',              // Max size in KB (5MB)
            ],
            "coordinates" => [
                "required",
            ],
            "status" => [
                "in:available,pending,reserved,sold"
            ],
            "reserved_until" => [
                "nullable",
            ],
            'price' => [
                'required',
                'numeric',
                'regex:/^\d{1,10}(\.\d{1,2})?$/',
            ],
            'downpayment_price' => [
                'required',
                'numeric',
                'regex:/^\d{1,10}(\.\d{1,2})?$/',
                'lte:price',
            ],
            "promo_price" => [
                "nullable",
            ],
            "promo_until" => [
                "nullable",
            ],
            "is_featured" => [
                "nullable",
                "required",
            ],
        ];
    }

    public function messages()
    {
        return [
            'lot_image.required' => 'Please upload an image for the lot.',
            'lot_image.image' => 'The file must be an image.',
            'lot_image.mimes' => 'Only jpeg, png, jpg, and gif files are allowed.',
            'lot_image.max' => 'The image size must not exceed 5MB.',
        ];
    }
}
