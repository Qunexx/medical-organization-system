<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdditionalProfileUpdateRequest;
use App\Http\Requests\AvatarUpdateRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\MainProfileUpdateRequest;
use App\Http\Requests\NotificationChangeRequest;
use App\Models\Avatar;
use App\Models\User;
use http\Env;
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
                'chat_id' => $user->chat_id,
            ],
            'avatar_url' => Storage::url($user->avatar?->url) ?? '',
            'settings' => [
                'access_email_notify' => $user->access_email_notify,
                'access_telegram_notify' => $user->access_telegram_notify
            ],
            'telegram_bot_url' => env('TELEGRAM_BOT_URL'),
            'status' => session('status')
        ]);
    }

    public function avatarUpdate(AvatarUpdateRequest $request)
    {
        $validated = $request->validated();
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

    public function mainProfileUpdate(MainProfileUpdateRequest $request)
    {
        $validated = $request->validated();
        auth()->user()->update($validated);

        return back()->with('success', 'Профиль успешно обновлён');
    }

    public function additionalProfileUpdate(AdditionalProfileUpdateRequest $request)
    {
        $user = auth()->user();

        $validated = $request->validated();

        $user->update($validated);

        return redirect()->back()->with('success', 'Данные успешно обновлены');
    }

    public function notificationChange(NotificationChangeRequest $request)
    {
        $request->validated();

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

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();

        $validated =$request->validated();

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
            'status' => session('status'),
            'telegram_bot_url' => env('TELEGRAM_BOT_URL'),
        ]);
    }
}
