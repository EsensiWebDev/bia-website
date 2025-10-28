<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AchievementsController;
use App\Http\Controllers\SocialActivityController;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/allon4implant', [HomeController::class, 'allon4implant'])->name('allon4implant');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/facilities', [HomeController::class, 'facilities'])->name('facilities');


// TREATMENTS
Route::prefix('treatments')->group(function () {
    Route::get('/', [TreatmentController::class, 'index'])->name('treatments.index');
    Route::get('/{category}', [TreatmentController::class, 'treatments'])->name('treatments.treatments');
    Route::get('/{category}/{slug}', [TreatmentController::class, 'show'])->name('treatments.show');
});

// TREATMENTS
Route::prefix('team')->group(function () {
    Route::get('/', [DoctorController::class, 'index'])->name('doctor.index');
    Route::get('/{slug}', [DoctorController::class, 'show'])->name('doctor.show');
});

// PRICING
Route::prefix('pricing')->group(function () {
    Route::get('/', [HomeController::class, 'pricing'])->name(name: 'pricing.index');
    Route::get('/pricelist', [HomeController::class, 'pricelist'])->name(name: 'pricing.pricelist');
    Route::get('/payments', [HomeController::class, 'payments'])->name(name: 'pricing.payments');
});

// BLOG
Route::prefix('article')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('article.index');
    Route::get('/{category}', [BlogController::class, 'category'])->name('article.category');
    Route::get('/{category}/{slug}', [BlogController::class, 'show'])->name('article.show');
});

// DOCTOR
Route::prefix('doctors')->group(function () {
    Route::get('/', [DoctorController::class, 'index'])->name('doctors.index');
    Route::get('/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');
});

// SOCIAL ACTIVITY
Route::prefix('social-activity')->group(function () {
    Route::get('/', [SocialActivityController::class, 'index'])->name('social.index');
    Route::get('/{doctor}', [SocialActivityController::class, 'show'])->name('social.show');
});

// CAREER
Route::prefix('career')->group(function () {
    Route::get('/', [CareerController::class, 'index'])->name('career.index');
    Route::get('/{show}', [CareerController::class, 'show'])->name('career.show');
});

// Achievements
Route::prefix('achievements')->group(function () {
    Route::get('/', [AchievementsController::class, 'index'])->name('achievements.index');
    Route::get('/{show}', [AchievementsController::class, 'show'])->name('achievements.show');
});

// Book Now
Route::get('/book', [ReservationController::class, 'create'])->name('booknow');
Route::post('/book', [ReservationController::class, 'store'])->name('booknow.store');
