<?php

use App\Http\Controllers\TelegramController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::post('/telegram/webhook', [TelegramController::class, 'handleWebhook']);

require 'main.php';
require 'auth.php';
require 'patient.php';
