<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $customer = Customer::where('user_id', $user->id)->first();

        // Total Count referred customers
        $Total_reffers = Customer::where('refer_by', $customer->refer_code)->count();

        //Balance Customer
        $Balance_customer = $customer->wallet_balance;

        // Total withdrown amount
        $Total_withdrawn_amount = Transaction::where('transaction_type', 'withdraw')->where('user_id', $user->id)->sum('amount');

        // Total Topup amount
        $Total_topup_amount = Transaction::where('transaction_type', 'topup')->where('user_id', $user->id)->sum('amount');

        // Total transactions amount sum
        $Total_transactions_amount = Transaction::where('user_id', $user->id)->sum('amount');

        // Total Count transactions
        $Total_commission_transactions = Transaction::where('transaction_type', 'commission')->where('user_id', $user->id)->count();

        // Total Count transactions
        $Total_commission_transaction = Transaction::where('transaction_type', 'commission')->where('user_id', $user->id)->sum('amount');
        // Total earnings
       // $Total_earnings = $Total_transactions_amount - $Total_withdrawn_amount;

        // Total Count sales
        $Total_sells = Sale::where('user_id', $user->id)->count();

        // Total Sales Commission Sum
        $Total_sells_commission = Sale::where('user_id', $user->id)->sum('commission');

        return view('user.home.index', compact(
            'Total_reffers',
            'Total_transactions_amount',
            'Total_commission_transactions',
            'Total_commission_transaction',
            // 'Total_earnings',
            'Total_sells',
            'Total_sells_commission',
            'Balance_customer',
            'Total_withdrawn_amount',
            'Total_topup_amount'
        ));
    }

}
