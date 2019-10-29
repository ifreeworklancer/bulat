<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Category;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return \view('admin.categories.index', [
            'categories' => Category::paginate(10),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return \view('admin.categories.create');
    }

    /**
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        /** @var Category $category */
        $category = Category::create()->makeTranslation();

        if ($request->hasFile('image')) {
            $category->addMediaFromRequest('image')
                ->usingFileName(create_file_name($request->file('image')))
                ->toMediaCollection('category');
        }

        return redirect()->route('admin.categories.edit', $category);
    }

    /**
     * @param  Category  $category
     * @return View
     */
    public function edit(Category $category): View
    {
        return \view('admin.categories.edit', compact('category'));
    }

    /**
     * @param  Request  $request
     * @param  Category  $category
     * @return RedirectResponse
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        if ($request->has('regenerate')) {
            $category->slug = null;
            $category->update();
        }

        $category->updateTranslation();

        if ($request->hasFile('image')) {
            $category->clearMediaCollection('category');
            $category->addMediaFromRequest('image')
                ->usingFileName(create_file_name($request->file('image')))
                ->toMediaCollection('category');
        }

        return redirect()->route('admin.categories.edit', $category);
    }

    /**
     * @param  Category  $category
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
        return redirect()->route('admin.categories.index');
    }

    public function sortOrder(Category $category, $direction)
    {
//        dd($product, $direction);

        switch ($direction) {
            case 'up':
                $category->moveOrderUp();
                break;
            case 'down':
                $category->moveOrderDown();
                break;
            case 'start':
                $category->moveToStart();
                break;
            case 'end':
                $category->moveToEnd();
                break;
        }

        $category->save();

        return back();
    }
}
