<?php

namespace App\Mail;

use App\Enums\ConsultationStatusesEnum;
use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConsultationStatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $consultationUrl;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->consultationUrl = route('patient.appointment.view', $appointment);
    }

    public function build()
    {
        $subject = match ($this->appointment->status) {
            ConsultationStatusesEnum::ACCEPTED->value => 'Ваша консультация принята',
            ConsultationStatusesEnum::DECLINED->value => 'Консультация отменена',
            ConsultationStatusesEnum::CONFIRMED->value => 'Консультация подтверждена',
            ConsultationStatusesEnum::COMPLETED->value => 'Консультация завершена',
            default => 'Обновление статуса консультации',
        };

        return $this->subject($subject)
            ->view('mail.ConsultationStatusChangedMailView');
    }
}
