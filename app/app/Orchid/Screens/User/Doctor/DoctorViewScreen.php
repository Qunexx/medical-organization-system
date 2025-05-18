<?php

declare(strict_types=1);

namespace App\Orchid\Screens\User\Doctor;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;

class DoctorViewScreen extends Screen
{
    /**
     * @var User
     */
    protected $user;

    /**
     * Fetch data to be displayed on the screen.
     */
    public function query(User $user): iterable
    {
        $this->user = $user->load([
            'doctor.specializations',
            'doctor.services',
            'avatar'
        ]);

        return [
            'user' => $this->user,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->user
            ? "Доктор: {$this->user->fullName}"
            : 'Просмотр доктора';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Подробная информация о докторе';
    }

    /**
     * The screen's action buttons.
     */
    public function commandBar(): iterable
    {
        $authUser = auth()->user();
        $canEdit = false;
        if ($authUser->id === $this->user->id && $authUser->isDoctor()){
            $canEdit = true;
        }
        return [
            Link::make('Редактировать')
                ->canSee($canEdit)
                ->route('platform.doctor.edit', $this->user->doctor),

            Link::make('Назад')
                ->icon('arrow-left')
                ->route('platform.doctor'),
        ];
    }

    /**
     * The screen's layout elements.
     */
    public function layout(): iterable
    {
        if (!$this->user->doctor) {
            return [];
        }

        return [
            Layout::legend('user', [
                Sight::make('photo', 'Фото')
                    ->render(function () {
                        $avatar = $this->user?->avatar;
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
                         alt="Фото доктора {$this->user->fullName}"

                </div>
            </div>
        HTML;
                    }),
                Sight::make('full_name', 'ФИО')
                    ->render(fn () => $this->user->fullName),

                Sight::make('experience', 'Опыт работы')
                    ->render(fn () => $this->user->doctor->years_of_experience . ' лет'),

                Sight::make('specializations', 'Специализации')
                    ->render(fn () => $this->user->doctor->specializations
                        ->pluck('name')
                        ->join(', ')),

                Sight::make('services', 'Услуги')
                    ->render(fn () => $this->user->doctor->services
                        ->pluck('name')
                        ->join(', ')),

                Sight::make('description', 'Описание')
                    ->render(fn () => $this->user->doctor->description),

                Sight::make('email', 'Email'),

                Sight::make('phone', 'Телефон')
                    ->render(fn () => $this->user->phone ?: 'Не указан'),

                Sight::make('telegram', 'Telegram')
                    ->render(fn () => $this->renderTelegram()),

                Sight::make('status', 'Статус')
                    ->render(fn () => $this->user->deleted_at
                        ? 'Не активен'
                        : 'Активен'),
            ])->title('Основная информация'),
        ];
    }

    private function renderTelegram(): string
    {
        return $this->user->telegram_id
            ? '<a href="https://t.me/'.$this->user->telegram_id.'"
                 target="_blank"
                 class="text-primary hover:underline">
                 @'.$this->user->telegram_id.'
               </a>'
            : 'Не указан';
    }
}
