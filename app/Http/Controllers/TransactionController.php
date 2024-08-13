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
            $commissions = Transaction::with('user', 'sale.product')->where('transaction_type', 'commission')->get();
        }else{
            $commissions = Transaction::with('user', 'sale.product')->where('transaction_type', 'commission')->where('user_id', $user->id)->get();
        }
        return view('commissions.index', compact('commissions'));
    }

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
