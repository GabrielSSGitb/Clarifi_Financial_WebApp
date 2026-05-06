<?php

use App\Http\Controllers\IncomesController;
use App\Http\Controllers\userRegister;
use Illuminate\Support\Facades\Route;



Route::get('/login', function () {
    return view('webSite.layouts.login');
});

Route::get('/profile', function () {
    return view('webSite.partials.profile');
});

Route::get('/register', function () {
    return view('webSite.layouts.register');
});

Route::get('/dashboard', function () {
    return view('webSite.home');
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
Route::get('/investments', function () {
    return view('webSite.partials.investments');
});
