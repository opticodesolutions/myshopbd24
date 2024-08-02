<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ComissionController;
use App\Http\Controllers\SuperAdminController;




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







// Super Admin Routes
Route::group(['middleware' => ['role:super-admin']], function () {
    Route::get('/super-admin', [SuperAdminController::class, 'index']);
});

// Admin Routes
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin', [AdminController::class, 'index']);
});

// Agent Routes
Route::group(['middleware' => ['role:agent']], function () {
    Route::get('/agent', [AgentController::class, 'index']);
});

// User Routes
Route::group(['middleware' => ['role:user']], function () {
    Route::get('/user', [UserController::class, 'index']);
});
