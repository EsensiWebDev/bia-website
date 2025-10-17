<?php

namespace App\Http\Controllers;

use App\Models\SocialActivity;
use Illuminate\Http\Request;

class SocialActivityController extends Controller
{

    public function index()
    {
        $socialActivity = SocialActivity::select('id', 'title', 'slug', 'thumbnail', 'thumbnail_alt_text', 'excerpt')
            ->where('is_published', true)
            ->orderByDesc('created_at')
            ->paginate(6);

        return view('social_activity/index', compact('socialActivity'));
    }


    public function show($slug)
    {
        $socialAct = SocialActivity::where('slug', $slug)
            ->firstOrFail();

        return view('social_activity/show', compact('socialAct'));
    }
}
