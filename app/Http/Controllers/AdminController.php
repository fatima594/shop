<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRegisterRequest;
use App\Http\Requests\AdminLoginRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    // عرض نموذج التسجيل
    public function showRegistrationForm()
    {
        return view('admin.dashboard.register');
    }

    // تسجيل مشرف جديد
    public function adminregister(AdminRegisterRequest $request)
    {
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('admin')->login($admin);

        return redirect()->route('admin.login')->with('status', 'Registration successful. Please log in.');
    }

    // عرض نموذج تسجيل الدخول
    public function showLoginForm()
    {
        return view('admin.dashboard.login');
    }

    // تسجيل الدخول
    public function adminlogin(AdminLoginRequest $request)
    {
        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            return redirect()->route('admin.index');
        }

        throw ValidationException::withMessages([
            'email' => [__('auth.failed')],
        ]);
    }

    // تسجيل الخروج
    public function logout()
    {
        Auth::guard('admin')->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    // عرض لوحة التحكم
    public function dashboard()
    {
        return view('admin.dashboard.master');
    }
}
