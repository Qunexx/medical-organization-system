<?php

declare(strict_types=1);

namespace app\Orchid\Layouts\Service;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class ServiceEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('service.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('service.description')
                ->type('text')
                ->max(255)
                ->title('Описание')
                ->placeholder('Описание'),
        ];
    }
}
