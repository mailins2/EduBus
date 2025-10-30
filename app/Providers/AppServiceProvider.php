<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

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
        if (config('app.env') === 'production' && Request::server('HTTP_X_FORWARDED_PROTO') === 'http') {
            URL::forceScheme('https');
        }

    });
    }
}
