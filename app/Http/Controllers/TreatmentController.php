<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\Request;
use App\Models\CategoryTreatment;

class TreatmentController extends Controller
{
    public function index()
    {
        $cattreatments = CategoryTreatment::select('id', 'title', 'slug', 'thumbnail')
            ->orderByDesc('created_at')
            ->get();

        return view('treatments.index', compact('cattreatments'));
    }

    public function treatments($slug)
    {
        $category = CategoryTreatment::where('slug', $slug)
            ->select('id', 'title', 'slug', 'thumbnail', 'desc')
            ->firstOrFail();

        $treatments = Treatment::where('category_treatment_id', $category->id)
            ->select('id', 'title', 'slug', 'thumbnail', 'thumbnail_alt_text', 'desc')
            ->orderByDesc('created_at')
            ->with('whoNeeds')
            ->get();
        // KIRIM KEDUANYA
        return view('treatments.treatments', compact('category', 'treatments'));
    }

    public function show($categorySlug, $slug)
    {
        $category = CategoryTreatment::where('slug', $categorySlug)
            ->select('id', 'title', 'slug', 'desc')
            ->firstOrFail();

        $treatment = Treatment::with(['timeFrames.stageItems'])
            ->where('slug', $slug)
            ->where('category_treatment_id', $category->id)
            ->select('id', 'title', 'slug', 'thumbnail', 'thumbnail_alt_text', 'desc', 'maintenance', 'meta_title', 'meta_description', 'meta_keywords')
            ->firstOrFail();

        return view('treatments.show', compact('category', 'treatment'));
    }
}
