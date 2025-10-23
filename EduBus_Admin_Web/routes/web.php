<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Services\ApiService;
use App\Http\Middleware\AuthSessionMiddleware;

// ================== LOGIN =====================
Route::view('/login', 'login')->name('login.form');

Route::post('/login', function (Request $request, ApiService $api) {
    $result = $api->login($request->email, $request->password);

    if (isset($result['accessToken'])) {
        session(['access_token' => $result['accessToken']]);
        return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
    }

    return back()->withErrors(['login' => 'Sai email hoặc mật khẩu']);
})->name('login.submit');

// ================== PROTECTED ROUTES =====================
Route::middleware([AuthSessionMiddleware::class])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/student-list', [StudentController::class, 'index'])->name('students.student-list');
    Route::get('/driver-list', [DriverController::class, 'index'])->name('drivers.driver-list');
    Route::get('/bus-list', [BusController::class, 'index'])->name('busline.bus-list');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
