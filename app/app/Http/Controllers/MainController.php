<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Requests\SendFeedbackRequest;
use App\Models\Doctor;
use App\Models\Feedback;
use App\Models\Review;
use App\Models\Role;
use App\Models\Service;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MainController extends Controller
{
    public function index(Request $request): Response
    {
        $services = Service::take(6)->get();
        $doctors = Doctor::with(['user.avatar', 'specializations'])
            ->when($request->doctor, function($query, $doctorId) {
                $query->where('id', $doctorId);
            })
            ->get();
        $reviews = Review::with(['user.avatar'])->take(3)->get();

        return Inertia::render('MainPage',
        [
            'services' => $services,
            'doctors' => $doctors,
            'reviews' => $reviews,
            'selectedDoctor' => $request->input('doctor')
        ]);
    }

    public function sendFeedBack(SendFeedbackRequest $request)
    {
        $validated = $request->validated();

        Feedback::create([
            'fio' => $validated['fio'] ?? null,
            'email' => $validated['email'] ?? null,
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'] ?? null,
        ]);

        return back()->with('success', 'Сообщение отправлено');
    }

    public function services(Request $request) : Response
    {
        $services = Service::paginate(12);
        return Inertia::render('Services', [
            'services' => $services
        ]);
    }

    public function showService(Service $service)
    {
        $service->load(['doctors' => function ($query) {
            $query->with([
                'user:id,first_name,last_name,middle_name',
                'user.avatar:id,user_id,url',
                'specializations:id,name'
            ])
                ->select(
                    'doctors.id',
                    'doctors.user_id',
                    'doctors.years_of_experience',
                );
        }]);

        return Inertia::render('Service', [
            'service' => $service->makeHidden(['created_at', 'updated_at'])
        ]);
    }

    public function doctors(Request $request)
    {
        $doctors = Doctor::with([
            'user:id,first_name,last_name,middle_name',
            'user.avatar:id,user_id,url',
            'specializations:id,name',
            'services:id,name'
        ])->paginate(12);

        return Inertia::render('Doctors', [
            'doctors' => $doctors
        ]);
    }

    public function showDoctor(Doctor $doctor)
    {
        $doctor->load([
            'user:id,first_name,last_name,middle_name',
            'user.avatar:id,user_id,url',
            'specializations:id,name',
            'services:id,name',
        ]);

        return Inertia::render('Doctor', [
            'doctor' => $doctor->makeHidden(['created_at', 'updated_at'])
        ]);
    }

    public function reviews()
    {
        $reviews = Review::with(['user.avatar', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('Reviews', [
            'reviews' => $reviews,
        ]);
    }

}
