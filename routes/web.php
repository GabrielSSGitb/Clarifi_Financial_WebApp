<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('webSite.home');
});
Route::get('/clarifi/history', function () {
    return view('webSite.partials.history');
});
