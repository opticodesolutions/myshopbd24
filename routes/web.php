<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ComissionController;


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('loginProcess');
Route::get('/signUp', [AuthController::class, 'signUp'])->name('signUp');
Route::post('/signUp', [AuthController::class, 'signUpProcess'])->name('signUpProcess');


// Product routes
Route::resource('products', ProductController::class);

// Comission routes
Route::resource('commissions', ComissionController::class);

// Brand routes
Route::resource('brands', BrandController::class);

// Category routes
Route::resource('categories', CategoryController::class);

// Media routes
Route::resource('medias', MediaController::class);

