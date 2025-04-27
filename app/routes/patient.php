<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth'])->group(function () {
    Route::prefix('patient')->group(function () {
        Route::get('/', [\App\Http\Controllers\PatientController::class, 'index'])->name('patient.index');
        Route::get('/profile', [\App\Http\Controllers\PatientController::class, 'profile'])->name('patient.profile');
        Route::get('/notification', [\App\Http\Controllers\PatientController::class, 'notification'])->name('patient.notification');
        Route::get('/change-password', [\App\Http\Controllers\PatientController::class, 'changePassword'])->name('patient.changePassword');

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
