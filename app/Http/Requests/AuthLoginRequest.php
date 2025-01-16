<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'The field email is required.',
            'email.email' => 'The email is invalid.',
            'password.required' => 'The field password is required.',
            'password.min' => 'The password must have at least 6 digits.',
        ];        
    }
}
