<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email'    => 'required|email',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'password.required'  => 'Заповніть пароль',
            'email.required'  => 'Заповніть емейл',
            'email.email'  => 'Емейл веден не коректно',
        ];
    }
}
