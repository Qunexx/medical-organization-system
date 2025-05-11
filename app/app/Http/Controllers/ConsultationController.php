<?php

namespace App\Http\Controllers;

use app\Enums\ConsultationStatusesEnum;
use App\Models\Appointment;
use App\Models\Specialization;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConsultationController extends Controller
{
    public function myConsultations(Request $request)
    {
        return Inertia::render('patient/Consultation', [
            'appointments' => [],
            'filters' => $request->only('status', 'date'),
            'links' => [],
        ]);
    }

    public function makeAppointment(Request $request)
    {
        $appointment = new Appointment();
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => [
                'required',
                'date',
                'after_or_equal:today'
            ],
            'time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($appointment, $request) {
                    Appointment::validateTimeSlot($request, $value, $fail);
                },
            ],
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'specialty' => 'required|string',
            'email' => 'required|email|max:255',
            'comment' => 'nullable|string|max:500',
        ]);

        $specialization = Specialization::where('name','like', $validated['specialty'])->firstOrFail();
        $appointment = Appointment::create([
            'user_id' => auth()->id(),
            'doctor_id' => $validated['doctor_id'],
            'appointment_date' => Carbon::parse($validated['date'] . ' ' . $validated['time']),
            'patient_name' => $validated['name'],
            'patient_phone' => $validated['phone'],
            'patient_email' => $validated['email'],
            'patient_comment' => $validated['comment'],
            'status' => ConsultationStatusesEnum::UNCONFIRMED->value,
            'specialization_id' => $specialization->id,
        ]);

        return back()->with('success');
    }

}
