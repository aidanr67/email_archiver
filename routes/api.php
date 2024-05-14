<?php

use App\Http\Controllers\API\EmailController;
use App\Http\Controllers\API\HealthcheckController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/health', [HealthcheckController::class, 'index']);

Route::post('/email', [EmailController::class, 'store']);
