<?php

use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\AdminLoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {

    Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
    Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');

    Route::middleware(['auth', 'role:2'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class,'index'])->name('admin.dashboard');
        Route::get('/logout', [AdminLoginController::class,'logout'])->name('admin.logout');
    });

    Route::middleware(['auth', 'role:1'])->group(function () {
        Route::get('/dashboard/user', function () {
            return "User Dashboard";
        })->name('user.dashboard');
    });
});
// });
// }'])
// Route::get('admin/login',[AdminLoginController::class,'index'])->name('admin.login');
