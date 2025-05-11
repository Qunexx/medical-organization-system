<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Appointment;

use App\Models\Appointment;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Components\Cells\DateTimeSplit;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class AppointmentListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'appointments';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('id', 'ID')
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->width('100px'),

            TD::make('appointment_date', 'Дата и время')
                ->usingComponent(DateTimeSplit::class)
                ->sort()
                ->align(TD::ALIGN_LEFT),

            TD::make('patient_name', 'Пациент')
                ->filter(Input::make())
                ->sort(),

            TD::make('doctor.user.last_name', 'Врач')
                ->render(function (Appointment $appointment) {
                    return $appointment->doctor->user->full_name;
                })
                ->sort(),

            TD::make('status', 'Статус')
                ->render(function (Appointment $appointment) {
                    $statuses = [
                        1 => ['text' => 'Принята', 'color' => 'success'],
                        2 => ['text' => 'Отменена', 'color' => 'danger'],
                        3 => ['text' => 'Подтверждена', 'color' => 'info'],
                        4 => ['text' => 'Не подтверждена', 'color' => 'warning'],
                        5 => ['text' => 'Завершена', 'color' => 'secondary'],
                    ];

                    return "<span class='badge bg-{$statuses[$appointment->status]['color']}'>
                        {$statuses[$appointment->status]['text']}
                    </span>";
                })
                ->sort(),

            TD::make('created_at', 'Создана')
              ,

            TD::make(__('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->width('150px')
                ->render(fn (Appointment $appointment) => DropDown::make()
                    ->icon('bs.three-dots-vertical')
                    ->list([
                        Link::make('Детали')
                            ->icon('bs.eye')
                            ->route('platform.appointment.view', $appointment),

                        Button::make('Удалить')
                            ->icon('bs.trash3')
                            ->confirm('Вы уверены, что хотите удалить запись?')
                            ->method('remove', [
                                'id' => $appointment->id,
                            ]),
                    ])),
        ];
    }
}
