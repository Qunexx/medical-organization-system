<?php

declare(strict_types=1);

namespace app\Orchid\Layouts\User\Support;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Layouts\Rows;

class SupportEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        $user = $this->query->get('user');
        $exists = $user->exists;

        $placeholder = $exists
            ? 'Оставьте пустым, если не хотите менять существующий'
            : 'Введите пароль';

        return [
            Input::make('user.first_name')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Имя')
                ->placeholder('Имя'),

            Input::make('user.last_name')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Фамилия')
                ->placeholder('Фамилия'),

            Input::make('user.middle_name')
                ->type('text')
                ->max(255)
                ->required()
                ->title('Отчество')
                ->placeholder('Отчество'),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),

            Password::make('user.password')
                ->placeholder($placeholder)
                ->title(__('Password'))
                ->required(!$exists),
        ];
    }
}
