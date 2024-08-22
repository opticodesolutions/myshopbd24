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

    public function purchase_save(Request $request)
    {

        $purchase = Purchase::create([
            'user_id' => $request->user_id, // The primary user for whom the commission is calculated
            'product_id' => $request->product_id,
            'commission' => $request->purchase_commission
        ]);

        $transaction = Transaction::create([
            'user_id' => $request->user_id, // The primary user for whom the commission is calculated
            'purchase_id' => $purchase->id,
            'amount' => $request->purchase_commission,
            'transaction_type' => 'purchase_commission'
        ]);
        $customer = Customer::where('user_id', $request->user_id)->first();

        if ($request->payment_method == "Cash") {
            $purchase_commission = $request->purchase_commission;
            // $customer->Total_purchase_commission += $request->purchase_commission; Nedd to make Total_purchase_commission feld in customer
            $customer->wallet_balance += $request->purchase_commission;
            $customer->save();
        return redirect()->route('purchase.commission')->with('success', 'Purchase commission added successfully');

        }else{
            return redirect()->route('purchase.commission')->with('error', 'Purchase commission not added successfully');
        }

    }
}
