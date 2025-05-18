<?php

namespace App\Http\Controllers;

use app\Enums\ConsultationStatusesEnum;
use App\Http\Requests\MakeAppointmentRequest;
use App\Models\Appointment;
use App\Models\Review;
use App\Models\Specialization;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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

    public function makeAppointment(MakeAppointmentRequest $request)
    {
        $validated = $request->validated();

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

        $appointment->load(['doctor.user', 'specialization','review']);

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
            'status' => ConsultationStatusesEnum::DECLINED->value,
            'cancel_reason' => 'Отменено пациентом'
        ]);

        return redirect()->back()->with('success', 'Запись успешно отменена');
    }

    public function createReview(Request $request)
    {
        $user = auth()->user();
        $appointment = Appointment::findOrFail($request->appointment_id);
        if ($user->id !== $appointment->user_id) {
            throw new AccessDeniedException('Нет доступа для просмотра данной записи');
        }
        $validated = $request->validate([
            'comment' => 'required|string|max:2000'
        ]);
        if ($appointment->status !== ConsultationStatusesEnum::COMPLETED->value) {
            abort(403, 'Отзыв можно оставить только для завершенных записей');
        }
        $user->review()->updateOrCreate(
            ['appointment_id' => $request->appointment_id],
            ['text' => $validated['comment']]
        );

        return redirect()->back()
            ->with('success', 'Отзыв успешно сохранён');
    }

}
