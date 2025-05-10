<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\Feedback;
use App\Models\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MainController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('MainPage');
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

}
