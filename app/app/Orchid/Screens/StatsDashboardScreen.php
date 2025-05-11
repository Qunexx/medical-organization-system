<?php

namespace App\Orchid\Screens;

use app\Enums\ConsultationStatusesEnum;
use App\Enums\RoleEnum;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Orchid\Layouts\StatusChart;
use App\Orchid\Layouts\TrendChart;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Repository;
use Orchid\Screen\TD;

class StatsDashboardScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'total_users' => User::query()->count(),
            'total_appointments' => Appointment::query()->count(),
            'active_doctors' => Doctor::query()->count(),
            'active_patients' => User::whereHas('roles', function ($query) {
                $query->where('slug', RoleEnum::USER->name);
            })->count(),

            'statusChart' => Appointment::countForGroup('status')
                ->toChart(fn($status) => ConsultationStatusesEnum::from($status)->getLabel()),

            'trendChart' => [
                Appointment::countByDays(now()->subDays(29), now(), 'created_at')
                    ->toChart('Записи'),
            ],
            'recentAppointments' => Appointment::latest()
                ->with(['user', 'doctor'])
                ->limit(10)
                ->get(),
        ];
    }

    public function name(): ?string
    {
        return 'Статистика системы';
    }

    public function layout(): iterable
    {
        return [
            Layout::metrics([
                'Всего пользователей' => 'total_users',
                'Всего записей' => 'total_appointments',
                'Активных врачей' => 'active_doctors',
                'Активных пациентов' => 'active_patients',
            ])->title('Основные показатели'),

            Layout::columns([
                new StatusChart(),
                new TrendChart(),
            ]),

            Layout::table('recentAppointments', [
                TD::make('id', 'ID'),
                TD::make('user.full_name', 'Пациент'),
                TD::make('doctor.user.full_name', 'Врач'),
                TD::make('appointment_date', 'Дата приёма')
                    ->render(fn($a) => $a->appointment_date),
                TD::make('status', 'Статус')
                    ->render(fn($a) => ConsultationStatusesEnum::from($a->status)->getLabel()),
                TD::make('created_at', 'Создана'),
            ])->title('Последние записи'),
        ];
    }

    private function getStatusChartData(): array
    {
        $data = Appointment::select('status')
            ->selectRaw('count(*) as total')
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) {
                $status = ConsultationStatusesEnum::tryFrom($item->status)?->getLabel() ?? 'Unknown';
                return [$status => $item->total];
            });

        return [
            'labels' => $data->keys()->toArray(),
            'values' => $data->values()->toArray(),
            'colors' => ['#4CAF50', '#F44336', '#2196F3', '#FF9800'] // Цвета для секторов
        ];
    }

    private function getTrendChartData(): array
    {
        $startDate = now()->subDays(29)->startOfDay();
        $endDate = now()->endOfDay();

        $data = Appointment::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as total')
            )
            ->groupBy('date')
            ->pluck('total', 'date');

        $results = [];
        foreach ($startDate->daysUntil($endDate) as $day) {
            $date = $day->format('Y-m-d');
            $results[] = [
                'x' => $day->format('d M'),
                'y' => $data[$date] ?? 0
            ];
        }

        return $results;
    }
}
