<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
{


    public function attributes(): array
    {
        return [
            'name'     => 'Имя',
            'phone'   => 'Телефон',
            'email'    => 'Электронная почта',
            'password' => 'Пароль',
        ];
    }


    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'phone' => [
                'required',
                Rule::unique(User::class, 'phone')->ignore($doctor->user->id ?? null),
               'regex:/^\+7\d{10}$/',
            ],
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed','min:6','max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле Имя обязательно для заполнения.',
            'name.max' => 'Имя не должно превышать 255 символов.',
            'phone.required' => 'Поле Телефон обязательно для заполнения.',
            'phone.unique' => 'Такой номер телефона уже зарегистрирован.',
            'phone.regex' => 'Номер телефона должен быть в формате +7XXXXXXXXXX.',
            'email.required' => 'Поле Электронная почта обязательно для заполнения.',
            'email.string' => 'Электронная почта должна быть строкой.',
            'email.email' => 'Введите корректный адрес электронной почты.',
            'email.max' => 'Электронная почта не должна превышать 255 символов.',
            'email.unique' => 'Такой адрес электронной почты уже зарегистрирован.',
            'password.required' => 'Поле Пароль обязательно для заполнения.',
            'password.confirmed' => 'Пароли не совпадают.',
            'password.min' => 'Пароль должен быть не менее 6 символов.',
            'password.max' => 'Пароль не должен превышать 255 символов.'
        ];
    }
}
