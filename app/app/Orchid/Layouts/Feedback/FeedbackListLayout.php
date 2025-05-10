<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Feedback;

use app\Models\Feedback;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class FeedbackListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'feedbacks';

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

            TD::make('email', 'email')
                ->cantHide()
                ->filter(Input::make()),

            TD::make('fio', 'ФИО')
                ->cantHide()
                ->filter(Input::make()),

            TD::make('subject', 'Тема')
                ->cantHide()
                ->filter(Input::make()),

            TD::make('message', 'Сообщение')
                ->cantHide()
                ->filter(Input::make()),

            TD::make('created_at', 'Отправлено')
                ->usingComponent(DateTimeSplit::class)
            ,
            TD::make('processed_at', 'Обработано')
                ->usingComponent(DateTimeSplit::class)
                ->align(TD::ALIGN_RIGHT)
                ->render(function ($feedback) {
                    return $feedback->processed_at
                        ? '<div class="text-success-500">'. $feedback->processed_at.'</div>'
                        : '<div class="text-danger-500">Требует обработки</div>';
                })
            ,

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Feedback $feedback) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Button::make('Удалить')
                            ->icon('bs.trash3')
                            ->confirm('После удаления обратную связь уже не вернуть')
                            ->method('remove', [
                                'id' => $feedback->id,
                            ]),

                        Link::make('Посмотреть')
                            ->icon('bs.eye')
                            ->route('platform.feedback.view', $feedback),
                    ])),
        ];
    }
}
