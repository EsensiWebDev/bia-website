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
        $categories = CategoryTreatment::with(['treatments' => function ($query) {
            $query->select('id', 'category_treatment_id', 'title', 'slug');
        }])
            ->select('id', 'title', 'slug')
            ->orderBy('created_at')
            ->get();

        View::share('categories_treatment', $categories);
    }
}
