<?php

namespace App\Models;

use App\Enums\ConsultationStatusesEnum;
use App\Mail\ConsultationCreatedMail;
use App\Mail\ConsultationStatusChangedMail;
use App\Notifications\TelegramConsultationNotification;
use App\Observers\ConsultationStatusChangedObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;


#[ObservedBy([ConsultationStatusChangedObserver::class])]
class Appointment extends Model
{
    use AsSource, Filterable, Chartable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'doctor_id',
        'appointment_date',
        'status',
        'patient_name',
        'patient_phone',
        'patient_email',
        'patient_comment',
        'cancel_reason',
        'conclusion',
        'specialization_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public static function validateTimeSlot($requestDate, $requestDoctorId, $value, $fail)
    {
        $date = Carbon::parse($requestDate);
        $time = Carbon::parse($value);

        if ($time->lt('08:00') || $time->gt('20:00')) {
            $fail('Выберите время между 08:00 и 20:00');
        }

        $existing = Appointment::where('doctor_id', $requestDoctorId)
            ->whereDate('appointment_date', $date)
            ->whereTime('appointment_date', $time->format('H:i'))
            ->exists();

        if ($existing) {
            $fail('Это время уже занято');
        }
    }

    public function sendCreationEmail(): void
    {
        if ($this->user->access_email_notify) {
            try {
                Mail::to($this->patient_email)
                    ->send(new ConsultationCreatedMail($this));
            } catch (\Exception $e) {
                Log::error("Ошибка отправки письма о создании консультации {$this->id}: " . $e->getMessage());
            }
        }
    }

    public function sendStatusEmail(): void
    {
        if ($this->user->access_email_notify) {
            try {
                if ($this->status !== ConsultationStatusesEnum::UNCONFIRMED->value) {
                    Mail::to($this->patient_email)
                        ->send(new ConsultationStatusChangedMail($this));
                }
            } catch (\Exception $e) {
                Log::error("Ошибка отправки письма для консультации {$this->id}: " . $e->getMessage());
            }
        }
    }

    public function sendTelegramNotification(Appointment $appointment, bool $isCreated): void
    {
        $userTelegram = $appointment?->user?->telegram_account;
        $telegramAccess = $appointment?->user?->access_telegram_notify;
        if ($userTelegram && $telegramAccess) {
            try {
                Notification::route('telegram', '@'.$userTelegram)
                    ->notify(new TelegramConsultationNotification($appointment, $isCreated, $userTelegram));
            } catch (\Exception $e) {
                Log::error("Ошибка отправки Telegram уведомления для консультации {$appointment->id}: " . $e->getMessage());
            }
        }

    }

}
