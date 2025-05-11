<?php

namespace App\Http\Controllers;

use app\Enums\ConsultationStatusesEnum;
use App\Models\Appointment;
use App\Models\Specialization;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class ConsultationController extends Controller
{
    public function myConsultations(Request $request)
    {
        $appointments = $request->user()->appointments()
            ->with(['doctor.user', 'specialization'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('patient/Consultations', [
            'appointments' => $appointments,
            'filters' => $request->only(['status', 'date'])
        ]);
    }

    public function makeAppointment(Request $request)
    {
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
                function ($attribute, $value, $fail) use ($request) {
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

    public function show(Appointment $appointment)
    {
        if (auth()->user()->id !== $appointment->user_id) {
            throw new AccessDeniedException('Нет доступа для просмотра данной записи');
        }

        $appointment->load(['doctor.user', 'specialization']);

        return Inertia::render('patient/Consultation', [
            'appointment' => $appointment
        ]);
    }

    public function destroy(Appointment $appointment)
    {
        if (auth()->user()->id !== $appointment->user_id) {
            throw new AccessDeniedException('Нет доступа для просмотра данной записи');
        }

        $appointment->update([
            'status' => 'canceled',
            'cancel_reason' => 'Отменено пациентом'
        ]);

        return redirect()->back()->with('success', 'Запись успешно отменена');
    }

}
