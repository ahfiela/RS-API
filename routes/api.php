<?php

use App\Http\Controllers\HospitalController;
use Illuminate\Support\Facades\Route;

// Endpoint publik yang dipanggil oleh Server Utama Aplikasi kamu via HTTP Client
Route::post('/v1/verify-hospital', [HospitalController::class, 'validateApi']);