<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (
            $credentials['username'] === 'admindaharane' &&
            $credentials['password'] === 'daharaneadmin'
        ) {
            Session::put('admin_logged_in', true); // <-- key ini harus sama dengan yang dicek middleware
            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'login' => 'Username atau password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Session::forget('admin_logged_in');
        return redirect()->route('admin.login')->with('success', 'Logout berhasil!');
    }

}

