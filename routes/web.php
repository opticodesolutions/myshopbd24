<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('loginProcess');
Route::get('/signUp', [AuthController::class, 'signUp'])->name('signUp');
Route::post('/signUp', [AuthController::class, 'signUpProcess'])->name('signUpProcess');


