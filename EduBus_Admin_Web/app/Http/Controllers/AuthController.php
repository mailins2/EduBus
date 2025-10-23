<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function logout(Request $request)
    {
        session()->forget('access_token');
        return redirect()->route('login.form')->with('success', 'Đăng xuất thành công!');
    }
}
