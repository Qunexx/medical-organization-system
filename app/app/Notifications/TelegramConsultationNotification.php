<?php

namespace App\Notifications;

use App\Enums\ConsultationStatusesEnum;
use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramConsultationNotification extends Notification
{
    use Queueable;

    public $statusLabel;
    public function __construct(public Appointment $appointment, public string $userTelegram, public bool $isCreated)
    {
        $this->statusLabel = ConsultationStatusesEnum::from($this->appointment->status)->getLabel();
    }

    public function via($notifiable): array
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        $url = route('patient.appointment.view', $this->appointment);

        if ($this->isCreated === true) {
            return $this->buildCreatedMessage($url);
        }

        return $this->buildStatusChangedMessage($url);
    }

    protected function buildCreatedMessage(string $url): TelegramMessage
    {
        return TelegramMessage::create()
            ->to($this->userTelegram)
            ->line("Здравствуйте, {$this->appointment->patient_name}!")
            ->line("Ваша консультация успешно создана.")
            ->line("Текущий статус: *{$this->statusLabel}*")
            ->line("Мы уведомим вас о изменении статуса:")
            ->line("- По электронной почте")
            ->line("- По телефону: {$this->appointment->patient_phone}")
            ->line("- Через Telegram-уведомление")
            ->line("")
            ->line("Детали консультации:")
            ->line("- Специализация: {$this->appointment->specialization->name}")
            ->line("- Врач: {$this->appointment->doctor->user->full_name}")
            ->line("- Дата создания: {$this->appointment->created_at}")
            ->line("- Ваш комментарий: {$this->appointment->patient_comment}")
            ->button('Посмотреть консультацию', $url)
            ->line("\n\nС уважением, \n*MedInformSystem Bot*");
    }

    protected function buildStatusChangedMessage(string $url): TelegramMessage
    {
        $message = TelegramMessage::create()
            ->to($this->userTelegram)
            ->line("Здравствуйте, {$this->appointment->patient_name}!")
            ->line("Статус вашей консультации изменен на: *{$this->appointment->status->getLabel()}*");

        if ($this->appointment->status === ConsultationStatusesEnum::CONFIRMED) {
            $message->line("Дата и время: {$this->appointment->appointment_date}");
        }

        if ($this->appointment->status === ConsultationStatusesEnum::DECLINED && $this->appointment->cancel_reason) {
            $message->line("Причина отмены: {$this->appointment->cancel_reason}");
        }

        if ($this->appointment->status === ConsultationStatusesEnum::COMPLETED) {
            $message->line("Заключение врача: {$this->appointment->conclusion}");
        }

        return $message->button('Посмотреть консультацию', $url)
            ->line("\n\nС уважением, \n*MedInformSystem Bot*");
    }
}
