<?php

declare(strict_types=1);

namespace app\Orchid\Layouts\Review;

use app\Models\Feedback;
use App\Models\Review;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ReviewListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'reviews';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id', 'ID')
                ->sort()
                ->filter(Input::make())
                ->width('80px'),

            TD::make('text', 'Текст')
                ->render(function ($review) {
                    return Str::limit($review->text, 100);
                }),

            TD::make('user_id', 'Пациент')
                ->render(function ($review) {
                    return "<a href='".route('platform.patient.view', $review->user)."'
                   class='text-blue-600 hover:underline'>
                   {$review->user->full_name}
                </a>";
                }),

            TD::make('appointment_id', 'Запись')
                ->render(function ($review) {
                    return "<a href='".route('platform.appointment.view', $review->appointment)."'
                   class='text-blue-600 hover:underline'>
                   #{$review->appointment_id}
                </a>";
                }),

            TD::make('created_at', 'Дата')
                ->render(function ($review) {
                    return $review->created_at->format('d.m.Y H:i');
                }),

            TD::make('Действия')
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function ($review) {
                    return Button::make('Удалить')
                        ->icon('trash')
                        ->confirm('Вы уверены?')
                        ->method('delete', [
                            'id' => $review->id
                        ]);
                }),
        ];
    }
}
