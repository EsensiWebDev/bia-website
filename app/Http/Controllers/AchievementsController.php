<?php

namespace App\Http\Controllers;

use App\Models\Achievements;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index()
    {
        $Achievements = Achievements::where('is_published', true)
            ->orderByDesc('created_at')
            ->paginate(6);

        return view('achievements/index', compact('Achievements'));
    }


    public function show($slug)
    {
        $achievement = Achievements::where('slug', $slug)
            ->firstOrFail();

        return view('achievements/show', compact('achievement'));
    }
}
