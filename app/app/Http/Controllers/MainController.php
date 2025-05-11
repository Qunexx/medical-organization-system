<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\Feedback;
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
        return Inertia::render('MainPage',
        [
            'services' => $services,
        ]);
    }

    public function sendFeedBack(Request $request)
    {
        $validated = $request->validate([
            'fio' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000'
        ]);

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

}
