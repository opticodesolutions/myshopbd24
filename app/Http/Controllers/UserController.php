<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $customer = Customer::where('user_id', $user->id)->first();

        // Total Count referred customers
        $Total_reffers = Customer::where('refer_by', $customer->refer_code)->count();

        //Balance Customer
        $Balance_customer = $customer->wallet_balance;

        // Total withdrown amount
        $Total_withdrawn_amount = Transaction::where('transaction_type', 'withdraw')->where('user_id', $user->id)->sum('amount');

        // Total Topup amount
        $Total_topup_amount = Transaction::where('transaction_type', 'topup')->where('user_id', $user->id)->sum('amount');

        // Total transactions amount sum
        $Total_transactions_amount = Transaction::where('user_id', $user->id)->sum('amount');

        // Total Count transactions
        $Total_commission_transactions = Transaction::where('transaction_type', 'commission')->where('user_id', $user->id)->count();

        // Total Count transactions
        $Total_commission_transaction = Transaction::where('transaction_type', 'commission')->where('user_id', $user->id)->sum('amount');
        // Total earnings
       // $Total_earnings = $Total_transactions_amount - $Total_withdrawn_amount;

        // Total Count sales
        $Total_sells = Sale::where('user_id', $user->id)->count();

        // Total Sales Commission Sum
        $Total_sells_commission = Sale::where('user_id', $user->id)->sum('commission');

        $user = auth()->user();
        $data = Customer::where('user_id', $user->id)->with(['user','parent'])->get();

        $latest_users = Customer::whereHas('user', function($query) {
            $query->role('user');
        })
        ->orderBy('created_at', 'desc')
        ->get();

        $top_earner = Customer::whereHas('user', function($query) {
            $query->role('user');
        })
        ->orderBy('wallet_balance', 'desc')
        ->get();

        return view('user.home.index', compact(
            'Total_reffers',
            'Total_transactions_amount',
            'Total_commission_transactions',
            'Total_commission_transaction',
            // 'Total_earnings',
            'Total_sells',
            'Total_sells_commission',
            'Balance_customer',
            'Total_withdrawn_amount',
            'Total_topup_amount',
            'data',
            'latest_users',
            'top_earner'
        ));
    }
    public function all_users()
    {
        $customers = Customer::with(['user'])->get();

        return view ('super-admin.users.index', compact('customers'));
    }


    public function customers()
    {
        $role = 'user'; // Role for which customers should be fetched

        // Fetch customers where the associated user has the specified role
        $customers = Customer::whereHas('user', function($query) use ($role) {
            $query->whereHas('roles', function($query) use ($role) {
                $query->where('name', $role); // Check the role name
            });
        })->with('user')->get();

        return view ('super-admin.users.index', compact('customers'));
    }

    public function agents()
    {
        $role = 'agent'; // Role for which customers should be fetched

        // Fetch customers where the associated user has the specified role
        $customers = Customer::whereHas('user', function($query) use ($role) {
            $query->whereHas('roles', function($query) use ($role) {
                $query->where('name', $role); // Check the role name
            });
        })->with('user')->get();

        return view ('super-admin.users.index', compact('customers'));
    }


    public function showGenerations()
    {
        if (auth()->user()->hasRole('user')) {
            $id = auth()->user()->id;

            $user = Customer::findOrFail($id);
            $generations = $user->getGenerations();

            $tableData = [];
            $sl = 1;

            foreach ($generations as $generation => $userIds) {
                $tableData[] = [
                    'SL' => $sl++,
                    'Generation' => $generation,
                    'TotalUsers' => count($userIds),
                    'UserIDs' => implode(', ', $userIds),
                ];
            }
            return view('generations.user_generations_table', ['tableData' => $tableData]);
        }else{
            return redirect()->back()->with('error', 'Unauthorized');
        }

    }

    public function showGenerationsTree()
    {
        if (auth()->user()->hasRole('user')) {
            $id = auth()->user()->id;

            $user = Customer::findOrFail($id);
            $generationsTree = $user->getGenerationsTree();

            return view('generations.generations_tree', ['generationsTree' => $generationsTree]);
        }else{
            return redirect()->back()->with('error', 'Unauthorized');
        }

    }


}
