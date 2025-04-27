<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [\App\Http\Controllers\PageController::class, 'index'])->name('home');

require 'auth.php';

require 'patient.php';
