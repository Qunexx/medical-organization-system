<?php

namespace App\Observers;

use app\Enums\ConsultationStatusesEnum;
use App\Mail\ConsultationStatusChangedMail;
use App\Models\Appointment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ConsultationStatusChangedObserver
{

    public function created(Appointment $appointment): void
    {
        $appointment->sendCreationEmail();
    }

    public function updated(Appointment $appointment): void
    {
        if ($appointment->isDirty('status')) {
            $appointment->sendStatusEmail();
        }
    }
}
