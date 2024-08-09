<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TransactionController;



Route::get('/', [FrontendController::class, 'index'])->name('home');


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('loginProcess');
Route::get('/signUp', [AuthController::class, 'signUp'])->name('signUp');
Route::post('/signUp', [AuthController::class, 'signUpProcess'])->name('signUpProcess');


// Super Admin Routes
Route::group(['middleware' => ['role:super-admin|user']], function () {
    Route::get('/super-admin', [SuperAdminController::class, 'index']);
    // Product routes
    Route::resource('products', ProductController::class);
    // Comission routes
    Route::resource('commissions', CommissionController::class);
    // Brand routes
    Route::resource('brands', BrandController::class);
    // Category routes
    Route::resource('categories', CategoryController::class);
    // Media routes
    Route::resource('medias', MediaController::class);
    Route::resource('sales', SaleController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('customers', CustomerController::class);
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
    // Route::resource('products', ProductController::class);
    // // Comission routes
    // Route::resource('commissions', CommissionController::class);
    // // Brand routes
    // Route::resource('brands', BrandController::class);
    // // Category routes
    // Route::resource('categories', CategoryController::class);
    // // Media routes
    // Route::resource('medias', MediaController::class);
    // Route::resource('sales', SaleController::class);
    // Route::resource('transactions', TransactionController::class);
   // Route::resource('customers', CustomerController::class);
});
