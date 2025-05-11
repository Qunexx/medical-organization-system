<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth'])->group(function () {
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
            Route::get('/', [\App\Http\Controllers\ConsultationController::class, 'myConsultations'])->name('patient.myConsultation');
        });

        Route::post('/make-appointment', [\App\Http\Controllers\ConsultationController::class, 'makeAppointment'])->name('appointment.make');
//
//
//        Route::prefix('chat')->group(function () {
//            Route::get('/', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
//            Route::get('/{consultation}', [\App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
//            Route::post('/{consultation}/message', [\App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.message.send');
//        });

    });
});
