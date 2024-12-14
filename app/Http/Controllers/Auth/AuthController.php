<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('home');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email', // Используйте 'username' если логин по имени
            'password' => 'required',
        ]);

        // Аутентификация
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended('home'); // Перенаправление после входа
        }

        return back()->withErrors([
            'email' => 'Неверный логин или пароль.',
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
