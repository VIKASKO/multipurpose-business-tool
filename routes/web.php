<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// ─── Guest Routes (unauthenticated only) ─────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('auth.login');
    Route::post('/login', [LoginController::class, 'login'])->name('auth.login.post');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('auth.register');
    Route::post('/register', [RegisterController::class, 'register'])->name('auth.register.post');
});

// ─── OTP Verification (no full auth required yet) ────────────────────────────
Route::get('/verify-email', [OtpController::class, 'showVerifyForm'])->name('auth.otp.show');
Route::post('/verify-email', [OtpController::class, 'verify'])->name('auth.otp.verify');
Route::post('/verify-email/resend', [OtpController::class, 'resend'])->name('auth.otp.resend');

// ─── Authenticated Routes ─────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [LogoutController::class, 'logout'])->name('auth.logout');

    // Root redirect
    Route::get('/', fn () => redirect()->route('dashboard'));

    // Dashboard & Reports
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // Core business modules
    Route::resource('businesses', BusinessController::class)->except('show');
    Route::resource('accounts', AccountController::class)->except('show');
    Route::resource('customers', CustomerController::class)->except('show');
    Route::resource('orders', OrderController::class)->except('show');
    Route::resource('projects', ProjectController::class)->except('show');
    Route::resource('tasks', TaskController::class)->except('show');
    Route::resource('incomes', IncomeController::class)->except('show');
    Route::resource('expenses', ExpenseController::class)->except('show');

    // CSV Exports (all users)
    Route::prefix('export')->name('export.')->group(function () {
        Route::get('/incomes',   [ExportController::class, 'incomes'])->name('incomes');
        Route::get('/expenses',  [ExportController::class, 'expenses'])->name('expenses');
        Route::get('/orders',    [ExportController::class, 'orders'])->name('orders');
        Route::get('/customers', [ExportController::class, 'customers'])->name('customers');
        Route::get('/projects',  [ExportController::class, 'projects'])->name('projects');
        Route::get('/tasks',     [ExportController::class, 'tasks'])->name('tasks');
    });

    // ─── Admin-Only Routes ────────────────────────────────────────────────────
    Route::middleware('admin')->prefix('admin')->name('auth.users.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('index');
        Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('toggle-active');
        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('update-role');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
});
