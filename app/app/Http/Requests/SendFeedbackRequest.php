<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendFeedbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fio' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000'
        ];
    }

    public function messages(): array
    {
        return [
            'fio.required' => 'Поле ФИО обязательно для заполнения.',
            'fio.string' => 'ФИО должно быть строкой.',
            'fio.max' => 'ФИО не должно превышать 255 символов.',
            'email.required' => 'Поле Email обязательно для заполнения.',
            'email.email' => 'Введите корректный адрес электронной почты.',
            'subject.string' => 'Тема должна быть строкой.',
            'subject.max' => 'Тема не должна превышать 255 символов.',
            'message.required' => 'Поле Сообщение обязательно для заполнения.',
            'message.string' => 'Сообщение должно быть текстом.',
            'message.max' => 'Сообщение не должно превышать 2000 символов.'
        ];
    }
}
