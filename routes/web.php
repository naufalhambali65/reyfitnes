<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\ClassBookingController;
use App\Http\Controllers\ClassCategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GymClassController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductUnitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\StockLogController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomepageController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/register', [LoginController::class, 'signup'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.submit');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::resource('/dashboard/members', MemberController::class);

Route::put('/members/{member}/toggle-status',[MemberController::class, 'toggleStatus'])->name('members.toggleStatus');
Route::put('/dashboard/members/payments/{user}', [MemberController::class, 'payment'])->name('members.payment');
Route::post('/dashboard/members/addPayments/{member}', [MemberController::class, 'addPayment'])->name('members.addPayment');
Route::PUT('/dashboard/payments/updatePaymentProof/{payment}', [PaymentController::class, 'updatePaymentProof'])->name('payments.updatePaymentProof');
Route::resource('/dashboard/payments', PaymentController::class);

Route::resource('/dashboard/memberships', MembershipController::class);
Route::resource('/dashboard/banks', BankController::class);
Route::resource('/dashboard/users', UserController::class);

Route::get('/dashboard/attendances/all-attendances', [AttendanceController::class, 'all'])->name('attendances.all');
Route::post('/dashboard//attendance/scan-qr', [AttendanceController::class, 'scanQr'])->name('attendances.scan');
Route::resource('/dashboard/attendances', AttendanceController::class);

Route::put('/dashboard/notifications/markAsRead/{notification}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::resource('/dashboard/notifications', NotificationController::class);

Route::resource('/dashboard/classes', GymClassController::class);
Route::resource('/dashboard/class-categories', ClassCategoryController::class);
Route::resource('/dashboard/class-bookings', ClassBookingController::class);

Route::put('/trainers/{trainer}/toggle-status',[TrainerController::class, 'toggleStatus'])->name('trainers.toggleStatus');
Route::resource('/dashboard/trainers', TrainerController::class);

Route::resource('/dashboard/product-stocks', ProductController::class);
Route::resource('/dashboard/product-categories', ProductCategoryController::class);
Route::resource('/dashboard/product-units', ProductUnitController::class);
Route::get('/dashboard/product-catalogues', [ProductCatalogController::class, 'index'])->name('product-catalogues.index');

Route::get('/dashboard/reports', [ReportController::class, 'index'])->name('reports.index');

Route::put('/dashboard/admins/{user}', [AdminController::class, 'toggleRole'])->name('admins.toggleRole');
Route::resource('/dashboard/admins', AdminController::class);

Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/dashboard/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/dashboard/profile/change-password', [ProfileController::class, 'changePass'])->name('profile.change-password');
Route::put('/dashboard/profile/{user}', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/forgot-password', [ForgotPasswordController::class, 'show'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'send'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'show'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');