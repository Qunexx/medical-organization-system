<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Service;

use App\Models\Feedback;
use App\Models\Service;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ServiceListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'services';

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
                ->render(fn (Service $service) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Button::make('Удалить')
                            ->icon('bs.trash3')
                            ->confirm('После удаления услугу придётся создавать по новой')
                            ->method('remove', [
                                'id' => $service->id,
                            ]),

                        Link::make('Редактировать')
                            ->icon('bs.eye')
                            ->route('platform.service.edit', $service),
                    ])),
        ];
    }
}
