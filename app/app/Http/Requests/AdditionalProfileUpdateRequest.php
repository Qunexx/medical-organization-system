<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdditionalProfileUpdateRequest extends FormRequest
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
        return [
                'birthday' => 'nullable|date',
                'telegram_account' => [
                    'nullable',
                    'string',
                    'max:255',
                    Rule::unique('users')->ignore(auth()->user()->id)
                ]
            ];
    }

    public function messages(): array
    {
        return [
            'birthday.date' => 'Неверный формат даты рождения.',
            'telegram_account.string' => 'Телеграм аккаунт должен быть строкой.',
            'telegram_account.max' => 'Телеграм аккаунт не должен превышать 255 символов.',
            'telegram_account.unique' => 'Этот телеграм аккаунт уже используется.'
        ];
    }

    public function attributes(): array
    {
        return [
            'birthday' => 'Дата рождения',
            'telegram_account' => 'Телеграм аккаунт'
        ];
    }
}
