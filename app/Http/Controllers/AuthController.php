<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            $user = auth()->user();
            if ($user->hasRole('super-admin')) {
                return redirect('/super-admin');
            } elseif ($user->hasRole('admin')) {
                return redirect('/admin');
            } elseif ($user->hasRole('agent')) {
                return redirect('/agent');
            } elseif ($user->hasRole('user')) {
                return redirect('/user');
            }
            return redirect('/home');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function signUp()
    {
        return view('auth.signUp');
    }

    public function signUpProcess(RegistrationRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole($request->role);
        // $refer_code = Customer::where('refer_code', $request->refer_code)->first();
        $user->customer()->create([
            //rendom refer code
            'refer_code' => "REF".rand(1000,9999) ?? null,
            'refer_by' => $request->refer_code ?? null
        ]);
        return redirect('/login')->with('status', 'Registration successful! Please log in.');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
