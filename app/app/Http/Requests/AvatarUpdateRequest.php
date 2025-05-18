<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvatarUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'avatar' => 'required|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'avatar.required' => 'Необходимо выбрать файл аватара.',
            'avatar.image' => 'Файл должен быть изображением (jpeg, png, bmp, gif, svg или webp).',
            'avatar.max' => 'Максимальный размер файла — 2 МБ.'
        ];
    }

    public function attributes(): array
    {
        return [
            'avatar' => 'Аватар'
        ];
    }
}
