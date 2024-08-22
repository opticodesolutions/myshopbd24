<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SaleController extends Controller
{
    public function index()
    {
        $user = auth()->user();
            if ($user->hasRole('super-admin')) {
                $sales = Sale::with('user', 'product','commission')->get();
            }else{
                $sales = Sale::with('user', 'product','commission')->where('user_id', $user->id)->get();
            }
        return view('sales.index', compact('sales'));
    }

    public function sale_now($id)
    {
        $product = Product::findOrFail($id);
        return view('sales.sale_now', compact('product'));
    }

    public function refer_commissions()
    {
        $user = auth()->user();
        $commissions = Transaction::where('user_id', $user->id)->where('transaction_type', 'refer_commission')->get();
        // $refer_code = $user->customer->refer_code;
        // $refers = Customer::where('refer_by', $refer_code)->user_id;
        // $my_reffer_sall_id = Sale::where('user_id', $user->id)->pluck('id');
         //return $commissions;
        return view('commissions.index', compact('commissions'));
    }

    public function show($id)
    {
        return Sale::findOrFail($id);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'product_id' => 'required|exists:products,id',
        //     'user_id' => 'required|exists:users,id',
        //     'product_price' => 'required|numeric',
        //     'purchase_commission' => 'required|numeric', // Added validation
        //     'name' => 'sometimes|required|string',
        //     'email' => 'sometimes|required|email',
        //     'password' => 'sometimes|required|confirmed',
        //     'refer_code' => 'sometimes|string'
        // ]);

        $product = Product::with('commissions')->findOrFail($request->product_id);
        $user = User::findOrFail($request->user_id);
        $customer = Customer::where('user_id', $user->id)->firstOrFail(); // seller

        if ($request->name && $request->email && $request->password && $request->password_confirmation && $request->refer_code) {

            // Create user
            $purchase_user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $purchase_user->assignRole($request->role);

            $purchase_user->customer()->create([
                'refer_code' => "REF" . rand(1000, 9999),
                'refer_by' => $request->refer_code ?? null
            ]);

            // Create Purchase
            $purchase = Purchase::create([
                'user_id' => $purchase_user->id, // The primary user for whom the commission is calculated
                'product_id' => $request->product_id,
                'commission' => $request->purchase_commission
            ]);

            // Create Transaction
            $transaction = Transaction::create([
                'user_id' => $purchase_user->id, // Corrected from $purchase_user->user_id
                'purchase_id' => $purchase->id,
                'amount' => $request->purchase_commission,
                'transaction_type' => 'purchase_commission'
            ]);

            // Balance Add To purchase_user_customer_table
            $purchase_user_customer_table = Customer::where('user_id', $purchase_user->id)->first();

            if ($request->payment_method == "Cash") {
                $purchase_commission = $request->purchase_commission;
                $purchase_user_customer_table->wallet_balance += $purchase_commission;
                $purchase_user_customer_table->save();
            }
        }

        // Calculate commissions
        $commissionsDistributed = $customer->calculateCommissions($product);

        // Create the sale record with the total commission for the primary user
        $sale = Sale::create([
            'user_id' => $customer->user_id, // The primary user for whom the commission is calculated
            'product_id' => $product->id,
            'product_price' => $request->product_price,
            'commission' => $commissionsDistributed[0]['commission'] ?? 0, // Commission for the primary user
        ]);

        $first = true; // Initialize a flag to track the first iteration

        foreach ($commissionsDistributed as $commissionData) {
            // Determine the transaction type based on whether it's the first transaction or not
            $transactionType = $first ? 'sale_commission' : 'refer_commission';

            // Create the transaction
            Transaction::create([
                'user_id' => $commissionData['user_id'],
                'sale_id' => $sale->id,
                'amount' => $commissionData['commission'],
                'transaction_type' => $transactionType
            ]);

            // Set the flag to false after the first iteration
            $first = false;
        }

        // Update product stock
        $product->stock -= 1;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product purchased successfully.');
    }



    // public function update(Request $request, $id)
    // {
    //     $sale = Sale::findOrFail($id);
    //     $sale->update($request->all());
    //     return response()->json($sale, 200);
    // }

    public function destroy($id)
    {
        Sale::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
