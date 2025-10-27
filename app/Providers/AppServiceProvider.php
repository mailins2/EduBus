<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Http;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
        if (session()->has('access_token')) {
            $token = session('access_token');

            // Gọi API lấy thông tin user
            $response = Http::withToken($token)->get('https://qlbus.onrender.com/api/users/me');

            if ($response->ok()) {
                $admin = $response->json();
                $view->with('admin', $admin);
            }
        }
    });
    }
}
