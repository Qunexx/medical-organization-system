<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        $user = auth()->user();
        if ($user->isDoctor()) {
            return [
                Menu::make('Мои записи')
                    ->icon('bs.calendar3')
                    ->route('platform.appointment'),

                Menu::make('Пациенты')
                    ->icon('bs.person-heart')
                    ->route('platform.patient'),

                Menu::make('Мой профиль')
                    ->icon('bs.person-heart')
                    ->route('platform.doctor.view', auth()->user()),

                Menu::make('Отзывы на мои консультации')
                    ->icon('bs.chat-text')
                    ->route('platform.review')
                    ->divider(),

                Menu::make('Статистика')
                    ->icon('bs.bar-chart-line')
                    ->route('platform.stats')
                    ->title(__('Аналитика')),
            ];
        }

        if ($user->isSupport()) {
            return [
                Menu::make('Записи на консультации')
                ->icon('bs.calendar3')
                ->route('platform.appointment')
                ->title(__('Записи')),

                Menu::make('Отзывы')
                    ->icon('bs.chat-text')
                    ->route('platform.review')
               ,

                Menu::make(__('Обратная связь'))
                    ->icon('bs.chat')
                    ->title(__('Обратная связь'))
                    ->route('platform.feedback')
                    ->divider(),

                Menu::make('Статистика')
                    ->icon('bs.bar-chart-line')
                    ->route('platform.stats')
                    ->title(__('Аналитика')),
            ];
        }

        return [
            Menu::make('Записи на консультации')
                ->icon('bs.calendar3')
                ->route('platform.appointment')
                ->title(__('Записи')),

            Menu::make('Отзывы')
                ->icon('bs.chat-text')
                ->route('platform.review')
                ->divider(),

            Menu::make(__('Услуги'))
                ->icon('bs.gear')
                ->title(__('Система'))
                ->route('platform.service'),

            Menu::make(__('Специализации'))
                ->icon('bs.tags')
                ->route('platform.specialization'),

            Menu::make(__('Обратная связь'))
                ->icon('bs.chat')
                ->title(__('Обратная связь'))
                ->route('platform.feedback'),

            Menu::make('Пользователи')
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Пользователи')),

            Menu::make('Пациенты')
                ->icon('bs.person-heart')
                ->route('platform.patient')
                ->permission('platform.systems.users'),

            Menu::make('Врачи')
                ->icon('bs.person-badge')
                ->route('platform.doctor'),

            Menu::make('Поддержка')
                ->icon('bs.person-gear')
                ->route('platform.support'),

            Menu::make('Администраторы')
                ->icon('bs.shield-check')
                ->route('platform.admin'),

            Menu::make(__('Roles'))
                ->icon('bs.shield-lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->divider(),

            Menu::make('Статистика')
                ->icon('bs.bar-chart-line')
                ->route('platform.stats')
                ->title(__('Аналитика')),
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
