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

    // ---------------- STUDENTS ----------------
    Route::controller(StudentController::class)
        ->prefix('/student-list')
        ->name('student-list.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/add-student', 'add')->name('add-student');
            Route::post('/store', 'store')->name('store'); 
            Route::get('/detail/{id}','detail')->name('detail');
            Route::get('/adjust/{id}','adjust')->name('adjust');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'destroy')->name('delete');
        });

    // ---------------- DRIVERRS ----------------
    Route::controller(DriverController::class)
        ->prefix('/driver-list')
        ->name('driver-list.')
        ->group(function () {
            Route::get('/', 'index')->name('');
            Route::get('/add-driver', 'add')->name('add-driver');
            Route::post('/store', 'store')->name('store'); 
            Route::get('/detail/{id}','detail')->name('detail');
            Route::get('/adjust/{id}','adjust')->name('adjust');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/delete/{id}', 'destroy')->name('delete');
        });
        // ---------------- BUS ----------------
    Route::controller(BusController::class)
        ->prefix('/bus-list')
        ->name('bus-list.')
        ->group(function () {
            Route::get('/', 'index')->name('');
            Route::get('/add-bus', 'add')->name('add-bus');
            Route::post('/store', 'store')->name('store');
            Route::get('/detail/{id}','detail')->name('detail');
            Route::post('/{xeId}/add-students', 'addStudents')->name('addStudents');
            Route::delete('/{xeId}/remove-student/{studentId}','removeStudent')->name('bus-list.remove-student');
            Route::delete('/delete/{id}', 'delete')->name('delete');
            Route::get('/adjust/{id}','adjust')->name('adjust');
            Route::put('/update/{id}', 'update')->name('update');
        });
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
