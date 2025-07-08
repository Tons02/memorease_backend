<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReservationRequest extends FormRequest
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
            'lot_id' => ['required', Rule::exists('lots', 'id')->where('status', 'available')],
            "user_id" => ["required", "exists:users,id"],
            'total_downpayment_price' => [
                'required',
                'numeric',
                'regex:/^\d{1,15}(\.\d{1,2})?$/',
            ],
            "proof_of_payment" => ["required"],
        ];
    }
}
