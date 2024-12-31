<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\SubcriptioRenew;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Subscription;
use Illuminate\Container\Attributes\Auth;

class SubcriptioRenewController extends Controller
{
    private $Helpers;

    public function __construct(Helpers $helpers)
    {
        $this->Helpers = $helpers;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(auth()->user()->hasRole('super-admin')) {
            $status = $request->input('status');
            $query = SubcriptioRenew::query();
            if ($status) {
                $query->where('payment_status', $status);
            }
            $query->orderBy('created_at', 'desc');
            $subcription_renewal = $query->paginate(10); 
            return view('subcription-renewal.index', compact('subcription_renewal'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subscriptions = Subscription::all();
        return view('subcription-renewal.create', compact('subscriptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'renewal_date' => 'required|date',
                'subscription_id' => 'required|numeric',
                'payment_method' => 'required|string',
                'remarks' => 'nullable|string',
            ]);

            $validatedData['renewal_amount'] = Subscription::find($validatedData['subscription_id'])->amount;
            // Insert the data using Eloquent
            SubcriptioRenew::create([
                'user_id' => $validatedData['user_id'],
                'renewal_date' => $validatedData['renewal_date'],
                'renewal_amount' => $validatedData['renewal_amount'],
                'payment_method' => $validatedData['payment_method'],
                'remarks' => $validatedData['remarks'],
                'subscription_id' => $validatedData['subscription_id'],
            ]);

            return redirect()->back()->with('success', 'Subcription Renewal request Successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SubcriptioRenew $subcriptioRenew)
    {
        $query = SubcriptioRenew::query();
        $query->where('user_id', auth()->user()->id);
        $query->orderBy('created_at', 'desc');
        $subcription_renewal = $query->paginate(10);
        return view('subcription-renewal.show', compact('subcription_renewal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubcriptioRenew $subcriptioRenew)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'renewal_date' => 'required|date',
                'payment_method' => 'required|string',
                'remarks' => 'nullable|string',
                'status' => 'required',
            ]);

            $renewal = SubcriptioRenew::with('subscription')->findOrFail($id);
            $renewal->update([
                'remarks' => $request->remark,
                'payment_status' => $request->status,
            ]);

            if ($request->status === 'approved') {
                $renewalDate = Carbon::parse($request->renewal_date);
                $renewal->customer->subscription_start_date = $renewalDate;
                $renewal->customer->subscription_end_date = $renewalDate->copy()->addMonth();
                $renewal->customer->save();
            }

            $this->Transections($renewal->customer->user_id, $renewal->renewal_amount, 'renewal_amount');

            $allchildUser = $this->Helpers->getAllChildUsersIdsForRoot($renewal->customer->refer_code);

            if (!empty($allchildUser)) {
                // Retrieve refer_by, user_id, and refer_code for the child users
                $childParentUsers = Customer::whereIn('user_id', $allchildUser)
                ->get(['user_id', 'refer_by', 'refer_code']);
                $filteredChildParentUsers = $childParentUsers->filter(function ($user) {
                    return !empty($user->refer_by);
                });
            }

            $totalAmount = $renewal->renewal_amount;
            $perchildAmount = $renewal->subscription->per_child_amount;
            $perPerentAmount = $renewal->subscription->per_person;
            foreach ($filteredChildParentUsers as $childParentUser) {
                if($totalAmount > 0){
                    $totalAmount = $totalAmount - $perPerentAmount;
                    $this->Transections($childParentUser->user_id, $perPerentAmount, 'Insective_Subcription_Income');
                    $user = Customer::where('user_id', $childParentUser->user_id)->first();
                    $user->wallet_balance = $user->wallet_balance + $perPerentAmount;
                    $user->save();
                }
                if ($totalAmount <= 0) {
                    break;
                }
            }

            foreach ($allchildUser as $childuser) {
                if($totalAmount > 0){
                    $totalAmount = $totalAmount - $perchildAmount;
                    $this->Transections($childuser, $perchildAmount, 'Bonus_form_Subcription_Income');
                    $user = Customer::where('user_id', $childuser)->first();
                    $user->wallet_balance = $user->wallet_balance + $perchildAmount;
                    $user->save();
                }
                if ($totalAmount <= 0) {
                    break;
                }
            }
            if ($totalAmount > 0) {
                // Admin profit transaction
                $transection = $this->Transections(auth()->user()->id, $totalAmount, 'Admin_Profit_from_Subscription');
                Account::create([
                    'amount' => $totalAmount,
                    'type' => 'debit',
                    'tran_id' => $transection,
                    'approved_by' => auth()->user()->id
                ]);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Subcription Renewal request Successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    private function Transections($user_id, $amount, $type){
       $transection = Transaction::create([
            'user_id' => $user_id,
            'amount' => $amount,
            'transaction_type' => $type
        ]);
        return $transection->id;
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
           $data = SubcriptioRenew::where('id', $id)->where('payment_status', 'pending')->delete();
           if (!$data) {
               return redirect()->back()->with('error', 'Approved Subcription Renewal Cannot Delete.');
           }
           return redirect()->back()->with('success', 'Subcription Renewal request Successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
