<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('', [\App\Http\Controllers\PageController::class, 'index'])->name('home')->middleware(['guest', 'verified']);

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
