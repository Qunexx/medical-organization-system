<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/', [\App\Http\Controllers\UserController::class, 'profile'])->name('profile');

//
//        Route::prefix('consultations')->group(function () {
//            Route::get('/', [\App\Http\Controllers\ConsultationController::class, 'index'])->name('consultations.index');
//            Route::post('/', [\App\Http\Controllers\ConsultationController::class, 'store'])->name('consultations.store');
//            Route::get('/{consultation}', [\App\Http\Controllers\ConsultationController::class, 'show'])->name('consultations.show');
//            Route::delete('/{consultation}', [\App\Http\Controllers\ConsultationController::class, 'cancel'])->name('consultations.cancel');
//        });
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
