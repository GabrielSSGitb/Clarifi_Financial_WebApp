<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExportCSVController;
use App\Http\Controllers\ExportExcelFileController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\IncomesController;
use App\Http\Controllers\InvestmentsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\role;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard')->middleware(['auth', 'verified']);


Route::prefix('dashboard')->group(function () {

    Route::get('incomes', [IncomesController::class, 'show'])->name('dashboard.incomes');

    Route::post('incomes/send', [IncomesController::class, 'store'])->name('dashboard.incomes.send');

    Route::get('history', [HistoryController::class, 'index'])->name('dashboard.history');

    Route::post('history/csv', [ExportCSVController::class, 'exportDataWithCSV'])->name('exportCSV');

    Route::post('history/xlsx', [ExportExcelFileController::class, 'export'])->name('exportExcel');

    Route::get('expenses', [ExpenseController::class, 'show'])->name('dashboard.expenses');

    Route::post('expenses/send', [ExpenseController::class, 'store'])->name('dashboard.expenses.send');

    Route::get('calendar', [CalendarController::class, 'index'])->name('dashboard.calendar');

    Route::post('/dashboard/calendar/save', [CalendarController::class, 'store'])->name('dashboard.calendar.save');

    Route::get('investments', [InvestmentsController::class, 'index'])->name('dashboard.investments');

    Route::get('profile', function () {
        return view('webSite.partials.profile', ['user' => Auth::user(), 'role' => role::query()->where('id', Auth::id())->first()]);
    })->name('profile');

    Route::post('profile', [UserController::class, 'update'])->name('profile.update');

    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
});
