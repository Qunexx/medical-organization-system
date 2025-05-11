<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
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

    public static function validateTimeSlot($request, $value, $fail)
    {
        $date = Carbon::parse($request->date);
        $time = Carbon::parse($value);

        if ($time->lt('08:00') || $time->gt('20:00')) {
            $fail('Выберите время между 08:00 и 20:00');
        }

        $existing = Appointment::where('doctor_id', $request->doctor_id)
            ->whereDate('appointment_date', $date)
            ->whereTime('appointment_date', $time->format('H:i'))
            ->exists();

        if ($existing) {
            $fail('Это время уже занято');
        }
    }

}
