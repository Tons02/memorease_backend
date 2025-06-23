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
                "nullable",
                "string",
            ],
            "lname" => [
                "required",
                "string",
            ],
            "suffix" => [
                "nullable",
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
            "user_type" => [
                "in:male,female"
            ],
            "role_id" => ["required", "exists:roles,id"],
        ];
    }
}
