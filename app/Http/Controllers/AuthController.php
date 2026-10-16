<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => 'Email or password is incorrect.']);
        }

        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->is_admin) {
            return redirect()->intended(route('admin.dashboard'))->with('success', "Welcome back, {$user->name}!");
        }

        return redirect()->intended(route('home'))->with('success', "Welcome back, {$user->name}!");
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email',
            'phone' => 'nullable|string|max:30',
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        // keep the guest cart after logging in
        $cart = session('cart', []);

        $user = User::create($data);
        Auth::login($user);
        $request->session()->regenerate();
        session(['cart' => $cart]);

        return redirect()->route('home')->with('success', "Account created! Welcome to Zaiqa, {$user->name}.");
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out.');
    }
}
