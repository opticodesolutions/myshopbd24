<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->hasRole('super-admin')) {
            $all = Transaction::with('user', 'sale.product')
            ->orderby('id', 'desc')
            ->paginate(20);
            return view('commissions.index', compact('all'));

        }else{
            $commissions = Transaction::with('user', 'sale.product')->where('transaction_type', 'sale_commission')->where('user_id', $user->id)->get();
        }
    }

    public function total_commission(){
        $user = auth()->user();
        if ($user->hasRole('user')) {
            $commissions = Transaction::with(['user', 'sale.product'])->where('user_id', $user->id)->whereIn('transaction_type', ['sale_commission', 'refer_commission', 'purchase_commission'])->get();
            // return $commissions;
            return view('commissions.total_commission', compact('commissions'));
        }else{
           return redirect()->back()->with('error', 'Unauthorized');
        }

    }

    // public function refer_commissions()
    // {
    //     $user = auth()->user();
    //     $refer_code = $user->customer->refer_code;
    //     $refers = Customer::where('refer_by', $refer_code)->get();

    //     return $refer_code;
    // }

    public function show($id)
    {
        return Transaction::findOrFail($id);
    }

    public function store(Request $request)
    {
        $transaction = Transaction::create($request->all());
        return response()->json($transaction, 201);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->all());
        return response()->json($transaction, 200);
    }

    public function destroy($id)
    {
        Transaction::findOrFail($id)->delete();
        return response()->json(null, 204);
    }

    public function Admin_Subscription_fee(Request $request){

        $user = auth()->user();
        if ($user->hasRole('super-admin')) {
            // Fetch paginated results
            $admin_subscription_fee = Transaction::where('transaction_type', 'admin_subscription_fee')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

            // Calculate the total amount from the paginated results
            $totalAmount = $admin_subscription_fee->sum('amount');

            // Return view with paginated data and total amount
            return view('commissions.admin_subscription_fee', compact('admin_subscription_fee', 'totalAmount'));
        } else {
            return redirect()->back()->with('error', 'Unauthorized');
        }
    }
}
