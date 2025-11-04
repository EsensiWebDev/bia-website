<?php

namespace App\Providers;

use App\Models\CategoryTreatment;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share data kategori ke semua view
        $categories = CategoryTreatment::select('id', 'title', 'slug')
            ->orderByDesc('created_at')
            ->get();

        View::share('categories_treatment', $categories);
    }
}
