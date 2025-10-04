<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/treatments', function () {
    return view('treatments.index');
})->name('treatments.index');


Route::get('/treatments/implant', function () {
    return view('treatments.category');
})->name('treatments.category');


Route::prefix('blog')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/{category}', [BlogController::class, 'category'])->name('blog.category');
    Route::get('/{category}/{slug}', [BlogController::class, 'show'])->name('blog.show');
});
