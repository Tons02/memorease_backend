<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            "mi" => [
                "string",
            ],
            "lname" => [
                "required",
                "string",
            ],
            "suffix" => [
                "in:Jr,Sr"
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
                "required"
            ],
            "role_id" => ["required", "exists:roles,id"],
        ];
    }
}
