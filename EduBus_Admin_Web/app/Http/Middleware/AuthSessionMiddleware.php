<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthSessionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Nếu chưa đăng nhập mà không phải đang ở trang login
        if (!session()->has('access_token') && !$request->is('login') && !$request->is('login/*')) {
            return redirect()->route('login.form');
        }

        // Nếu đã đăng nhập mà đang cố vào trang login -> chuyển về trang chủ
        if (session()->has('access_token') && ($request->is('login') || $request->is('login/*'))) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
