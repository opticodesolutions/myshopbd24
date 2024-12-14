<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::with('user')->get();
        return view('super-admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('super-admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'created_by' => 'required',
        ]);

        Brand::create($request->all());

        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
    }

    public function show(Brand $brand)
    {
        return view('super-admin.brands.show', compact('brand'));
    }

    public function edit(Brand $brand)
    {
        return view('super-admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required',
            'created_by' => 'required',
        ]);

        $brand->update($request->all());

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully.');
    }
}
