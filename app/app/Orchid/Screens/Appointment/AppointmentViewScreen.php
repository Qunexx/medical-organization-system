<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Appointment;

use App\Enums\ConsultationStatusesEnum;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class AppointmentViewScreen extends Screen
{
    public $appointment;

    public function query(Appointment $appointment): iterable
    {

        $this->appointment = $appointment?->load([
            'doctor',
            'user',
            'specialization',
        ]);

        return [
            'appointment' => $this->appointment,
        ];
    }

    public function name(): ?string
    {
        return $this->appointment ? "Консультация #{$this->appointment->id}" : '';
    }

    public function description(): ?string
    {
        return 'Детальная информация о консультации';
    }

    public function commandBar(): iterable
    {

        if (!$this->appointment) {
            return [];
        }

        return [
            Link::make('Назад')
                ->icon('arrow-left')
                ->route('platform.appointment'),

            DropDown::make('Изменить статус')
                ->icon('bs.arrow-repeat')
                ->list([
                    Button::make(ConsultationStatusesEnum::ACCEPTED->getLabel())
                        ->method('changeStatus', ['status' => ConsultationStatusesEnum::ACCEPTED->value])
                        ->canSee($this->appointment->status !== ConsultationStatusesEnum::ACCEPTED),

                    Button::make(ConsultationStatusesEnum::CONFIRMED->getLabel())
                        ->method('changeStatus', ['status' => ConsultationStatusesEnum::CONFIRMED->value])
                        ->canSee($this->appointment->status !== ConsultationStatusesEnum::CONFIRMED),

                    Button::make(ConsultationStatusesEnum::COMPLETED->getLabel())
                        ->method('changeStatus', ['status' => ConsultationStatusesEnum::COMPLETED->value])
                        ->canSee($this->appointment->status !== ConsultationStatusesEnum::COMPLETED)
                        ->modal('conclusionModal'),

                    Button::make(ConsultationStatusesEnum::DECLINED->getLabel())
                        ->method('changeStatus', ['status' => ConsultationStatusesEnum::DECLINED->value])
                        ->canSee($this->appointment->status !== ConsultationStatusesEnum::DECLINED)
                        ->modal('cancelModal'),

                    Button::make(ConsultationStatusesEnum::UNCONFIRMED->getLabel())
                        ->method('changeStatus', ['status' => ConsultationStatusesEnum::UNCONFIRMED->value])
                        ->canSee($this->appointment->status !== ConsultationStatusesEnum::UNCONFIRMED),
                ]),

            ModalToggle::make('Заполнить заключение')
                ->modal('conclusionModal')
                ->icon('bs.file-text')
                ->method('saveConclusion')
                ->canSee($this->appointment->status == ConsultationStatusesEnum::COMPLETED->value),

            ModalToggle::make('Указать причину отмены')
                ->modal('cancelModal')
                ->icon('bs.x-circle')
                ->method('saveCancelReason')
                ->canSee($this->appointment->status === ConsultationStatusesEnum::DECLINED->value),

            ModalToggle::make('Перенести')
                ->modal('rescheduleModal')
                ->icon('bs.calendar')
                ->method('reschedule')
                ->canSee($this->appointment->status !== ConsultationStatusesEnum::COMPLETED->value),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->confirm('Удаление консультации невозможно отменить'),
        ];
    }

    public function layout(): iterable
    {

        return [
            Layout::modal('rescheduleModal', [
                Layout::rows([
                    DateTimer::make('appointment.appointment_date')
                        ->title('Новая дата и время консультации')
                        ->required()
                        ->enableTime()
                        ->format('Y-m-d H:i')
                ])
            ]),
            Layout::modal('conclusionModal', [
                Layout::rows([
                    \Orchid\Screen\Fields\TextArea::make('conclusion')
                        ->title('Медицинское заключение')
                        ->required()
                        ->rows(10)
                        ->value($this->appointment->conclusion),
                ])
            ])->title('Заполнение заключения')
                ->applyButton('Сохранить'),

            Layout::modal('cancelModal', [
                Layout::rows([
                    \Orchid\Screen\Fields\TextArea::make('cancel_reason')
                        ->title('Причина отмены')
                        ->required()
                        ->rows(5)
                        ->value($this->appointment->cancel_reason),
                ])
            ])->title('Указание причины отмены')
                ->applyButton('Сохранить'),

            Layout::legend('appointment', [
                Sight::make('id', 'ID'),

                Sight::make('patient_info', 'Данные пациента')->render(function () {
                    return "
                        <div class='space-y-1'>
                            <div class='font-medium'>{$this->appointment->patient_name}</div>
                            <div class='text-sm text-gray-500'>{$this->appointment->patient_phone}</div>
                            <div class='text-sm text-gray-500'>{$this->appointment->patient_email}</div>
                            ".($this->appointment->user ? "
                            <div class='mt-2'>
                                <a href='".route('platform.patient.view', $this->appointment->user_id)."'
                                   class='text-primary hover:underline'>
                                    Полный профиль пациента
                                </a>
                            </div>" : "")."
                        </div>
                    ";
                }),

                Sight::make('doctor_info', 'Врач')->render(function () {
                    return "
                        <div class='space-y-1'>
                            <div class='font-medium'>{$this->appointment->doctor->user->full_name}</div>
                            <div class='text-sm text-gray-500'>{$this->appointment->specialization->name}</div>
                            <div class='mt-2'>
                                <a href='".route('platform.doctor.view', $this->appointment->doctor->user->id)."'
                                   class='text-primary hover:underline'>
                                    Профиль врача
                                </a>
                            </div>
                        </div>
                    ";
                }),

                Sight::make('appointment_date', 'Дата и время')
                    ->render(fn () => $this->appointment->appointment_date),

                Sight::make('status', 'Статус')
                    ->render(function () {
                        $statuses = [
                            1 => ['text' => 'Принята', 'color' => 'success'],
                            2 => ['text' => 'Отменена', 'color' => 'danger'],
                            3 => ['text' => 'Подтверждена', 'color' => 'info'],
                            4 => ['text' => 'Не подтверждена', 'color' => 'warning'],
                            5 => ['text' => 'Завершена', 'color' => 'secondary'],
                        ];

                        return "<span class='badge bg-{$statuses[$this->appointment->status]['color']}'>
                        {$statuses[$this->appointment->status]['text']}
                    </span>";
                    }),

                Sight::make('created_at', 'Создана'),

                Sight::make('patient_comment', 'Комментарий пациента')
                    ->render(fn () => $this->appointment->patient_comment ?: 'Нет комментария'),
            ])->title('Основная информация'),

            Layout::legend('appointment', [
                Sight::make('medical_info', 'Медицинские данные')->render(function () {
                    $html = "<div class='space-y-4'>";

                    if ($this->appointment->conclusion) {
                        $html .= "
                            <div>
                                <div class='text-sm text-gray-500 mb-1'>Заключение:</div>
                                <div class='whitespace-pre-wrap p-3 bg-gray-50 rounded'>
                                    {$this->appointment->conclusion}
                                </div>
                            </div>
                        ";
                    }

                    if ($this->appointment->cancel_reason) {
                        $html .= "
                            <div>
                                <div class='text-sm text-gray-500 mb-1'>Причина отмены:</div>
                                <div class='text-red-600 p-3 bg-red-50 rounded'>
                                    {$this->appointment->cancel_reason}
                                </div>
                            </div>
                        ";
                    }

                    $html .= "</div>";
                    return $html;
                }),
            ])->title('Медицинская информация'),
        ];
    }

    public function changeStatus(int $status)
    {
        $enumStatus = ConsultationStatusesEnum::from($status);
        $this->appointment->update(['status' => $enumStatus]);

        Toast::info("Статус изменен на: " . $enumStatus->getLabel());
        return back();
    }

    public function saveConclusion()
    {
        $this->appointment->update([
            'conclusion' => request('conclusion')
        ]);
        Toast::success('Заключение успешно сохранено');
        return back();
    }

    public function saveCancelReason()
    {
        $this->appointment->update([
            'cancel_reason' => request('cancel_reason')
        ]);
        Toast::success('Причина отмены сохранена');
        return back();
    }

    public function remove()
    {
        $this->appointment->delete();
        Toast::info('Консультация удалена');
        return redirect()->route('platform.appointments.list');
    }

    public function reschedule(Request $request)
    {
        $request->validate([
            'appointment.appointment_date' => 'required|date|after:now'
        ]);

        $this->appointment->update([
            'appointment_date' => $request->input('appointment.appointment_date')
        ]);

        Toast::success('Консультация успешно перенесена');
        return back();
    }
}
