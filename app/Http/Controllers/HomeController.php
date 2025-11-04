<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Articles;
use Illuminate\Http\Request;
use App\Models\CategoryTreatment;
use App\Models\Treatment;

class HomeController extends Controller
{
    public function home()
    {
        $articles = Articles::where('is_published', true)
            ->orderByDesc('publish_date') // atau 'created_at', tergantung struktur tabelmu
            ->take(3)
            ->get();

        $cattreatments = CategoryTreatment::select('id', 'title', 'slug', 'thumbnail')
            ->orderByDesc('created_at')
            ->get();

        return view('home', compact('articles', 'cattreatments'));
    }

    //PRICING ROUTE
    public function pricing()
    {
        return view('pricing/index');
    }
    public function pricelist()
    {
        return view('pricing/pricelist');
    }
    public function payments()
    {
        return view('pricing/payment');
    }


    public function about()
    {
        $doctors = Doctor::select('name', 'slug', 'position', 'short_desc', 'thumbnail_profile', 'avatar')->get();
        return view('about', compact('doctors'));
    }

    public function allon4implant()
    {

        $category = Treatment::where('slug', 'full-mouth-dental-implant')->first();

        // Check if the page content is empty
        if (!$category || empty($category->content)) {
            // Redirect to the 'allon4implant' route if the page content is empty
            return redirect()->route('allon4implant');
        }

        // Return the view with page content if it's not empty
        return view('treatments.dental-implant.full-mouth', compact('page'));
        // return view('allon4implant');
    }

    public function faq()
    {
        return view('faq');
    }

    public function facilities()
    {
        return view('facilities');
    }
}
