<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $articles = Articles::where('is_published', true)
            ->orderByDesc('publish_date') // atau 'created_at', tergantung struktur tabelmu
            ->take(3)
            ->get();
        return view('home', compact('articles'));
    }
}
