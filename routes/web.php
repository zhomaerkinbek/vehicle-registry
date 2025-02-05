<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;


Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/history', [VehicleController::class, 'showHistory'])->name('history');
Route::get('/stats', [VehicleController::class, 'showStats'])->name('stats');

Route::post('/register', [VehicleController::class, 'register'])->name('register');
Route::post('/re-register', [VehicleController::class, 'reRegister'])->name('reRegister');
