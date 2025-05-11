<?php

namespace app\Enums;

enum ConsultationStatusesEnum: int
{
    case ACCEPTED = 1;
    case DECLINED = 2;
    case CONFIRMED = 3;
    case UNCONFIRMED = 4;
    case COMPLETED = 5;

    /**
     * Получить лейбл роли
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::ACCEPTED => 'Принята',
            self::DECLINED => 'Отменена',
            self::CONFIRMED => 'Подтверждена',
            self::UNCONFIRMED => 'Не подтверждена',
            self::COMPLETED => 'Завершена',
        };
    }

    /**
     * Получить массив всех значений
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
