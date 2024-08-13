<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function topupIndex()
    {
        $topups = Payment::where('type', 'topup', )->where('user_id', Auth::id())->get();
        return view('user.Payments.Topup.index', compact('topups'));
    }

    public function withdrawIndex()
    {
        $withdrawals = Payment::where('type', 'withdraw')->where('user_id', Auth::id())->get();
        return view('user.Payments.withdraw.index', compact('withdrawals'));
    }

    public function createTopup()
    {
        return view('user.Payments.Topup.create');
    }

    public function createWithdraw()
    {
        return view('user.Payments.withdraw.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:cash,Bkash',
            'account_id' => 'nullable|integer',
            'transaction_id' => 'nullable|string',
            'amount' => 'required|numeric',
            'type' => 'required|in:topup,withdraw',
        ]);

        $data['status'] = 'pending';

        Payment::create($data);

        return redirect()->back()->with('success', 'Payment request created successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $user = auth()->user();
        $customer = Customer::where('user_id', $user->id)->first();

        // Find the user from the request
        $request_user = User::findOrFail($request->user_id);
        $request_user_info = Customer::where('user_id', $request_user->id)->first();

        // Determine role
        $role = $user->hasRole('super-admin') ? 'super-admin' :
                ($user->hasRole('admin') ? 'admin' :
                ($user->hasRole('agent') ? 'agent' : 'user'));

        $data = [
            'status' => $request->status,
            'created_by_user_id' => $user->id,
            'created_by' => $role,
            'created_by_sms' => $request->created_by_sms,
        ];

        if ($request->status === 'success') {
            $data['account_id'] = $request->account_id;
            $data['transaction_id'] = $request->transaction_id;

            // Update user wallet balance based on the type
            if ($request->type === 'topup') {
                $request_user_info->wallet_balance += $request->amount;
                Transaction::create([
                    'user_id' => $request->user_id,
                    'sale_id' => null,
                    'amount' => $request->amount,
                    'transaction_type' => 'topup',
                ]);
            } elseif ($request->type === 'withdraw') {
                if ($request_user_info->wallet_balance < $request->amount) {
                    return redirect()->back()->with('error', 'Insufficient balance.');
                } else {
                    $request_user_info->wallet_balance -= $request->amount;
                    Transaction::create([
                        'user_id' => $request->user_id,
                        'sale_id' => null,
                        'amount' => $request->amount,
                        'transaction_type' => 'withdraw',
                    ]);
                }
            }
            $request_user_info->save();


        }

        $payment->update($data);

        return redirect()->back()->with('success', 'Payment status updated successfully.');
    }


    public function topupList()
    {
        $topups = Payment::where('type', 'topup')->get();
        return view('super-admin.Payments.Topup.index', compact('topups'));
    }

    public function withdrawList()
    {
        $withdrawals = Payment::where('type', 'withdraw')->get();
        return view('super-admin.Payments.withdraw.index', compact('withdrawals'));
    }
}
