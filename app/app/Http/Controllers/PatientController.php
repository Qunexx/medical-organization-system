<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PatientController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('patient/Index');
    }
    public function profile(Request $request): Response
    {
        $user = auth()->user();

        return Inertia::render('patient/Profile', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar_url' => $user->avatar_url ?? '/images/default-avatar.jpg',
            ],
            'settings' => [
                'access_email_notify' => $user->access_email_notify,
                'access_telegram_notify' => $user->access_telegram_notify
            ],
            'status' => session('status')
        ]);
    }

    public function changePassword(Request $request): Response
    {
        $user = auth()->user();

        return Inertia::render('patient/ChangePassword', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar_url' => $user->avatar_url ?? '/images/default-avatar.jpg',
            ],
            'settings' => [
                'access_email_notify' => $user->access_email_notify,
                'access_telegram_notify' => $user->access_telegram_notify
            ],
            'status' => session('status')
        ]);
    }

    public function notification(Request $request): Response
    {
        $user = auth()->user();

        return Inertia::render('patient/Notification', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar_url' => $user->avatar_url ?? '/images/default-avatar.jpg',
            ],
            'settings' => [
                'access_email_notify' => $user->access_email_notify,
                'access_telegram_notify' => $user->access_telegram_notify
            ],
            'status' => session('status')
        ]);
    }

    public function myAppointments(Request $request): Response
    {
        $user = auth()->user();

        return Inertia::render('patient/Profile', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar_url' => $user->avatar_url ?? '/images/default-avatar.jpg',
            ],
            'settings' => [
                'access_email_notify' => $user->access_email_notify,
                'access_telegram_notify' => $user->access_telegram_notify
            ],
            'status' => session('status')
        ]);
    }
}
