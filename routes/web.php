<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\IncomesController;
use App\Http\Controllers\UserController;
use App\Models\role;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard')->middleware(['auth', 'verified']);


Route::prefix('dashboard')->group(function () {

    Route::get('incomes', [IncomesController::class, 'show']);

    Route::post('incomes/send', [IncomesController::class, 'store']);

    Route::get('history', [HistoryController::class, 'index']);

    Route::get('expenses', [ExpenseController::class, 'show']);

    Route::post('expenses/send', [ExpenseController::class, 'store']);

    Route::get('investments', function () {
        return view('webSite.partials.investments');
    });

    Route::get('profile', function () {
        return view('webSite.partials.profile', ['user' => Auth::user(), 'role' => role::query()->where('id', Auth::id())->first()]);
    })->name('profile');

    Route::post('profile', [UserController::class, 'update'])->name('profile.update');
});
