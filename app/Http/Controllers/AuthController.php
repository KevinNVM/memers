<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }

    public function auth(Request $request)
    {
        $validCreds = $request->validate([
            'username' => 'required|alpha_num',
            'password' => 'required|min:3'
        ]);

        // Step 1: Check if the user exists
        $user = User::where('username', $validCreds['username'])->first();

        if ($user) {
            // Step 2: Check the password and login the user
            if (Hash::check($validCreds['password'], $user->password)) {
                // Login the user
                Auth::login($user);
                return redirect()->intended('/');
            } else {
                // Incorrect password
                return redirect()->back()->withErrors(['password' => 'Incorrect password.']);
            }
        } else {
            // Create a new user
            $user = User::create([
                'username' => $validCreds['username'],
                'password' => bcrypt($validCreds['password'])
            ]);

            // Login the newly created user
            Auth::login($user);
            return redirect()->intended('/');
        }
    }

    function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
