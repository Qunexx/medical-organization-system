<?php

declare(strict_types=1);

namespace app\Orchid\Layouts\Specialization;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class SpecializationEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('specialization.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('specialization.description')
                ->type('text')
                ->max(255)
                ->title('Описание')
                ->placeholder('Описание'),
        ];
    }
}
