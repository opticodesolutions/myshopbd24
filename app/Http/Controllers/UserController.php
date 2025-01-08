<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Helpers\SubGenerationHelper;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\IncentiveIncome;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $tree;
    public function __construct(Helpers $helpers)
    {
        $this->tree = $helpers;
    }

    public function index()
    {
        $user = auth()->user();
        $customer = Customer::where('user_id', $user->id)->first();
        $total_users = $this->tree->getTotalUsersForRoot($customer->refer_code);
        
        $levelUsers = SubGenerationHelper::getLevelWiseUsers($customer->refer_code);

        // return response()->json(['data' => $levelUsers]);

        $designation = $this->tree->GetDesignation($total_users);
        $totalReferIncome = Transaction::where('user_id', $user->id)->where('transaction_type', 'direct_bonus')->sum('amount');
        // return $total_users;
        // return $this->tree->getAllChildUsersIdsForRoot($customer->refer_code);
        // return $this->tree->getUsersIdsForLevel($customer->refer_code, 5);
        
//         // Total Count referred customers
//         $Total_reffers = Customer::where('refer_by', $customer->refer_code)->count()+;

//         //Balance Customer
        $Balance_customer = $customer->wallet_balance??0;

//         // Total withdrown amount
//         $Total_withdrawn_amount = Transaction::where('transaction_type', 'withdraw')->where('user_id', $user->id)->sum('amount');

//         // Total Topup amount
//         $Total_topup_amount = Transaction::where('transaction_type', 'topup')->where('user_id', $user->id)->sum('amount');

//         // Total transactions amount sum
//         $Total_transactions_amount = Transaction::where('user_id', $user->id)->sum('amount');

//         // Total Count transactions
//         $Total_commission_transactions = Transaction::where('transaction_type', 'commission')->where('user_id', $user->id)->count();

//         // Total Count transactions
//         $Total_commission_transaction = Transaction::where('transaction_type', 'commission')->where('user_id', $user->id)->sum('amount');
//         // Total earnings
//        // $Total_earnings = $Total_transactions_amount - $Total_withdrawn_amount;

//         // Total Count sales
//         $Total_sells = Sale::where('user_id', $user->id)->count();

//         // Total Sales Commission Sum
//         $Total_sells_commission = Sale::where('user_id', $user->id)->sum('commission');

//         $user = auth()->user();
        $data = Customer::where('user_id', $user->id)->with(['user','parent'])->get();

        $latest_users = Customer::whereHas('user', function($query) {
            $query->role('user');
        })
        ->orderBy('created_at', 'desc')
        ->get();

        //         $top_earner = Customer::whereHas('user', function($query) {
        //             $query->role('user');
        //         })
        //         ->orderBy('wallet_balance', 'desc')
        //         ->get();

        //         // Sum of purchase commission amounts
        $purchase_inc = Transaction::where('user_id', $user->id)
            ->where('transaction_type', 'purchase_commission')
            ->sum('amount');

        // // Sum of sale commission amounts
        $sale_inc = Transaction::where('user_id', $user->id)
            ->where('transaction_type', 'sale_commission')
            ->sum('amount');

        // // Sum of refer commission amounts
        // $refer_inc = Transaction::where('user_id', $user->id)
        //     ->where('transaction_type', 'refer_commission')
        //     ->sum('amount');

        // // Total sum of all types of commissions
        $Total_inc = Transaction::where('user_id', $user->id)
            ->whereIn('transaction_type', ['sale_commission', 'refer_commission', 'purchase_commission'])
            ->sum('amount');

        $incentiveIncomes = IncentiveIncome::paginate(10);
        return view('user.home.index', compact(
            // 'Total_reffers',
            // 'Total_transactions_amount',
            // 'Total_commission_transactions',
            // 'Total_commission_transaction',

            // 'Total_earnings',

            // 'Total_sells',
            // 'Total_sells_commission',
            'Balance_customer',
            // 'Total_withdrawn_amount',
            // 'Total_topup_amount',
            'data',
            'latest_users',
            'incentiveIncomes',
            'designation',
            'total_users',
            'totalReferIncome',
            'purchase_inc',
            'sale_inc',
            'Total_inc',
            'levelUsers'
            // 'top_earner',
            // 'purchase_inc', 'sale_inc', 'refer_inc', 
        ));
    }
    public function all_users()
    {
        $customers = Customer::with(['user'])->get();

        return view ('super-admin.users.index', compact('customers'));
    }


    public function customers()
    {
        // $role = 'user'; // Role for which customers should be fetched

        // // Fetch customers where the associated user has the specified role
        // $customers = Customer::whereHas('user', function($query) use ($role) {
        //     $query->whereHas('roles', function($query) use ($role) {
        //         $query->where('name', $role); // Check the role name
        //     });
        // })->with('user')->get();
        $customers = Customer::with(['user'])->get();
       // return $customers;
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

            $refercode = Customer::with('user')->where('user_id', auth()->user()->id)->first();
            $rootReferCode = $refercode->refer_code;
            $tree = $this->tree->getTree($rootReferCode);
            $userLevels = [];
            $this->tree->collectUsersByLevel($tree, $userLevels);
            // Prepare user count at each level
            $userCounts = [];
            foreach ($userLevels as $level => $userIds) {
                $userCounts[$level] = count($userIds);  
            }
            return view('generations.user_generations_table', compact('userLevels', 'userCounts'));
        }else{
            return redirect()->back()->with('error', 'Unauthorized');
        }

    }

    public function showGenerationsTree()
    {
        $refercode = Customer::with('user')->where('user_id', auth()->user()->id)->first();
        $rootReferCode = $refercode->refer_code;
        $tree = $this->tree->getTree($rootReferCode);

        // return $tree;
        return view('binary-tree', compact('tree'));

    }

    public function branch_list(){

        return view('user.branch_list');
    }

    public function user_distroy(Request $request, $id){
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'User Deleted Successfully');
    }


}
