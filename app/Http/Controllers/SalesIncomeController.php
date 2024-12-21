<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SalesIncomeController extends Controller
{
    public function sale_commission()
    {
        $user = auth()->user();
        $sale_commissions = Sale::with('user', 'product')->where('user_id', $user->id)
        ->orderby('created_at', 'desc')
        ->paginate(10);
        $totalAmount = Sale::where('user_id', $user->id)->sum('total_amount');
        return view('commissions.sale_commissions', compact('sale_commissions', 'totalAmount'));
    }

    public function matching_commission()
    {
        $user = auth()->user();
        $matching_commissions = Commission::leftJoin('customers', 'customers.id', '=', 'commissions.customer_id')
        ->where('customers.user_id', $user->id)
        ->select('customers.user_id', 'commissions.*')
        ->paginate(10);

        $downline_left_hold_bonus = Transaction::where('user_id', $user->id)->where('transaction_type', 'downline_left_hold_bonus')->paginate(10);
        $downline_right_hold_bonus = Transaction::where('user_id', $user->id)->where('transaction_type', 'downline_right_hold_bonus')->paginate(10);
        return view('commissions.matching_commissions', compact('matching_commissions', 'downline_left_hold_bonus', 'downline_right_hold_bonus'));
    }
}
