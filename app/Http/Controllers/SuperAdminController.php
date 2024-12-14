<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SuperAdminController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $customer = Customer::where('user_id', $user->id)->first();

        // Total Count customers
        $Total_customer = DB::table('model_has_roles')
        ->where('role_id', 4)
        ->count();
        // $role = 'user';
        // $Total_customer = Customer::whereHas('user', function($query) use ($role) {
        //     $query->whereHas('roles', function($query) use ($role) {
        //         $query->where('name', $role); // Assuming 'name' is the column where role names are stored
        //     });
        // })->with('user')->count();
        //Balance Customer
        // $Balance_customer = $customer->wallet_balance;

        // Total withdrown amount
        $Total_withdrawn_amount = Transaction::where('transaction_type', 'withdraw')->sum('amount');

        // Total Topup amount
        $Total_topup_amount = Transaction::where('transaction_type', 'topup')->sum('amount');

        // Total transactions amount sum
        $Total_transactions_amount = Transaction::sum('amount');

        // Total Count transactions
        $Total_commission_transactions = Transaction::where('transaction_type', 'commission')->count();

        // Total Count transactions
        $Total_commission_transaction = Transaction::where('transaction_type', 'commission')->sum('amount');
        // Total earnings
       // $Total_earnings = $Total_transactions_amount - $Total_withdrawn_amount;

        // Total Count sales
        $Total_sells = Sale::count();

        // Total Sales Commission Sum
        $Total_sells_commission = Transaction::where('transaction_type', 'commission')->sum('amount');

        return view('super-admin.home.index', compact(
            'Total_customer',
            'Total_transactions_amount',
            'Total_commission_transactions',
            'Total_commission_transaction',
            // 'Total_earnings',
            'Total_sells',
            'Total_sells_commission',
            // 'Balance_customer',
            'Total_withdrawn_amount',
            'Total_topup_amount'
        ));
    }
}
