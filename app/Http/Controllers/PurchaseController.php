<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurchaseController extends Controller
{
    public function index()
    {
        $user = auth()->user();
            if ($user->hasRole('super-admin')) {
                $purchase = Purchase::with('user', 'product','commission')->get();
            }else{
                $purchase = Purchase::with('user', 'product','commission')->where('user_id', $user->id)->get();
            }
            return $purchase;
        //return view('sales.index', compact('purchase'));
    }

    public function purchase_commission()
    {
        $user = auth()->user();
        // $commissions = Purchase::where('user_id', $user->id)->where('transaction_type', 'purchase_commission')->get();
        $purchase_commissions = Purchase::where('user_id', $user->id)->get();

        return view('commissions.purchase_commissions', compact('purchase_commissions'));
    }

    public function purchase_now($id)
    {
        $product = Product::findOrFail($id);
        return view('purchases.purchase_now', compact('product'));

    }

    public function store_purchase($id)
    {
        $user = auth()->user();
        $customer = Customer::where('user_id', $user->id)->firstOrFail();
        $product = Product::findOrFail($id);

        $purchase = Purchase::create([
            'user_id' => $customer->user_id, // The primary user for whom the commission is calculated
            'product_id' => $product->id,
            'commission' => $product->purchase_commission
        ]);
        $transaction = Transaction::create([
            'user_id' => $customer->user_id, // The primary user for whom the commission is calculated
            'sale_id' => $purchase->id,
            'amount' => $product->purchase_commission,
            'transaction_type' => 'purchase_commission'
        ]);

        // $wallet = $customer->wallet_balance;
        // $current_user = Customer::findOrFail($customer->user_id);
        // $commission = $product->purchase_commission;
        // $current_user->wallet_balance -= $commission;
        // $current_user->save();

        $purchase_commission = $product->purchase_commission;
        $$customer->Total_sale_commission += $commission;
        $$customer->wallet_balance += $commission;
        $current_user->save();
    }
}
