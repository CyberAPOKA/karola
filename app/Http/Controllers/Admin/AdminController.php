<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login()
    {
        return Inertia::render('Admin/Login');
    }

    public function auth(Request $request)
    {
        if (auth('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {

            return redirect()->route('admin.index');
        } else {
            return redirect()->back()->with('danger', 'E-mail ou senha inválida.');
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');
    }
}