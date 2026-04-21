<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clarifi/dashboard', function () {
    return view('webSite.home');
});
Route::get('/clarifi/history', function () {
    return view('webSite.partials.history');
});
Route::get('/clarifi/addIncomes', function () {
    return view('webSite.partials.incomes');
});
Route::get('/clarifi/addExpenses', function () {
    return view('webSite.partials.expense');
});
Route::get('/clarifi/investments', function () {
    return view('webSite.partials.investments');
});
