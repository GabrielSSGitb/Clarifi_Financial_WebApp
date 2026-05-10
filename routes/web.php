<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('webSite.home');
    });

    Route::get('/profile', function () {
        return view('webSite.partials.profile');
    });
});

Route::get('/history', function () {
    return view('webSite.partials.history');
});
Route::get('/addIncomes', function () {
    return view('webSite.partials.incomes');
});
Route::post('/dashboard/incomes/send', [IncomesController::class, 'store']);

Route::get('/addExpenses', function () {
    return view('webSite.partials.expense');
});

Route::post('/dashboard/expenses/send', [ExpenseController::class, 'store']);

Route::get('/investments', function () {
    return view('webSite.partials.investments');
});
