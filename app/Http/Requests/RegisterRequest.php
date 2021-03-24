<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Заповніть нікнейм',
            'password.required'  => 'Заповніть пароль',
            'email.required'  => 'Заповніть емейл',
            'email.email'  => 'Емейл веден не коректно',
            'email.unique'  => 'Даний емейл зайнятий',
        ];
    }
}
