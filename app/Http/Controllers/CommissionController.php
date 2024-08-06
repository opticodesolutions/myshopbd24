<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CommissionController extends Controller
{
    public function index()
    {
        $commissions = Commission::with('product')->get();
        return view('super-admin.pages.commissions.index', compact('commissions'));
    }

    public function create()
    {
        $products = Product::all();
        return view('super-admin.pages.commissions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'amount' => 'required|numeric',
        ]);

        // Check if a commission with the same product_id already exists
        $existingCommission = Commission::where('product_id', $request->product_id)->first();

        if ($existingCommission) {
            return redirect()->route('commissions.create')
                             ->with('error', 'A commission for this product already exists.');
        }

        // Create the new commission
        Commission::create($request->all());

        return redirect()->route('commissions.index')
                         ->with('success', 'Commission created successfully.');
    }

    public function show(Commission $commission)
    {
        return view('super-admin.pages.commissions.show', compact('commission'));
    }

    public function edit(Commission $commission)
    {
        $products = Product::all();
        return view('super-admin.pages.commissions.edit', compact('commission', 'products'));
    }

    public function update(Request $request, Commission $commission)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'amount' => 'required|numeric',
        ]);

        $commission->update($request->all());

        return redirect()->route('commissions.index')->with('success', 'Commission updated successfully.');
    }

    public function destroy(Commission $commission)
    {
        $commission->delete();

        return redirect()->route('commissions.index')->with('success', 'Commission deleted successfully.');
    }
}
