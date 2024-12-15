<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\CommissionService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SaleController extends Controller
{
    private $combinedData;

    public function __construct(CommissionService $commissionService)
    {
        $this->combinedData = $commissionService;
    }
    public function index()
    {
        $user = auth()->user();
            if ($user->hasRole('super-admin')) {
                $sales = Sale::with('user', 'product')->get();

                //$purchases = Purchase::with('user', 'product' )->get();

                // $combinedData = $sales->merge($purchases);
            }else{
                $sales = Sale::with('user', 'product')->where('user_id', $user->id)->get();
            }
            // return $purchases
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
        // $request->validate([
        //     'product_id' => 'required|exists:products,id',
        //     'quantity' => 'required|integer|min:1',
        //     'name' => 'required|string',
        //     'email' => 'required|email|unique:users,email',
        //     'password' => 'required|string|confirmed',
        //     'refer_code' => 'sometimes|string',
        //     'position' => 'required|in:left,right',
        // ]);

        // Check product availability

    public function store(Request $request)
    {

        $product = Product::findOrFail($request->product_id);
        if ($product->stock < $request->quantity??1) {
            return back()->with('error', 'Insufficient stock.');
        }

            // Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole("user");


            // Create Customer
        $referByCustomer = Customer::where('refer_code', $request->refer_code)->first();//parent


        $customer = Customer::create([
            'user_id' => $user->id,
            'Total_Sales' => 0,
            'refer_code' => strtoupper(substr(md5(time() . $user->id), 0, 10)), // Generate unique referral code
            // 'refer_by' => $referByCustomer ? $referByCustomer->refer_code : null,
            'refer_by' => $request->refer_code ?? null,

            // 'position_parent' => $referByCustomer ? $referByCustomer->id : null,
            'position_parent' => $request->refer_code ?? null,

            'position' => $request->position,
            'level' => $referByCustomer ? $referByCustomer->level + 1 : 1,
            'Total_sale_commission' => 0,
            'matching_commission' => 0,
            'wallet_balance' => -$product->price,
            'subscription_start_date' => now(),
            'subscription_end_date' => now()->addMonth(),
        ]);

            // Process Sale
        $totalAmount = $product->price * $request->quantity??1;
        $parent = Customer::where('refer_code', $request->refer_code)->first();
        $sale = Sale::create([
            'product_id' => $product->id,
            'user_id' => $parent->user_id,
            'customer_id' => $customer->user_id,
            'price' => $product->price,
            'quantity' => $request->quantity ?? 1,
            'total_amount' => $totalAmount,
        ]);

        // Adjust stock
        $product->decrement('stock', $request->quantity??1);

        return redirect()->route('products.index')->with('success', 'Product purchased and user created successfully.');
    }


    public function updateStatus(Request $request, Sale $sale)
    {

        $customer_wallet = Customer::where('user_id', $sale->customer_id)->first();
        if($customer_wallet->wallet_balance>0){
            return back()->with('error', 'Your Account Not Active.');
        }else{
            $request->validate(['status' => 'required|in:confirmed,processing,ready,delivered']);
            
            $sale->update(['status' => $request->status]);

            if ($request->status === 'delivered') {
                // Trigger commission calculation
                $this->combinedData->calculateCommissions($sale);
            }
            return back()->with('success', 'Sale status updated successfully.');
        }
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
