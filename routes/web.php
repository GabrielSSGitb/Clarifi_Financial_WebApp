<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExportCSVController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\IncomesController;
use App\Http\Controllers\InvestmentsController;
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

    Route::get('history', [HistoryController::class, 'index'])->name('history');

    Route::post('history/csv', [ExportCSVController::class, 'exportDataWithCSV'])->name('exportCSV');

    Route::get('expenses', [ExpenseController::class, 'show']);

    Route::post('expenses/send', [ExpenseController::class, 'store']);

    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');

    Route::get('investments', [InvestmentsController::class, 'index'])->name('investments.index');

    Route::get('profile', function () {
        return view('webSite.partials.profile', ['user' => Auth::user(), 'role' => role::query()->where('id', Auth::id())->first()]);
    })->name('profile');

    Route::post('profile', [UserController::class, 'update'])->name('profile.update');
});
