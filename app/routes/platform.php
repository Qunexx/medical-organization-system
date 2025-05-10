<?php

declare(strict_types=1);

use App\Models\Feedback;
use App\Models\Service;
use App\Orchid\Screens\Feedback\FeedbackListScreen;
use App\Orchid\Screens\Feedback\FeedbackViewScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Service\ServiceEditScreen;
use App\Orchid\Screens\Service\ServiceListScreen;
use App\Orchid\Screens\User\Admin\AdminEditScreen;
use App\Orchid\Screens\User\Admin\AdminListScreen;
use App\Orchid\Screens\User\Doctor\DoctorEditScreen;
use App\Orchid\Screens\User\Doctor\DoctorListScreen;
use App\Orchid\Screens\User\Patient\PatientEditScreen;
use App\Orchid\Screens\User\Patient\PatientListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::middleware(\App\Http\Middleware\RoleMiddleware::class.':admin')->group(function () {
    Route::screen('/main', PlatformScreen::class)
        ->name('platform.main');

// Platform > Profile
    Route::screen('profile', UserProfileScreen::class)
        ->name('platform.profile')
        ->breadcrumbs(fn(Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile')));
// Platform > System > Users > Edit
    Route::screen('users/{user}/edit', UserEditScreen::class)
        ->name('platform.systems.users.edit')
        ->breadcrumbs(fn(Trail $trail, $user) => $trail
            ->parent('platform.systems.users')
            ->push($user->first_name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
    Route::screen('users/create', UserEditScreen::class)
        ->name('platform.systems.users.create')
        ->breadcrumbs(fn(Trail $trail) => $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
    Route::screen('users', UserListScreen::class)
        ->name('platform.systems.users')
        ->breadcrumbs(fn(Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Admins > Edit
    Route::screen('admins/{user}/edit', AdminEditScreen::class)
        ->name('platform.admin.edit')
        ->breadcrumbs(fn(Trail $trail, $user) => $trail
            ->parent('platform.admin')
            ->push($user->first_name, route('platform.admin.edit', $user)));

// Platform > System > Admins > Create
    Route::screen('admins/create', AdminEditScreen::class)
        ->name('platform.admin.create')
        ->breadcrumbs(fn(Trail $trail) => $trail
            ->parent('platform.systems.admin')
            ->push(__('Create'), route('platform.admin.create')));

// Platform > System > Admins
    Route::screen('admins', AdminListScreen::class)
        ->name('platform.admin')
        ->breadcrumbs(fn(Trail $trail) => $trail
            ->parent('platform.index')
            ->push('Администраторы', route('platform.admin')));

    // Platform > System > Patients > Edit
    Route::screen('patients/{user}/edit', PatientEditScreen::class)
        ->name('platform.admin.edit')
        ->breadcrumbs(fn(Trail $trail, $user) => $trail
            ->parent('platform.patient')
            ->push($user->first_name, route('platform.admin.edit', $user)));

// Platform > System > Patients  > Create
    Route::screen('patients/create', PatientEditScreen::class)
        ->name('platform.patient.create')
        ->breadcrumbs(fn(Trail $trail) => $trail
            ->parent('platform.systems.patient')
            ->push(__('Create'), route('platform.patient.create')));

// Platform > System > Patients
    Route::screen('patients', PatientListScreen::class)
        ->name('platform.patient')
        ->breadcrumbs(fn(Trail $trail) => $trail
            ->parent('platform.index')
            ->push('Пациенты', route('platform.patient')));

    // Platform > System > Doctors > Edit
    Route::screen('doctors/{user}/edit', DoctorEditScreen::class)
        ->name('platform.doctor.edit')
        ->breadcrumbs(fn(Trail $trail, $user) => $trail
            ->parent('platform.patient')
            ->push($user->first_name, route('platform.admin.edit', $user)));

// Platform > System > Doctors > Create
    Route::screen('doctors/create', DoctorEditScreen::class)
        ->name('platform.doctor.create')
        ->breadcrumbs(fn(Trail $trail) => $trail
            ->parent('platform.systems.patient')
            ->push(__('Create'), route('platform.patient.create')));

// Platform > System > Doctors
    Route::screen('doctors', DoctorListScreen::class)
        ->name('platform.doctor')
        ->breadcrumbs(fn(Trail $trail) => $trail
            ->parent('platform.index')
            ->push('Врачи', route('platform.doctor')));

// Platform > System > Roles > Role
    Route::screen('roles/{role}/edit', RoleEditScreen::class)
        ->name('platform.systems.roles.edit')
        ->breadcrumbs(fn(Trail $trail, $role) => $trail
            ->parent('platform.systems.roles')
            ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
    Route::screen('roles/create', RoleEditScreen::class)
        ->name('platform.systems.roles.create')
        ->breadcrumbs(fn(Trail $trail) => $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
    Route::screen('roles', \App\Orchid\Screens\Role\RoleListScreen::class)
        ->name('platform.systems.roles')
        ->breadcrumbs(fn(Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles')));


    // Platform > System > Feedback
    Route::screen('feedback', FeedbackListScreen::class)
        ->name('platform.feedback')
        ->breadcrumbs(fn(Trail $trail) => $trail
            ->parent('platform.index')
            ->push('Обратная связь', route('platform.feedback')));

    // Platform > System > Feedback > View
    Route::screen('feedback/{feedback}', FeedbackViewScreen::class)
        ->name('platform.feedback.view')
        ->breadcrumbs(function (Trail $trail, Feedback $feedback) {
            return $trail
                ->parent('platform.feedback')
                ->push($feedback->id, route('platform.feedback.view',$feedback));
        });

    // Platform > System > Service
    Route::screen('service', ServiceListScreen::class)
        ->name('platform.service')
        ->breadcrumbs(fn(Trail $trail) => $trail
            ->parent('platform.index')
            ->push('Услуги', route('platform.service')));

    // Platform > System > Service > Create
    Route::screen('service/create', ServiceEditScreen::class)
        ->name('platform.service.create')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.service')
                ->push('Создать', route('platform.service.create'));
        });

    // Platform > System > Service > Edit
    Route::screen('service/{service}/edit', ServiceEditScreen::class)
        ->name('platform.service.edit')
        ->breadcrumbs(function (Trail $trail, Service $service) {
            return $trail
                ->parent('platform.service')
                ->push($service->id, route('platform.service.edit', $service));
        });

});
