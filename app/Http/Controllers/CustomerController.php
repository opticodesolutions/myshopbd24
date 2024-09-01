<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        $user = auth()->user();
        $customer = Customer::with('user')->where('user_id', $user->id)->first();
        // return $customer;

        return view('customers.profile_kyc', compact('user'));
    }

    public function kyc_update(Request $request)
    {
        $user = Auth::user();

        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'nominee_name' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:10',
            'national_id' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'profession' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update user information
        $user->name = $validated['name'];
        $user->father_name = $validated['father_name'] ?? $user->father_name;
        $user->mother_name = $validated['mother_name'] ?? $user->mother_name;
        $user->nominee_name = $validated['nominee_name'] ?? $user->nominee_name;
        $user->religion = $validated['religion'] ?? $user->religion;
        $user->blood_group = $validated['blood_group'] ?? $user->blood_group;
        $user->national_id = $validated['national_id'] ?? $user->national_id;
        $user->date_of_birth = $validated['date_of_birth'] ?? $user->date_of_birth;
        $user->profession = $validated['profession'] ?? $user->profession;
        $user->address = $validated['address'] ?? $user->address;

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete the old profile picture if it exists
            if ($user->profile_picture) {
                Storage::delete($user->profile_picture);
            }

            // Store the new profile picture
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures');
            $user->profile_picture = $profilePicturePath;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function password_change()
    {
        $user = auth()->user();
        return view('customers.password_change', compact('user'));
    }

    public function password_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->back()->with('success', 'Password updated successfully.');
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

    public function refer_info(){

        $user = auth()->user();
        $data = Customer::where('user_id', $user->id)->with(['user','children'])->get();
        // return $data;
        return view('customers.refer-info', compact('data'));
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
