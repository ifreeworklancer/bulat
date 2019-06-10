<?php

namespace App\Http\Controllers\Admin;

use App\Models\Additional\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function index()
    {
        $pages = Page::whereNotIn('slug', ['articles', 'catalog'])->get();

        return view('admin.pages.index', compact('pages'));
    }
}
