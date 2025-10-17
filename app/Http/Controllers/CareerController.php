<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{

    public function index()
    {
        $Careers = Career::where('is_published', true)
            ->orderByDesc('created_at')
            ->paginate(8);

        return view('career/index', compact('Careers'));
    }


    public function show($slug)
    {
        $career = Career::where('slug', $slug)
            ->firstOrFail();

        return view('career/show', compact('career'));
    }
}
