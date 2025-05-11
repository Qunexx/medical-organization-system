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
        return [

            Menu::make('Записи на консультации')
                ->icon('bs.bar-chart')
                ->route('platform.appointment')
                ->title(__('Записи')),
//
//            Menu::make('Завершённые записи')
//                ->icon('bs.bar-chart')
//                ->route('platform.example.charts'),
//
//            Menu::make('Отменённые записи')
//                ->icon('bs.bar-chart')
//                ->route('platform.example.charts'),
//
//            Menu::make('Через телеграм')
//                ->icon('bs.bar-chart')
//                ->route('platform.example.charts')
//                ->title(__('Уведомления')),
//
//            Menu::make('Через почту')
//                ->icon('bs.bar-chart')
//                ->route('platform.example.charts'),
            Menu::make(__('Услуги'))
                ->icon('bs.shield')
                ->title(__('Система'))
                ->route('platform.service'),

            Menu::make(__('Специализации'))
                ->icon('bs.shield')
                ->route('platform.specialization'),

            Menu::make(__('Обратная связь'))
                ->icon('bs.shield')
                ->title(__('Обратная связь'))
                ->route('platform.feedback'),

            Menu::make('Пользователи')
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Пользователи')),

            Menu::make('Пациенты')
                ->icon('bs.people')
                ->route('platform.patient')
                ->permission('platform.systems.users')
            ,

            Menu::make('Врачи')
                ->icon('bs.people')
                ->route('platform.doctor')
            ,

            Menu::make('Администраторы')
                ->icon('bs.people')
                ->route('platform.admin')
            ,

            Menu::make(__('Roles'))
                ->icon('bs.shield')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->divider(),
//
//            Menu::make('Графики')
//                ->icon('bs.bar-chart')
//                ->route('platform.example.charts')
//                ->title(__('Статистика')),
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
