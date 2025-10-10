<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TreatmentController;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/allon4implant', [HomeController::class, 'allon4implant'])->name('allon4implant');

// TREATMENTS
Route::prefix('treatments')->group(function () {
    Route::get('/', [TreatmentController::class, 'index'])->name('treatments.index');
    Route::get('/{category}', [TreatmentController::class, 'treatments'])->name('treatments.treatments');
    Route::get('/{category}/{slug}', [TreatmentController::class, 'show'])->name('treatments.show');
});

// PRICING
Route::prefix('pricing')->group(function () {
    Route::get('/', [HomeController::class, 'pricing'])->name(name: 'pricing.index');
    Route::get('/pricelist', [HomeController::class, 'pricelist'])->name(name: 'pricing.pricelist');
    Route::get('/payments', [HomeController::class, 'payments'])->name(name: 'pricing.payments');
});

// BLOG
Route::prefix('blog')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/{category}', [BlogController::class, 'category'])->name('blog.category');
    Route::get('/{category}/{slug}', [BlogController::class, 'show'])->name('blog.show');
});
