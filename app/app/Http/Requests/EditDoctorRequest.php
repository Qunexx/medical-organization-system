<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EditDoctorRequest extends FormRequest
{
    protected $doctor;

    protected function prepareForValidation()
    {
        $this->doctor = $this->route('doctor') ?? new Doctor();
        if ($this->has('user.phone')) {
            $phone = preg_replace('/\D/', '', $this->input('user.phone'));
            if (str_starts_with($phone, '8')) {
                $phone = '7'.substr($phone, 1);
            }
            $this->merge([
                'user' => array_merge($this->input('user'), [
                    'phone' => '+'.$phone
                ])
            ]);
        }
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = optional($this->doctor->user)->id;

        return [
            'user.first_name' => 'required|string|max:255',
            'user.last_name' => 'required|string|max:255',
            'user.email' => [
                'required',
                'email',
                Rule::unique(User::class, 'email')->ignore($userId)
            ],
            'user.phone' => [
                'required',
                'string',
                'regex:/^\+7\d{10}$/',
                Rule::unique(User::class, 'phone')->ignore($userId)
            ],
            'user.password' => [
                Rule::requiredIf(!$this->doctor->exists),
                'nullable',
                'string',
                'min:8',
            ],
            'doctor.years_of_experience' => 'nullable|numeric|min:0',
            'doctor.specializations' => 'required|array|min:1',
            'doctor.specializations.*' => 'exists:specializations,id',
            'doctor.services' => 'required|array|min:1',
            'doctor.services.*' => 'exists:services,id',
        ];
    }

    public function messages(): array
    {
        return [
            'user.first_name.required' => 'Поле Имя обязательно для заполнения.',
            'user.last_name.required' => 'Поле Фамилия обязательно для заполнения.',

            'user.email.required' => 'Поле Email обязательно для заполнения.',
            'user.email.email' => 'Введите корректный email адрес.',
            'user.email.unique' => 'Этот email уже занят.',

            'user.phone.required' => 'Поле Телефон обязательно для заполнения.',
            'user.phone.regex' => 'Телефон должен быть в формате +7XXXXXXXXXX.',
            'user.phone.unique' => 'Этот телефон уже занят.',

            'user.password.required' => 'Пароль обязателен для нового врача.',
            'user.password.min' => 'Пароль должен быть не менее 8 символов.',
            'user.password.confirmed' => 'Пароли не совпадают.',

            'doctor.years_of_experience.numeric' => 'Стаж должен быть числом.',
            'doctor.years_of_experience.min' => 'Стаж не может быть отрицательным.',

            'doctor.specializations.required' => 'Выберите хотя бы одну специализацию.',
            'doctor.specializations.*.exists' => 'Выбрана несуществующая специализация.',

            'doctor.services.required' => 'Выберите хотя бы одну услугу.',
            'doctor.services.*.exists' => 'Выбрана несуществующая услуга.',
        ];
    }

    public function attributes(): array
    {
        return [
            'user.first_name' => 'Имя',
            'user.last_name' => 'Фамилия',
            'user.email' => 'Email',
            'user.phone' => 'Телефон',
            'user.password' => 'Пароль',
            'doctor.years_of_experience' => 'Стаж работы',
            'doctor.specializations' => 'Специализации',
            'doctor.services' => 'Услуги',
        ];
    }
}
