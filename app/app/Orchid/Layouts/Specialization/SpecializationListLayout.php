<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Specialization;

use App\Models\Feedback;
use App\Models\Service;
use App\Models\Specialization;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SpecializationListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'specializations';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id', 'Id')
                ->sort()
                ->cantHide()
                ->filter(Input::make())
            ,

            TD::make('name', 'Название')
                ->cantHide()
                ->filter(Input::make()),

            TD::make('description', 'Описание')
                ->cantHide()
                ->filter(Input::make()),

            TD::make('created_at', 'Создана')
                ->usingComponent(DateTimeSplit::class)
            ,
            TD::make('updated_at', 'Изменена')
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
            ,

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Specialization $specialization) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Button::make('Удалить')
                            ->icon('bs.trash3')
                            ->confirm('После удаления специализацию придётся создавать по новой')
                            ->method('remove', [
                                'id' => $specialization->id,
                            ]),

                        Link::make('Редактировать')
                            ->icon('bs.eye')
                            ->route('platform.specialization.edit', $specialization),
                    ])),
        ];
    }
}
