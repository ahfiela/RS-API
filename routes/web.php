<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebRsController;
use App\Http\Controllers\HospitalController;

Route::get('/', [HospitalController::class, 'index'])->name('dashboard');
Route::post('/hospital', [HospitalController::class, 'store'])->name('hospital.store');
Route::put('/hospital/{id}', [HospitalController::class, 'update'])->name('hospital.update');
Route::delete('/hospital/{id}', [HospitalController::class, 'destroy'])->name('hospital.destroy');