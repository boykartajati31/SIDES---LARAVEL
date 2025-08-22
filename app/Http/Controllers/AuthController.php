<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    //

    public function login()
    {
        if (Auth::check()) {
            return redirect()->intended('dashboard');
        }
        return view('pages.auth.login');
    }

    public function authenticate(Request $request)
    {
        if (Auth::check()) {
            return redirect()->intended('dashboard');
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->status == 'submitted') {
                return back()->with('error', 'Your account is not approved yet. Please contact the administrator.');
            }else if (Auth::user()->status == 'rejected') {
                return back()->with('error', 'Your account has been rejected. Please contact the administrator.');
            }

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/')->with('error', 'You are not logged in.');
        }

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function registerView()
    {
        if (Auth::check()) {
            return redirect()->intended('dashboard');
        }

        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        if (Auth::check()) {
            return redirect()->intended('dashboard');
        }

        $validated = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role_id = 2; // Assuming 2 is the role ID for residents
        $user->saveOrFail();

        return redirect('/')->with('success', 'Registration successful. Please wait for approval.');
    }
}
