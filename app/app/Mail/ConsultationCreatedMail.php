<?php

namespace app\Mail;

use app\Enums\ConsultationStatusesEnum;
use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConsultationCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $statusLabel;
    public $consultationUrl;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->statusLabel = ConsultationStatusesEnum::UNCONFIRMED->getLabel();
        $this->consultationUrl = route('patient.appointment.view', $appointment);
    }

    public function build()
    {
        return $this->subject('Ваша консультация успешно создана')
            ->view('mail.ConsultationCreatedMailView');
    }
}
