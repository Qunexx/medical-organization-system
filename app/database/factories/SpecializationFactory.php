<?php

namespace Database\Factories;

use App\Models\Specialization;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecializationFactory extends Factory
{
    protected $model = Specialization::class;

    public function definition()
    {
        $specializations = [
            'Кардиология',
            'Неврология',
            'Гастроэнтерология',
            'Дерматология',
            'Офтальмология',
            'Ортопедия'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($specializations),
            'description' => $this->faker->paragraph,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
