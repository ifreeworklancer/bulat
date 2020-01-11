<?php

namespace App\Http\Controllers\Front;

use App\Models\Additional\Page;
use App\Models\Article\Article;
use App\Models\Catalog\Category;
use App\Models\Slider\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PagesController extends Controller
{
    public function index(): View
    {
        $articles = Article::latest()->take(3)->get();
        $slides = optional(Slider::find(1))->slides;
        $categories = Category::has('products')->inRandomOrder()->get();
        $meta = Page::where('slug', 'about')->first();
        return \view('app.pages.home', compact('articles', 'slides', 'categories', 'meta'));
    }

    public function show(Page $page): View
    {
        return \view('app.pages.default', compact('page'));
    }
}
