<?php

namespace App\Enums;

enum RoleEnum: int
{
    case ADMIN = 1;
    case DOCTOR = 2;
    case SUPPORT = 3;
    case USER = 4;

    /**
     * Получить лейбл роли
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::ADMIN => 'admin',
            self::DOCTOR => 'doctor',
            self::SUPPORT => 'support',
            self::USER => 'user',
        };
    }

    /**
     * Получить массив всех значений
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Получить enum по имени роли
     */
    public static function fromName(string $name): ?self
    {
        return match (strtolower($name)) {
            'admin' => self::ADMIN,
            'doctor' => self::DOCTOR,
            'support' => self::SUPPORT,
            'user' => self::USER,
            default => null,
        };
    }
    /**
     * Проверка на администратора
     */
    public function isAdmin(): bool
    {
        return $this === self::ADMIN;
    }

    /**
     * Проверка на врача
     */
    public function isDoctor(): bool
    {
        return $this === self::DOCTOR;
    }

    /**
     * Проверка на базового пользователя
     */
    public function isUserBasic(): bool
    {
        return $this === self::DOCTOR;
    }
}
