<?php

use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth'])->group(function () {
    Route::middleware(\App\Http\Middleware\RoleMiddleware::class.':user')->group(function () {
        Route::prefix('patient')->group(function () {
            Route::get('/', [PatientController::class, 'index'])->name('patient.index');
            Route::get('/profile', [PatientController::class, 'profile'])->name('patient.profile');
            Route::post('/profile/main', [PatientController::class, 'mainProfileUpdate'])->name('patient.profile.main.update');
            Route::post('/profile/additional', [PatientController::class, 'additionalProfileUpdate'])->name('patient.profile.additional.update');
            Route::post('/avatar', [PatientController::class, 'avatarUpdate'])->name('patient.avatar.update');
            Route::get('/notification', [PatientController::class, 'notification'])->name('patient.notification');
            Route::post('/notifications/settings/update', [PatientController::class, 'notificationChange'])->name('patient.notification.update');
            Route::get('/change-password', [PatientController::class, 'changePasswordView'])->name('patient.changePasswordView');
            Route::post('/change-password', [PatientController::class, 'changePassword'])->name('patient.changePassword');

            Route::prefix('consultation')->group(function () {
                Route::get('/', [ConsultationController::class, 'myConsultations'])->name('patient.myConsultation');
                Route::post('/make-appointment', [ConsultationController::class, 'makeAppointment'])->name('patient.appointment.make');
                Route::get('/{appointment}', [ConsultationController::class, 'show'])->name('patient.appointment.view');
                Route::post('/{appointment}', [ConsultationController::class, 'destroy'])->name('patient.appointment.delete');
                Route::post('/appointments/{appointment}/review', [ConsultationController::class, 'createReview'])
                    ->name('patient.appointment.review');
            });

        });
    });
});
