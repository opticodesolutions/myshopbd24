<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $customer = Customer::where('user_id', $user->id)->first();

        $customers = Customer::with([
            'user',
            'children.user',
            'children.children.user',
            'children.children.children.user', // Load up to 3 levels of children
        ])
            ->where('refer_by', $customer->refer_code)
            ->get();
        // return $customers;
         return view('customers.index', compact('customers'));
    }

    public function personal_info()
    {
        $user = auth()->user();
        $data = Customer::where('user_id', $user->id)->with(['user'])->first();
        $parent = Customer::where('refer_code', $data->refer_by)->with(['user'])->first();
        return view('customers.personal_info',compact('data', 'parent'));
    }

    public function profile_kyc()
    {
        return view('customers.profile_kyc');
    }

    public function password_change()
    {
        return view('customers.password_change');
    }

    public function joining_invoice()
    {
        return view('customers.joining_invoice');
    }



    public function show($id)
    {
        $data = Customer::findOrFail($id)->with(['user','parent'])->get();
        return view('customers.show', compact('data'));
    }

    public function my_info()
    {
        $user = auth()->user();
        $data = Customer::where('user_id', $user->id)->with(['user','parent'])->get();
        return view('customers.my-info', compact('data'));
    }

    public function store(Request $request)
    {
        $customer = Customer::create($request->all());
        return response()->json($customer, 201);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update($request->all());
        return response()->json($customer, 200);
    }

    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
