<?php

namespace App\Http\Controllers;

use App\Models\IncentiveIncome;
use Illuminate\Http\Request;

class IncentiveIncomeController extends Controller
{
    public function index()
    {
        $incentiveIncomes = IncentiveIncome::paginate(10);
        return view('incentive_income.index', compact('incentiveIncomes'));
    }

    public function create()
    {
        return view('incentive_income.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'designation_name' => 'required|string',
            'child_and_children' => 'required|integer',
            'matching_sale' => 'required|integer',
            'amount' => 'required|numeric',
            'text' => 'nullable|string',
        ]);

        IncentiveIncome::create($request->all());
        return redirect()->route('incentive_income.index')->with('success', 'Record created successfully.');
    }

    public function edit($id)
    {
        $incentiveIncome = IncentiveIncome::findOrFail($id);
        return view('incentive_income.edit', compact('incentiveIncome'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'designation_name' => 'required|string',
            'child_and_children' => 'required|integer',
            'matching_sale' => 'required|integer',
            'amount' => 'required|numeric',
            'text' => 'nullable|string',
        ]);

        $incentiveIncome = IncentiveIncome::findOrFail($id);
        $incentiveIncome->update($request->all());
        return redirect()->route('incentive_income.index')->with('success', 'Record updated successfully.');
    }

    public function destroy($id)
    {
        $incentiveIncome = IncentiveIncome::findOrFail($id);
        $incentiveIncome->delete();
        return redirect()->route('incentive_income.index')->with('success', 'Record deleted successfully.');
    }
}