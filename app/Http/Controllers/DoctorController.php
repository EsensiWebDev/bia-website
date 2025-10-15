<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $alldoctors = Doctor::select('id', 'name', 'slug', 'thumbnail_profile', 'thumbnail_alt_text', 'avatar', 'position')
            ->orderByDesc('created_at')
            ->paginate(8);

        return view('doctor/index', compact('alldoctors'));
    }


    public function show($slug)
    {
        $doctor = Doctor::with('educations', 'certifications', 'associations')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('doctor/show', compact('doctor'));
    }
}
