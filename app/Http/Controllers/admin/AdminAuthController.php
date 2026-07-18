<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    public function login(Request $req)
    {
        $validateReq = $req->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt($validateReq)) {
            $user = Auth::user();
            if ($user->role !== 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Unauthorized'
                ]);
            }
            $req->session()->regenerate();
            return redirect('/admin/dashboard');
        }
    }

    public function logout(Request $request)
    {

        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/admin/login');
        }
    }

    

}
