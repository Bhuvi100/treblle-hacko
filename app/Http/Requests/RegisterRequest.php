<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:254'],
            'email' => ['required', 'string', 'email', 'max:254', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed',
                'regex:/^(?=.*[A-Z].*[A-Z])(?=.*[!@#$&*])(?=.*[0-9].*[0-9])(?=.*[a-z].*[a-z].*[a-z]).*$/', 'pwned'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'The given Email is already registered!',
            'password.regex' => 'Please enter a password with atleast two uppercase letters, three lowercase letters, one special character and two digits!'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
