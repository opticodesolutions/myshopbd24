<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function show($id)
    {
        return Sale::findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'product_price' => 'required|numeric',
        ]);

        $product = Product::with('commissions')->findOrFail($request->product_id);



        $user = User::findOrFail($request->user_id);

        // Assuming Customer model is linked to User model
        $customer = Customer::where('user_id', $user->id)->firstOrFail();


        // $customer->calculateCommissions($product);

        // $sale = Sale::create([
        //     'user_id' => $user->id,
        //     'product_id' => $product->id,
        //     'product_price' => $request->product_price,
        //     'commission' => $customer->Total_sale_commission,
        // ]);


        // Calculate commissions
        $commissionsDistributed = $customer->calculateCommissions($product);

        // Create the sale record with the total commission for the primary user
        $sale = Sale::create([
            'user_id' => $customer->user_id, // The primary user for whom the commission is calculated
            'product_id' => $product->id,
            'product_price' => $request->product_price,
            'commission' => $commissionsDistributed[0]['commission'] ?? 0, // Commission for the primary user
        ]);


        // Create a Transaction record for each distributed commission
        foreach ($commissionsDistributed as $commissionData) {
            Transaction::create([
                'user_id' => $commissionData['user_id'],
                'sale_id' => $sale->id,
                'amount' => $commissionData['commission'],
                'transaction_type' => 'commission' // Example type, adjust as needed
            ]);
        }

        // Update product stock
        $product->stock -= 1;
        $product->save();
        return redirect()->route('products.index')->with('success', 'Product Buy successfully.');

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
