<?php
 
namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::orderBy('id', 'desc')->paginate(10);
        return view('subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        return view('subscriptions.create');
    }

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
        ]);

        Subscription::create($validated);

        return redirect()->route('subscriptions.index')->with('success', 'Subscription created successfully.');
    }

    public function edit($id)
    {
        $subscription = Subscription::findOrFail($id);
        return view('subscriptions.edit', compact('subscription'));
    }

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
        ]);

        $subscription = Subscription::findOrFail($id);
        $subscription->update($validated);

        return redirect()->route('subscriptions.index')->with('success', 'Subscription updated successfully.');
    }

    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        return redirect()->route('subscriptions.index')->with('success', 'Subscription deleted successfully.');
    }
}