<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
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
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'middle_name' => $user->middle_name,
                'phone' => $user->phone,
                'birthday' => $user->birthday,
                'telegram_account' => $user->telegram_account,
            ],
            'avatar_url' => Storage::url($user->avatar?->url) ?? '',
            'settings' => [
                'access_email_notify' => $user->access_email_notify,
                'access_telegram_notify' => $user->access_telegram_notify
            ],
            'status' => session('status')
        ]);
    }

    public function avatarUpdate(Request $request)
    {
        $validated = $request->validate([
            'avatar' => 'required|image|max:2048',
        ]);

        $user = $request->user();

        try {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store(User::AVATAR_PATH, 'public');
            $avatar = Avatar::updateOrCreate(['user_id' => $user->id], ['user_id' => $user->id, 'url' => $path]);

            return back()->with([
                'success' => 'Аватар успешно обновлён!',
                'avatar_url' => Storage::url($path)
            ]);

        } catch (\Exception $e) {
            return back()->withErrors([
                'avatar' => 'Ошибка загрузки: ' . $e->getMessage()
            ]);
        }
    }

    public function mainProfileUpdate(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore(auth()->id())],
            'phone' => ['required', 'string', 'regex:/^\+7\d{10}$/']
        ], [
            'phone.regex' => 'Номер телефона должен быть в формате +7XXXXXXXXXX'
        ]);

        auth()->user()->update($validated);

        return back()->with('success', 'Профиль успешно обновлён');
    }

    public function additionalProfileUpdate(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'birthday' => 'nullable|date',
            'telegram_account' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ]
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'Данные успешно обновлены');
    }

    public function notificationChange(Request $request)
    {
        $request->validate([
            'access_email_notify' => 'boolean',
            'access_telegram_notify' => 'boolean',
        ]);

        $user = Auth::user();

        $user->access_email_notify = $request->input('access_email_notify');
        $user->access_telegram_notify = $request->input('access_telegram_notify');

        $user->save();

        return back()->with('success', 'Настройки уведомлений успешно обновлены.');
    }

    public function changePasswordView(Request $request): Response
    {
        $user = auth()->user();

        return Inertia::render('patient/ChangePassword', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar_url' => $user->avatar_url,
            ],
            'settings' => [
                'access_email_notify' => $user->access_email_notify,
                'access_telegram_notify' => $user->access_telegram_notify
            ],
            'status' => session('status')
        ]);
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        $fail('Текущий пароль введен неверно');
                    }
                },
            ],
            'password' => [
                'nullable',
                'confirmed',
                Password::min(8),
            ],
            'password_confirmation' => 'required_with:password|min:8',
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($validated['password'])
            ]);
            auth()->logout();

            return redirect()->route('login')
                ->with('success', 'Пароль успешно изменен. Войдите снова.');
        }

        return back()->with('success', 'Настройки сохранены');
    }

    public function notification(Request $request): Response
    {
        $user = auth()->user();

        return Inertia::render('patient/Notification', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar_url' => $user->avatar_url,
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
                'avatar_url' => $user->avatar_url,
            ],
            'settings' => [
                'access_email_notify' => $user->access_email_notify,
                'access_telegram_notify' => $user->access_telegram_notify
            ],
            'status' => session('status')
        ]);
    }
}
