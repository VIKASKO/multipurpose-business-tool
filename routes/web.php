<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

Route::resource('businesses', BusinessController::class)->except('show');
Route::resource('accounts', AccountController::class)->except('show');
Route::resource('customers', CustomerController::class)->except('show');
Route::resource('orders', OrderController::class)->except('show');
Route::resource('projects', ProjectController::class)->except('show');
Route::resource('tasks', TaskController::class)->except('show');

Route::resource('incomes', IncomeController::class)->except('show');
Route::resource('expenses', ExpenseController::class)->except('show');
