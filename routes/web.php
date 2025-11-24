<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomepageController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/register', [LoginController::class, 'signup'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.submit');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::resource('/dashboard/members', MemberController::class);
Route::resource('/dashboard/memberships', MembershipController::class);
Route::resource('/dashboard/banks', BankController::class);
Route::resource('/dashboard/payments', PaymentController::class);
Route::resource('/dashboard/users', UserController::class);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
