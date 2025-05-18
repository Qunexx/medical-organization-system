<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use Illuminate\Foundation\Http\FormRequest;

class MakeAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $request = $this->request();
        return [
            'doctor_id' => 'required|exists:doctors,id',
            'date' => [
                'required',
                'date',
                'after_or_equal:today'
            ],
            'time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    Appointment::validateTimeSlot(
                        $this->date,
                        $this->doctor_id,
                        $value,
                        $fail
                    );
                },
            ],
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'specialty' => 'required|string',
            'email' => 'required|email|max:255',
            'comment' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'doctor_id.required' => 'Поле Врач обязательно для заполнения.',
            'doctor_id.exists' => 'Выбранный врач не существует.',
            'date.required' => 'Поле Дата обязательно для заполнения.',
            'date.date' => 'Неверный формат даты.',
            'date.after_or_equal' => 'Дата не может быть в прошлом.',
            'time.required' => 'Поле Время обязательно для заполнения.',
            'time.date_format' => 'Неверный формат времени. Используйте формат ЧЧ:ММ.',
            'name.required' => 'Поле Имя обязательно для заполнения.',
            'name.string' => 'Имя должно быть строкой.',
            'name.max' => 'Имя не должно превышать 255 символов.',
            'phone.required' => 'Поле Телефон обязательно для заполнения.',
            'phone.string' => 'Телефон должен быть строкой.',
            'phone.max' => 'Телефон не должен превышать 20 символов.',
            'specialty.required' => 'Поле Специальность обязательно для заполнения.',
            'specialty.string' => 'Специальность должна быть строкой.',
            'email.required' => 'Поле Email обязательно для заполнения.',
            'email.email' => 'Введите корректный email адрес.',
            'email.max' => 'Email не должен превышать 255 символов.',
            'comment.string' => 'Комментарий должен быть строкой.',
            'comment.max' => 'Комментарий не должен превышать 500 символов.',
        ];
    }

    public function attributes(): array
    {
        return [
            'doctor_id' => 'Врач',
            'date' => 'Дата',
            'time' => 'Время',
            'specialty' => 'Специальность',
        ];
    }
}
