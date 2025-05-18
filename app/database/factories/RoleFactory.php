<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->jobTitle,
            'slug' => $this->faker->unique()->slug,
            'permissions' => [],
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

    public function admin()
    {
        return $this->state([
            'slug' => 'admin',
            'name' => 'Администратор',
            'permissions' => [
                "platform.index" => "1",
                "platform.systems.roles" => "1",
                "platform.systems.users" => "1",
                "platform.systems.attachment" => "1"
            ],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function doctor()
    {
        return $this->state([
            'slug' => 'doctor',
            'name' => 'Врач',
            'permissions' => [
                "platform.index" => "1",
                "platform.systems.users" => "1",
            ],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function support()
    {
        return $this->state([
            'slug' => 'support',
            'name' => 'Поддержка',
            'permissions' => [
                "platform.index" => "1",
                "platform.systems.roles" => "1",
                "platform.systems.users" => "1",
                "platform.systems.attachment" => "1"
            ],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function user()
    {
        return $this->state([
            'slug' => 'user',
            'name' => 'Пользователь',
            'permissions' => [
            ],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
