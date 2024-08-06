<?php

namespace App\Http\Controllers;

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

            // Get the authenticated user
            $user = auth()->user();

            // Redirect based on user role
            if ($user->hasRole('super-admin')) {
                return redirect('/super-admin');
            } elseif ($user->hasRole('admin')) {
                return redirect('/admin');
            } elseif ($user->hasRole('agent')) {
                return redirect('/agent');
            } elseif ($user->hasRole('user')) {
                return redirect('/user');
            }

            // Default redirect if no role matches
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

    public function signUpProcess(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', 'string', 'in:super-admin,admin,agent,user'], // Ensure role is valid
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign role to the user
        $user->assignRole($request->role);

        return redirect('/login')->with('status', 'Registration successful! Please log in.');
    }
}
