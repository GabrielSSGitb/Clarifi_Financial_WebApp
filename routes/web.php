<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', function () {
    return view('webSite.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/forgot-password', function () {
    return view('webSite.auth.forgot-password');
});


Route::prefix('dashboard')->group(function () {

    Route::get('incomes', [IncomesController::class, 'show']);

    Route::post('incomes/send', [IncomesController::class, 'store']);

    Route::get('history', function () {
        return view('webSite.partials.history');
    });

    Route::get('expenses', function () {
        return view('webSite.partials.expense');
    });

    Route::post('expenses/send', [ExpenseController::class, 'store']);

    Route::get('investments', function () {
        return view('webSite.partials.investments');
    });

    Route::get('profile', function () {
        return view('webSite.partials.profile');
    });
});
