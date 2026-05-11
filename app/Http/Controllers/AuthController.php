<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthController extends Controller
{
    public function ShowRegister(Request $request)
    {
        return view('Auth.register');
    }
    public function Showlogin(Request $request)
    {
        return view('Auth.login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:9',

        ]);
        $user = User::create($validated);
        Auth::login($user);
        return redirect()->route('show.login')->with('success', 'Compte créé avec succès.');

    }

    public function login(Request $request)
    {
    
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if (Auth::attempt($validated)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }
        throw ValidationException::withMessages([
            'errors' => 'informations incorectttttttttt'
        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }


}

