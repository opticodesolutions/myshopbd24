<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Artisan;

Route::get('/link', function () {
    try {
        Artisan::call('storage:link');
        return "The storage link has been created successfully.";
    } catch (\Exception $e) {
        return "Failed to create the storage link: " . $e->getMessage();
    }
});


Route::get('/', [FrontendController::class, 'index'])->name('home');


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('loginProcess');
Route::get('/register', [AuthController::class, 'signUp'])->name('register');
Route::post('/register', [AuthController::class, 'signUpProcess'])->name('registerProcess');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::resource('products', ProductController::class);
Route::get('purchase/now/{id}', [PurchaseController::class, 'purchase_now'])->name('purchase.now');

// Super Admin Routes
Route::group(['middleware' => ['role:super-admin']], function () {
    Route::get('/super-admin', [SuperAdminController::class, 'index'])->name('super-admin');

    // User routes
    Route::get('admin/all-customers', [UserController::class, 'customers'])->name('admin.customers.index');
    Route::get('admin/all-agents', [UserController::class, 'agents'])->name('admin.agents.index');
    Route::get('admin/all-users', [UserController::class, 'all_users'])->name('admin.users.index');



    // Product routes
    // Comission routes
    Route::resource('commissions', CommissionController::class);
    Route::get('sales/commission', [TransactionController::class, 'index'])->name('sales.commission');

    // Brand routes
    Route::resource('brands', BrandController::class);
    // Category routes
    Route::resource('categories', CategoryController::class);
    // Media routes
    Route::resource('medias', MediaController::class);
    // Sales routes
    // Transaction routes
    Route::resource('transactions', TransactionController::class);
    // Payment routes
    Route::get('admin/payments/topup', [PaymentController::class, 'topupList'])->name('admin.payments.topup.index');
    Route::get('admin/payments/withdraw', [PaymentController::class, 'withdrawList'])->name('admin.payments.withdraw.index');
    Route::post('payments/update-status/{id}', [PaymentController::class, 'updateStatus'])->name('payments.updateStatus');

    // Customer routes
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
Route::resource('sales', SaleController::class);
Route::resource('customers', CustomerController::class);

// User Routes
Route::group(['middleware' => ['role:user']], function () {
    Route::get('/user', [UserController::class, 'index'])->name('user');

    // Payment Routes
    Route::get('payments/topup', [PaymentController::class, 'topupIndex'])->name('payments.topup.index');
    Route::get('payments/withdraw', [PaymentController::class, 'withdrawIndex'])->name('payments.withdraw.index');
    Route::get('payments/topup/create', [PaymentController::class, 'createTopup'])->name('payments.topup.create');
    Route::get('payments/withdraw/create', [PaymentController::class, 'createWithdraw'])->name('payments.withdraw.create');
    Route::post('payments/store', [PaymentController::class, 'store'])->name('payments.store');

    // // Comission routes
    // Route::resource('commissions', CommissionController::class);
    // // Brand routes
    // Route::resource('brands', BrandController::class);
    // // Category routes
    // Route::resource('categories', CategoryController::class);
    // // Media routes
    // Route::resource('medias', MediaController::class);
    // Route::resource('sales', SaleController::class);


    Route::get('user/profile', [CustomerController::class, 'my_info'])->name('user/profile');

    Route::get('personal/info', [CustomerController::class, 'personal_info'])->name('personal.info');
    Route::get('profile/kyc', [CustomerController::class, 'profile_kyc'])->name('profile.kyc');
    Route::get('password/change', [CustomerController::class, 'password_change'])->name('password.change');
    Route::get('joining/invoice', [CustomerController::class, 'joining_invoice'])->name('joining.invoice');
});
Route::get('purchase/commission', [PurchaseController::class, 'purchase_commission'])->name('purchase.commission');
Route::get('refer/commission', [SaleController::class, 'refer_commissions'])->name('refer.commission');
