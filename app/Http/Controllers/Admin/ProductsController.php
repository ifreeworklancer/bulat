<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSavingRequest;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use function redirect;
use Spatie\MediaLibrary\Models\Media;

class ProductsController extends Controller
{
    /**
     * @param  Request  $request
     * @return View
     */
    public function index(Request $request): View
    {
        $tags = collect([]);
        $products = Product::with(['categories', 'translates']);

        if ($request->filled('category')) {
            $ids = explode(',', $request->input('category'));
            $tags = Category::whereIn('slug', $ids)->get();
            $products = $products->whereHas('categories', function (Builder $q) use ($ids) {
                $q->whereIn('slug', $ids);
            });
        }

        if ($request->filled('q')) {
            $query = $request->input('q');
            $products = $products->whereHas('translates', function (Builder $builder) use ($query) {
                $builder->where('title', 'like', "%{$query}%");
            });
        }

        return \view('admin.products.index', [
            'products' => $products->paginate(20),
            'categories' => Category::get(),
            'tags' => $tags,
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return \view('admin.products.create', [
            'categories' => Category::get(),
        ]);
    }

    /**
     * @param  ProductSavingRequest  $request
     * @return RedirectResponse
     */
    public function store(ProductSavingRequest $request): RedirectResponse
    {
        /** @var Product $product */
        $product = Product::create([
            'price' => $request->input('price'),
            'is_published' => $request->has('is_published'),
            'in_stock' => $request->has('in_stock')
        ]);
        $product->makeTranslation();
        $product->categories()->attach($request->input('categories', []));

        if ($request->has('media')) {
            foreach ($request->media as $media) {
                Media::find($media)->update([
                    'model_type' => Product::class,
                    'model_id' => $product->id,
                ]);
            }
            Media::setNewOrder($request->input('media'));
        }

        return redirect()->route('admin.products.edit', $product);
    }

    /**
     * @param  Product  $product
     * @return View
     */
    public function edit(Product $product): View
    {
        return \view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::get(),
        ]);
    }

    /**
     * @param  ProductSavingRequest  $request
     * @param  Product  $product
     * @return RedirectResponse
     */
    public function update(ProductSavingRequest $request, Product $product): RedirectResponse
    {
        if ($request->has('regenerate')) {
            $product->slug = null;
        }

        $product->updateTranslation();
        $product->categories()->sync($request->input('categories'));
        $product->update([
            'price' => $request->input('price'),
            'is_published' => $request->has('is_published'),
            'in_stock' => $request->has('in_stock')
        ]);

        if ($request->has('media')) {
            foreach ($request->media as $media) {
                Media::find($media)->update([
                    'model_type' => Product::class,
                    'model_id' => $product->id,
                ]);
            }
            Media::setNewOrder($request->input('media'));
        }

        return redirect()->route('admin.products.edit', $product);
    }

    /**
     * @param  Product  $product
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('admin.products.index');
    }

    public function sortOrder(Product $product, $direction)
    {
        switch ($direction) {
            case 'up':
                $product->moveOrderUp();
                break;
            case 'down':
                $product->moveOrderDown();
                break;
            case 'start':
                $product->moveToStart();
                break;
            case 'end':
                $product->moveToEnd();
                break;
        }

        $product->save();

        return back();
    }
}
