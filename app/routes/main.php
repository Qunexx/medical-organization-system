<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [MainController::class, 'index'])->name('home');
Route::post('/feedback', [MainController::class, 'sendFeedBack'])
    ->name('feedback.submit');
Route::get('/all-services', [MainController::class, 'services'])
    ->name('services.all');
Route::get('/services/{service}', [MainController::class, 'showService'])->name('services.show');


Route::get('/all-doctors', [MainController::class, 'doctors'])->name('doctors');
Route::get('/doctors/{doctor}', [MainController::class, 'showDoctor'])->name('doctors.show');
