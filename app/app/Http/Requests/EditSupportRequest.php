<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditSupportRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->user = $this->route('user') ?? new User();
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user.first_name' => 'required|string|max:255',
            'user.last_name' => 'required|string|max:255',
            'user.middle_name' => 'required|string|max:255',
            'user.email' => [
                'required',
                'email',
                Rule::unique(User::class, 'email')->ignore($this->user->id)
            ],
            'user.password' => [
                Rule::requiredIf(!$this->user->exists),
                'nullable',
                'string',
                'min:8',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'user.first_name.required' => 'Поле Имя обязательно для заполнения.',
            'user.first_name.string' => 'Имя должно быть строкой.',
            'user.first_name.max' => 'Имя не должно превышать 255 символов.',

            'user.last_name.required' => 'Поле Фамилия обязательно для заполнения.',
            'user.last_name.string' => 'Фамилия должна быть строкой.',
            'user.last_name.max' => 'Фамилия не должна превышать 255 символов.',

            'user.middle_name.required' => 'Поле Отчество обязательно для заполнения.',
            'user.middle_name.string' => 'Отчество должно быть строкой.',
            'user.middle_name.max' => 'Отчество не должно превышать 255 символов.',

            'user.email.required' => 'Поле Email обязательно для заполнения.',
            'user.email.email' => 'Введите корректный email адрес.',
            'user.email.unique' => 'Этот email уже занят.',

            'user.password.required' => 'Пароль обязателен для заполнения.',
            'user.password.string' => 'Пароль должен быть строкой.',
            'user.password.min' => 'Пароль должен содержать минимум 8 символов.',
            'user.password.confirmed' => 'Пароли не совпадают.',
        ];
    }

    public function attributes(): array
    {
        return [
            'user.first_name' => 'Имя',
            'user.last_name' => 'Фамилия',
            'user.middle_name' => 'Отчество',
            'user.email' => 'Email',
            'user.password' => 'Пароль',
        ];
    }
}
