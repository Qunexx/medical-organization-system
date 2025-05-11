<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User\Doctor;

use App\Models\Service;
use App\Models\Specialization;
use App\Models\User;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Date;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

class DoctorEditLayout extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('user.last_name')
                ->title('Фамилия')
                ->required(),

            Input::make('user.first_name')
                ->title('Имя')
                ->required(),

            Input::make('user.middle_name')
                ->title('Отчество'),

            Input::make('user.phone')
                ->title('Телефон')
                ->mask('+7 (999) 999-99-99')
                ->required(),

            DateTimer::make('user.birthday')
                ->title('Дата рождения')
                ->format('Y-m-d'),

            Input::make('user.telegram_account')
                ->title('Telegram аккаунт')
                ->placeholder('@username'),

            Input::make('user.email')
                ->type('email')
                ->title('Email')
                ->required(),

            Password::make('user.password')
                ->title('Пароль')
                ->min(8)
                ->required(!$this->query->get('doctor')?->exists),

            Input::make('avatar')
                ->type('file')
                ->title('Аватар')
                ->acceptedFiles('image/*')
                ->help('Максимальный размер: 2MB')

                ,

            CheckBox::make('remove_avatar')
                ->sendTrueOrFalse()
                ->title('Удалить текущий аватар')
                ->help('Отметьте чтобы удалить текущий аватар'),

            Input::make('doctor.years_of_experience')
                ->type('number')
                ->required()
                ->title('Опыт работы (лет)')
                ->min(0)
                ->max(60),

            Input::make('doctor.description')
                ->type('textarea')
                ->title('Описание доктора')
                ->rows(5),

            Relation::make('doctor.specializations')
                ->fromModel(Specialization::class, 'name')
                ->required()
                ->title('Специализации')
                ->multiple(),

            Relation::make('doctor.services')
                ->fromModel(Service::class, 'name')
                ->required()
                ->title('Медицинские услуги')
                ->multiple(),
        ];
    }
}
