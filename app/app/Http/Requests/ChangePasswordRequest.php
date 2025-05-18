<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
       return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = auth()->user();
        return [
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('Текущий пароль введен неверно');
                    }
                },
            ],
            'password' => [
                'nullable',
                'confirmed',
                Password::min(8),
        ]];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Текущий пароль обязателен для заполнения.',
            'password.required' => 'Новый пароль обязателен для заполнения.',
            'password.confirmed' => 'Пароли не совпадают.',
            'password.min' => 'Пароль должен содержать минимум 8 символов.',
            'password.mixed' => 'Пароль должен содержать заглавные и строчные буквы.',
            'password.numbers' => 'Пароль должен содержать цифры.',
            'password.symbols' => 'Пароль должен содержать специальные символы.',
            'password.uncompromised' => 'Этот пароль слишком распространён. Выберите другой.',
        ];
    }

    public function attributes(): array
    {
        return [
            'current_password' => 'Текущий пароль',
            'password' => 'Новый пароль'
        ];
    }
}
