<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            "fname" => [
                "required",
                "string",
            ],
            "lname" => [
                "required",
                "string",
            ],
            "gender" => [
                "in:male,female"
            ],
            "mobile_number" => [
                "unique:users,mobile_number," . $this->route()->user,
                "regex:/^\+63\d{10}$/",
            ],
            "birthday" => [
                "required",
                "date_format:d-m-Y",
            ],
            "address" => [
                "required"
            ],
            "username" => [
                "required",
                "unique:users,username," . $this->route()->user,
            ],
            "email" => [
                "email",
                "required",
                "unique:users,email," . $this->route()->user,
            ],
            'password' => [
                'required',
                'min:4',
                'confirmed'
            ],
        ];
    }
}
