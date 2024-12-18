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
use App\Http\Controllers\IncentiveIncomeController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesIncomeController;
use App\Http\Controllers\SubcriptioRenewController;
use Illuminate\Support\Facades\Artisan;

Route::get('/link', function () {
    try {
        Artisan::call('storage:link');
        return "The storage link has been created successfully.";
    } catch (\Exception $e) {
        return "Failed to create the storage link: " . $e->getMessage();
    }
});

Route::get('/joining_job', [FrontendController::class, 'joining_job'])->name('join.job');
Route::post('/job_post_save', [FrontendController::class, 'job_post_save'])->name('join.job_post_save');


Route::put('/sales/{sale}/update-status', [SaleController::class, 'updateStatus'])->name('sales.updateStatus');




Route::get('/branch_list', [UserController::class, 'branch_list'])->name('users.branch_list');


Route::get('/users/generations', [UserController::class, 'showGenerations'])->name('users.generations');
Route::get('/users/generations-tree', [UserController::class, 'showGenerationsTree'])->name('users.generations.tree');



Route::get('/joining', [FrontendController::class, 'join_invoice'])->name('join.invoice');
Route::get('insensitive/income', [FrontendController::class, 'insensitive_income'])->name('insensitive.income');
Route::get('insensitive/info', [FrontendController::class, 'insensitive_info'])->name('insensitive.info');

Route::get('/', [FrontendController::class, 'index'])->name('home');

// Route:get('/join/invoice', [FrontendController::class, 'join_invoice'])->name('join.invoice');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('loginProcess');
Route::get('/register', [AuthController::class, 'signUp'])->name('register');
Route::post('/register', [AuthController::class, 'signUpProcess'])->name('registerProcess');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::resource('products', ProductController::class);
Route::resource('purchases', PurchaseController::class);
Route::get('purchase/now/{id}', [PurchaseController::class, 'purchase_now'])->name('purchase.now');

Route::get('sale/now/{id}', [SaleController::class, 'sale_now'])->name('sale.now');

Route::post('purchase/save', [PurchaseController::class, 'purchase_save'])->name('purchase.save');

Route::get('sales/commission', [TransactionController::class, 'index'])->name('sales.commission');
Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');

// purchase/now/2

Route::resource('sales', SaleController::class);
Route::resource('customers', CustomerController::class);


Route::get('purchase/commission', [PurchaseController::class, 'purchase_commission'])->name('purchase.commission');
Route::get('sales-income', [SalesIncomeController::class, 'sale_commission'])->name('sales.income');
Route::get('macthing-comminsion', [SalesIncomeController::class, 'matching_commission'])->name('macthing.comminsion');
Route::get('refer/commission', [SaleController::class, 'refer_commissions'])->name('refer.commission');
Route::get('total/commission', [TransactionController::class, 'total_commission'])->name('total.commission');

Route::resource('subcription-renew', SubcriptioRenewController::class);

// User Routes
Route::group(['middleware' => ['role:user']], function () {
    Route::get('/user', [UserController::class, 'index'])->name('user');

    // Payment Routes
    Route::get('payments/topup', [PaymentController::class, 'topupIndex'])->name('payments.topup.index');
    Route::get('payments/withdraw', [PaymentController::class, 'withdrawIndex'])->name('payments.withdraw.index');
    Route::get('payments/topup/create', [PaymentController::class, 'createTopup'])->name('payments.topup.create');
    Route::get('payments/withdraw/create', [PaymentController::class, 'createWithdraw'])->name('payments.withdraw.create');
    Route::post('payments/store', [PaymentController::class, 'store'])->name('payments.store');

    Route::get('coin/transfer', [PaymentController::class, 'coinTransfer'])->name('coin.transfer');
    Route::post('coin/transfer', [PaymentController::class, 'coinTransferStore'])->name('coin.transfer.store');
    Route::get('coin/transfer/receiver-history', [PaymentController::class, 'coinTransferReceiverHistory'])->name('coin.transfer.receiver.history');
    Route::get('coin/transfer/sender-history', [PaymentController::class, 'coinTransferSenderHistory'])->name('coin.transfer.sender.history');
    // Route::get('coin/transfer/rec')


    Route::get('user/profile', [CustomerController::class, 'my_info'])->name('user/profile');

    Route::get('personal/info', [CustomerController::class, 'personal_info'])->name('personal.info');
    Route::get('profile/kyc', [CustomerController::class, 'profile_kyc'])->name('profile.kyc');
    Route::post('kyc.update', [CustomerController::class, 'kyc_update'])->name('kyc.update');
    Route::get('password/change', [CustomerController::class, 'password_change'])->name('password.change');
    Route::post('password/update', [CustomerController::class, 'password_update'])->name('password.update');
    Route::get('joining/invoice', [CustomerController::class, 'joining_invoice'])->name('joining.invoice');

    Route::get('refer/info', [CustomerController::class, 'refer_info'])->name('refer.info');
});


// Super Admin Routes
Route::group(['middleware' => ['role:super-admin']], function () {
    Route::get('/job_list', [FrontendController::class, 'job_list'])->name('join.job_list');
Route::get('/job/{id}', [FrontendController::class, 'job_show'])->name('join.jobs.show');

    Route::get('/super-admin', [SuperAdminController::class, 'index'])->name('super-admin');

    // User routes
    Route::get('admin/all-customers', [UserController::class, 'customers'])->name('admin.customers.index');
    Route::get('admin/all-agents', [UserController::class, 'agents'])->name('admin.agents.index');
    Route::get('admin/all-users', [UserController::class, 'all_users'])->name('admin.users.index');



    // Product routes
    // Comission routes
    Route::resource('commissions', CommissionController::class);

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
    Route::get('coin/transfer/history', [PaymentController::class, 'coinTransferHistory'])->name('coin.transfer.history');

    // Customer routes
    Route::resource('customers', CustomerController::class);
    // Admin Subscription Fee
    Route::get('admin/subscription-fee', [TransactionController::class, 'Admin_Subscription_fee'])->name('admin.subscription.index');
    // Insective Info
    Route::resource('incentive_income', IncentiveIncomeController::class);
});

// Admin Routes
Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/admin', [AdminController::class, 'index']);
});

// Agent Routes
Route::group(['middleware' => ['role:agent']], function () {
    Route::get('/agent', [AgentController::class, 'index']);
});
