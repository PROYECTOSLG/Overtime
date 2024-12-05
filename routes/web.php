<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('auth.login');
});

Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change.password');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard.show')->middleware('auth');
Route::post('/employee/update', [DashboardController::class, 'update'])->name('employees.update');
Route::post('/employee/register', [DashboardController::class, 'register'])->name('employees.register');
Route::post('/employees/{id}/delete', [DashboardController::class, 'destroy'])->name('employees.destroy');



