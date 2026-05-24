<?php
use App\Http\Controllers\HospitalController;
use Illuminate\Support\Facades\Route;

// Endpoint ini yang akan di-request oleh server external
Route::post('/v1/verify-hospital', [HospitalController::class, 'validateApi']);