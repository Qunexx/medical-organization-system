<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])->name('home');
Route::post('/feedback', [\App\Http\Controllers\MainController::class, 'sendFeedBack'])
    ->name('feedback.submit');
