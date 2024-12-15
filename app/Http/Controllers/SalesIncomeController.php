<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;

class SalesIncomeController extends Controller
{
    public function sale_commission()
    {
        $user = auth()->user();
        $sale_commissions = Sale::with('user', 'product')->where('user_id', $user->id)->paginate(1);
        $totalAmount = Sale::where('user_id', $user->id)->sum('total_amount');
        return view('commissions.sale_commissions', compact('sale_commissions', 'totalAmount'));
    }
}
