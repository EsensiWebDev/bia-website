<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/treatments', function () {
    return view('treatments.index');
})->name('treatments.index');