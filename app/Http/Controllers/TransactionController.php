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
            $commissions = Transaction::with('user', 'sale.product')->where('transaction_type', 'sale_commission')->get();
        }else{
            $commissions = Transaction::with('user', 'sale.product')->where('transaction_type', 'sale_commission')->where('user_id', $user->id)->get();
        }
        return view('commissions.index', compact('commissions'));
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
}
