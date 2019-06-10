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

        return \view('app.pages.home', compact('articles', 'slides', 'categories'));
    }

    public function about(): View
    {
        $page = Page::whereSlug('about')->first();
        return \view('app.pages.default', compact('page'));
    }

    public function contacts(): View
    {
        $page = Page::whereSlug('contacts')->first();
        return \view('app.pages.contacts', compact('page'));
    }

    public function termsAndConditions(): View
    {
        $page = Page::whereSlug('terms-and-conditions')->first();
        return \view('app.pages.default', compact('page'));
    }

    public function warranty(): View
    {
        $page = Page::whereSlug('warranty')->first();
        return view('app.pages.default', compact('page'));
    }
}
