<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition()
    {
        $services = [
            'Консультация кардиолога',
            'УЗИ брюшной полости',
            'Эндоскопическое исследование ЖКТ',
            'Лабораторная диагностика крови',
            'Магнитно-резонансная томография',
            'Физиотерапевтические процедуры',
            'Стоматологический осмотр',
            'Офтальмологическое обследование',
            'ЛФК и реабилитация',
            'Плановый медосмотр'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($services),
            'description' => $this->faker->paragraph(3),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
