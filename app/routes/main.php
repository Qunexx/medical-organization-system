<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [\App\Http\Controllers\MainController::class, 'index'])->name('home');
Route::post('/feedback', [\App\Http\Controllers\MainController::class, 'sendFeedBack'])
    ->name('feedback.submit');
Route::get('/all-services', [\App\Http\Controllers\MainController::class, 'services'])
    ->name('services.all');
Route::get('/services/{service}', [MainController::class, 'showService'])->name('services.show');
