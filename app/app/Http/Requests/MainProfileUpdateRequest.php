<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MainProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore(auth()->id())],
            'phone' => ['required', 'string', 'regex:/^\+7\d{10}$/']
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Поле Имя обязательно для заполнения.',
            'first_name.string' => 'Имя должно быть строкой.',
            'first_name.max' => 'Имя не должно превышать 255 символов.',
            'last_name.required' => 'Поле Фамилия обязательно для заполнения.',
            'last_name.string' => 'Фамилия должна быть строкой.',
            'last_name.max' => 'Фамилия не должна превышать 255 символов.',
            'middle_name.string' => 'Отчество должно быть строкой.',
            'middle_name.max' => 'Отчество не должно превышать 255 символов.',
            'email.required' => 'Поле Email обязательно для заполнения.',
            'email.email' => 'Введите корректный email адрес.',
            'email.unique' => 'Этот email уже занят.',
            'phone.required' => 'Поле Телефон обязательно для заполнения.',
            'phone.string' => 'Телефон должен быть строкой.',
            'phone.regex' => 'Номер телефона должен быть в формате +7XXXXXXXXXX.'
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'middle_name' => 'Отчество',
            'email' => 'Email',
            'phone' => 'Телефон'
        ];
    }
}
