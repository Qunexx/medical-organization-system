<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth'])->group(function () {
    Route::prefix('patient')->group(function () {
        Route::get('/', [\App\Http\Controllers\PatientController::class, 'index'])->name('patient.index');
        Route::get('/profile', [\App\Http\Controllers\PatientController::class, 'profile'])->name('patient.profile');
        Route::post('/profile/main', [\App\Http\Controllers\PatientController::class, 'mainProfileUpdate'])->name('patient.profile.main.update');
        Route::post('/profile/additional', [\App\Http\Controllers\PatientController::class, 'additionalProfileUpdate'])->name('patient.profile.additional.update');
        Route::post('/avatar', [\App\Http\Controllers\PatientController::class, 'avatarUpdate'])->name('patient.avatar.update');
        Route::get('/notification', [PatientController::class, 'notification'])->name('patient.notification');
        Route::post('/notifications/settings/update', [PatientController::class, 'notificationChange'])->name('patient.notification.update');
        Route::get('/change-password', [PatientController::class, 'changePassword'])->name('patient.changePassword');

        Route::prefix('consultation')->group(function () {
            Route::get('/', [\App\Http\Controllers\ConsultationController::class, 'myConsultations'])->name('patient.myConsultation');
        });
//
//
//        Route::prefix('chat')->group(function () {
//            Route::get('/', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
//            Route::get('/{consultation}', [\App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
//            Route::post('/{consultation}/message', [\App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.message.send');
//        });
//
//        Route::prefix('notifications')->group(function () {
//            Route::get('/', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
//            Route::post('/telegram', [\App\Http\Controllers\NotificationController::class, 'connectTelegram'])->name('notifications.connect.tg');
//            Route::put('/email', [\App\Http\Controllers\NotificationController::class, 'updateEmail'])->name('notifications.update.email');
//        });
    });
});
