<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class SuperAdminController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $customer = Customer::where('user_id', $user->id)->first();

        // Total Count customers
        $Total_customer = DB::table('model_has_roles')
        ->where('role_id', 4)
        ->count();
        // $role = 'user';
        // $Total_customer = Customer::whereHas('user', function($query) use ($role) {
        //     $query->whereHas('roles', function($query) use ($role) {
        //         $query->where('name', $role); // Assuming 'name' is the column where role names are stored
        //     });
        // })->with('user')->count();
        //Balance Customer
        // $Balance_customer = $customer->wallet_balance;

        // Total withdrown amount
        $Total_withdrawn_amount = Transaction::where('transaction_type', 'withdraw')->sum('amount');

        $Total_admin_income = Transaction::where(function($query) {
            $query->where('transaction_type', 'admin_profit_from_matching_commission')
                  ->orWhere('transaction_type', 'admin_subscription_fee');
        })->sum('amount');

        // Total Topup amount
        $Total_topup_amount = Transaction::where('transaction_type', 'topup')->sum('amount');

        // Total transactions amount sum
        $Total_transactions_amount = Transaction::sum('amount');

        // Total Count transactions
        $Total_commission_transactions = Transaction::where('transaction_type', 'downline_bonus')->count();

        // Total Count transactions
        $Total_commission_transaction = Transaction::where('transaction_type', 'downline_bonus')->sum('amount');
        // Total earnings
       // $Total_earnings = $Total_transactions_amount - $Total_withdrawn_amount;

        // Total Count sales
        $Total_sells = Sale::count();

        // Total Sales Commission Sum
        $Total_sells_commission = Transaction::where('transaction_type', 'direct_bonus')->sum('amount');

        // Total Dabits
        $totaldabit = Account::where('type', 'debit')->sum('amount');
        // Total Credits
        $totalcredit = Account::where('type', 'cradit')->sum('amount');

        return view('super-admin.home.index', compact(
            'Total_customer',
            'Total_transactions_amount',
            'Total_commission_transactions',
            'Total_commission_transaction',
            // 'Total_earnings',
            'Total_sells',
            'Total_sells_commission',
            // 'Balance_customer',
            'Total_withdrawn_amount',
            'Total_topup_amount',
            'Total_admin_income',
            'totaldabit',
            'totalcredit'
        ));
    }

    public function QueueJob(Request $request)
    {
        $jobs = DB::table('jobs')
        ->select('id', 'queue', 'payload', 'attempts', 'reserved_at', 'available_at', 'created_at')
        ->get();

        $faild = DB::table('failed_jobs')
        ->select('id', 'connection', 'queue', 'payload', 'exception', 'failed_at')
        ->get();

        $totalPendingJobs = DB::table('jobs')->count();
        $totalFieldJobs = DB::table('failed_jobs')->count();
        $output = shell_exec('ps aux | grep "queue:work" | grep -v "grep"');

        $isRunning = !empty($output);
        return view('super-admin.queue-job.index', compact('isRunning','jobs', 'faild','totalPendingJobs','totalFieldJobs'));
    }

    public function QueueJobPOST(Request $request)
    {
        try {
            sleep(10);
            // // Trigger queue worker
            Artisan::call('queue:work', [
                '--stop-when-empty' => true, 
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Job queued successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Error processing job queue: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to process the job queue',
            ], 500);
        }
    }
}
