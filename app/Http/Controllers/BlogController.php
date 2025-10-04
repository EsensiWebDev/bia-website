<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articles;
use App\Models\CategoryArticle;

class BlogController extends Controller
{
    // Semua articles yang publish
    public function index()
    {
        $articles = Articles::with('category')
            ->where('is_published', true)
            ->orderBy('publish_date', 'desc')
            ->paginate(6); // pagination 6 per page

        return view('blog.index', compact('articles'));
    }


    // Semua articles by category slug
    public function category($categorySlug)
    {
        $category = CategoryArticle::where('slug', $categorySlug)->firstOrFail();

        $articles = Articles::with('category')
            ->where('is_published', true)
            ->where('category_article_id', $category->id)
            ->orderBy('publish_date', 'desc')
            ->paginate(6);

        return view('blog.category', compact('category', 'articles'));
    }


    // Single article
    public function show($categorySlug, $slug)
    {
        $category = CategoryArticle::where('slug', $categorySlug)->firstOrFail();

        $article = Articles::where('slug', $slug)
            ->where('category_article_id', $category->id)
            ->where('is_published', true)
            ->firstOrFail();

        $relateds = Articles::where('category_article_id', $article->category_article_id)
            ->where('is_published', true)
            ->where('id', '!=', $article->id)
            ->orderByDesc('publish_date') // atau 'created_at', tergantung struktur tabelmu
            ->take(3)
            ->get();

        return view('blog.show', compact('category', 'article', 'relateds'));
    }
}
