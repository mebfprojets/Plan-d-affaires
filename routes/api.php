<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessPlanController;

/**
 * Authentication for pusher private channels
 */
Route::post('/business_plan/{id_plan_affaire}/callback', [BusinessPlanController::class, 'callbackPaye'])->name('callback.payer');




