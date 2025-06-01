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
                'chat_id' => [
                    'nullable',
                    'numeric',
                    Rule::unique('users')->ignore(auth()->user()->id)
                ]
            ];
    }

    public function messages(): array
    {
        return [
            'birthday.date' => 'Неверный формат даты рождения.',
            'chat_id.numeric' => 'Чат айди должен быть числом',
            'chat_id.unique' => 'Этот телеграм аккаунт уже используется.'
        ];
    }

    public function attributes(): array
    {
        return [
            'birthday' => 'Дата рождения',
            'chat_id' => 'Телеграм чат id'
        ];
    }
}
