<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationChangeRequest extends FormRequest
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
            'access_email_notify' => 'boolean',
            'access_telegram_notify' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'access_email_notify.boolean' => 'Уведомления по email должны быть включены или выключены.',
            'access_telegram_notify.boolean' => 'Уведомления в Telegram должны быть включены или выключены.'
        ];
    }
}
