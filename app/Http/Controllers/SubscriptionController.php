<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\SubscriptionSale;
use App\Models\User;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SubscriptionController extends Controller
{
    private $subscriptionService;
    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }
    // Display a list of subscriptions
    public function index()
    {
        $subscriptions = Subscription::orderBy('id', 'desc')->paginate(10);
        return view('subscriptions.index', compact('subscriptions'));
    }

    // Show the form for creating a new subscription
    public function create()
    {
        return view('subscriptions.create');
    }

    // Store a newly created subscription in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'per_person' => 'nullable|numeric',
            'lavel' => 'nullable|integer',
            'ref_income' => 'required|numeric',
            'insective_income' => 'required|numeric',
            'daily_bonus' => 'required|numeric',
            'admin_profit_salary' => 'required|numeric',
            'admin_profit' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('subscriptions', 'public');
        }

        Subscription::create($validated);

        return redirect()->route('subscriptions.index')->with('success', 'Subscription created successfully.');
    }

    // Show the form for editing a subscription
    public function edit($id)
    {
        $subscription = Subscription::findOrFail($id);
        return view('subscriptions.edit', compact('subscription'));
    }

    // Update a subscription in storage
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'per_person' => 'nullable|numeric',
            'lavel' => 'nullable|integer',
            'ref_income' => 'required|numeric',
            'insective_income' => 'required|numeric',
            'daily_bonus' => 'required|numeric',
            'admin_profit_salary' => 'required|numeric',
            'admin_profit' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        $subscription = Subscription::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($subscription->image) {
                Storage::disk('public')->delete($subscription->image);
            }

            $validated['image'] = $request->file('image')->store('subscriptions', 'public');
        }

        $subscription->update($validated);

        return redirect()->route('subscriptions.index')->with('success', 'Subscription updated successfully.');
    }

    // Remove a subscription from storage
    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);

        // Delete associated image if exists
        if ($subscription->image) {
            Storage::disk('public')->delete($subscription->image);
        }

        $subscription->delete();

        return redirect()->route('subscriptions.index')->with('success', 'Subscription deleted successfully.');
    }

    public function details($id)
    {
        $subscription = Subscription::findOrFail($id);
        $categories = Category::all();
        return view('frontend.subscription.show', compact('subscription', 'categories'));
    }

    public function sale_now(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);
        return view('sales.subscription-sale', compact('subscription'));
    }

    public function sale_now_store(Request $request)
    {
        // return $request->all();
        try {
            DB::beginTransaction();
            // Fetch Subscription Details
            $subscription = Subscription::findOrFail($request->subscription_id);
            // Create User (if "Register New User" is checked)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole("user");
            // Fetch Refer By Customer
            $referByCustomer = Customer::where('refer_code', $request->refer_code)->first();

            // Create Customer
            $customer = Customer::create([
                'user_id' => $user->id,
                'Total_Sales' => 0,
                'refer_code' => strtoupper(substr(md5(time() . $user->id), 0, 10)), // Generate unique referral code
                'refer_by' => $request->refer_code ?? null,
                'position_parent' => $referByCustomer ? $referByCustomer->id : null,
                'position' => $request->position,
                'level' => $referByCustomer ? $referByCustomer->level + 1 : 1,
                'Total_sale_commission' => 0,
                'matching_commission' => 0,
                'wallet_balance' => -$subscription->amount,
                'subscription_start_date' => now(),
                'subscription_end_date' => now(),
            ]);

            if (!$customer) {
                throw new \Exception('Customer creation failed.');
            }
            // Process Subscription Sale
            $parent = Customer::where('refer_code', $request->refer_code)->first();

            SubscriptionSale::create([
                'subscription_id' => $subscription->id,
                'user_id' => $parent ? $parent->user_id : $user->id,
                'customer_id' => $customer->id,
                'total_amount' => $subscription->amount,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Subscription sale created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function subscription_sales(){
        $subscriptionSales = SubscriptionSale::with('subscription','user', 'customer')->orderBy('id', 'desc')->paginate(10);
        return view('subscriptions.subscription-sales', compact('subscriptionSales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function subscription_sales_status(Request $request, $id){
        $subscriptionSale = SubscriptionSale::findOrFail($id);
        if($request->status == 'approved'){
           $subscriptionSale->update(['status' => 'approved']);
           return $this->subscriptionService->DistibuteCommssion($subscriptionSale);
        }
        return redirect()->back()->with('success', 'Subscription sale updated successfully.');
    }
}
