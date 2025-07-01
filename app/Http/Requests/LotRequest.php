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
            "lot_number" => [
                "required",
                "string",
                Rule::unique('lots', 'lot_number')->ignore($this->route('id')),
            ],
            "coordinates" => [
                "required",
                "array",
            ],
            "status" => [
                "in:available,pending,reserved,hold"
            ],
            "reserved_until" => [
                "nullable",
            ],
            "price" => [
                "required",
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
}
