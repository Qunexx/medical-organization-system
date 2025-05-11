<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User\Patient;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class PatientViewScreen extends Screen
{
    /**
     * @var User
     */
    protected $patient;

    /**
     * Fetch data to be displayed on the screen.
     */
    public function query(User $user): iterable
    {
        $this->patient = $user->load('roles');

        return [
            'patient' => $this->patient,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->patient ? "Пациент: {$this->patient->fullName}" : 'Просмотр пациента';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Подробная информация о пациенте';
    }

    /**
     * The screen's action buttons.
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Назад')
                ->icon('arrow-left')
                ->route('platform.patient'),
        ];
    }

    /**
     * The screen's layout elements.
     */
    public function layout(): iterable
    {
        if (!$this->patient) {
            return [];
        }

        return [
            Layout::legend('patient', [
                Sight::make('photo', 'Фото')
                    ->render(function () {
                        $avatar = $this->patient?->avatar;
                        $avatarUrl = asset('storage/emptyAvatar.jpg');

                        if (!empty($avatar)) {
                            $avatarUrl = Storage::url($avatar->url);
                        }

                        return <<<HTML
            <div class="flex items-center justify-center">
                <div class="h-24 w-24 overflow-hidden rounded-full border-2 border-gray-200 shadow-sm">
                    <img src="{$avatarUrl}"
                         class="h-full w-full object-cover"
                         style="max-width: 96px; max-height: 96px;"
                         alt="Фото пациента {$this->patient->fullName}"

                </div>
            </div>
        HTML;
                    }),
                Sight::make('id', 'ID'),

                Sight::make('full_name', 'ФИО')
                    ->render(fn () => $this->getFullName()),

                Sight::make('birthday', 'Дата рождения')
                    ->render(fn () => $this->patient->birthday
                        ? Carbon::parse($this->patient->birthday)->translatedFormat('d F Y')
                        : 'Не указана'),

                Sight::make('email', 'Email'),

                Sight::make('phone', 'Телефон')
                    ->render(fn () => $this->patient->phone ?: 'Не указан'),

                Sight::make('telegram', 'Telegram')
                    ->render(fn () => $this->renderTelegram()),

                Sight::make('notifications', 'Уведомления')
                    ->render(fn () => $this->renderNotifications()),

                Sight::make('created_at', 'Дата регистрации')
                    ->render(fn () => $this->patient->created_at->format('d.m.Y H:i')),

                Sight::make('updated_at', 'Последнее обновление')
                    ->render(fn () => $this->patient->updated_at->format('d.m.Y H:i')),

                Sight::make('deleted_at', 'Статус')
                    ->render(fn () => $this->patient->deleted_at
                        ? 'Удален: ' . $this->patient->deleted_at->format('d.m.Y H:i')
                        : 'Активен'),
            ])->title('Основная информация'),
        ];
    }

    private function getFullName(): string
    {
        return trim(implode(' ', [
            $this->patient->last_name,
            $this->patient->first_name,
            $this->patient->middle_name
        ]));
    }

    private function renderTelegram(): string
    {
        return $this->patient->telegram_id
            ? '<a href="https://t.me/'.$this->patient->telegram_id.'"
                 target="_blank"
                 class="text-primary hover:underline">
                 @'.$this->patient->telegram_id.'
               </a>'
            : 'Не указан';
    }

    private function renderNotifications(): string
    {
        $notifications = [];
        if ($this->patient->access_email_notify) $notifications[] = 'Email';
        if ($this->patient->access_telegram_notify) $notifications[] = 'Telegram';

        return $notifications
            ? implode(', ', $notifications)
            : 'Уведомления отключены';
    }
}
