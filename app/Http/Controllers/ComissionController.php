<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ComissionController extends Controller
{
    public function index()
    {
        $commissions = Commission::with('product')->get();
        return view('commissions.index', compact('commissions'));
    }

    public function create()
    {
        $products = Product::all();
        return view('commissions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        Commission::create($request->all());

        return redirect()->route('commissions.index')->with('success', 'Commission created successfully.');
    }

    public function show(Commission $commission)
    {
        return view('commissions.show', compact('commission'));
    }

    public function edit(Commission $commission)
    {
        $products = Product::all();
        return view('commissions.edit', compact('commission', 'products'));
    }

    public function update(Request $request, Commission $commission)
    {
        $request->validate([
            'product_id' => 'required',
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
