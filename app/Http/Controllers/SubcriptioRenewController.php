<?php

namespace App\Http\Controllers;

use App\Models\SubcriptioRenew;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubcriptioRenewController extends Controller
{
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
        return view('subcription-renewal.create');
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
                'renewal_amount' => 'required|numeric',
                'payment_method' => 'required|string',
                'remarks' => 'nullable|string',
            ]);

            // Insert the data using Eloquent
            SubcriptioRenew::create([
                'user_id' => $validatedData['user_id'],
                'renewal_date' => $validatedData['renewal_date'],
                'renewal_amount' => $validatedData['renewal_amount'],
                'payment_method' => $validatedData['payment_method'],
                'remarks' => $validatedData['remarks'],
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
                'status' => 'required|in:pending,approved',
            ]);

            $renewal = SubcriptioRenew::findOrFail($id);
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
            Transaction::create([
                'user_id' => $renewal->user_id,
                'amount' => $renewal->renewal_amount,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->status,
                'transaction_type' => 'subscription_renewal',
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Subcription Renewal request Successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
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
