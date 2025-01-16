<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The field name is required.',
            'name.string' => 'The field name is invalid.',
            'email.required' => 'The field email is required.',
            'email.unique' => 'This email is already in use.',
            'email.email' => 'The email is invalid.',
            'password.required' => 'The field password is required.',
            'password.min' => 'The password must have at least 6 digits.',
        ];        
    }
}
