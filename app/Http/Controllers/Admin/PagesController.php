<?php

namespace App\Http\Controllers\Admin;

use App\Models\Additional\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $pages = Page::whereNotIn('slug', ['articles', 'catalog'])->get();

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * @param  Page  $page
     * @return View
     */
    public function edit(Page $page): View
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * @param  Request  $request
     * @param  Page  $page
     * @return RedirectResponse
     */
    public function update(Request $request, Page $page): RedirectResponse
    {
        $page->updateTranslation();

        if($request->has('meta')){
            foreach ($request->get('meta') as $key => $meta) {
                $page->meta()->updateOrCreate([
                    'metable_id' => $page->id
                ], [
                    $key => $meta
                ]);
            }
        }
        return back();
    }
}
