<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSavingRequest;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductsController extends Controller
{
	/**
	 * @param Request $request
	 * @return View
	 */
	public function index(Request $request): View
	{
		$tags = collect([]);
		$products = Product::latest('id')->with(['categories', 'translates']);

		if ($request->filled('category')) {
			$ids = explode(',', $request->input('category'));
			$tags = Category::whereIn('slug', $ids)->get();
			$products = $products->whereHas('categories', function ($q) use ($ids) {
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
			'categories' => Category::latest('id')->get(),
			'tags' => $tags
		]);
	}

	/**
	 * @return View
	 */
	public function create(): View
	{
		return \view('admin.products.create', [
			'categories' => Category::latest('id')->get(),
		]);
	}

	/**
	 * @param ProductSavingRequest $request
	 * @return RedirectResponse
	 * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
	 * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\InvalidBase64Data
	 */
	public function store(ProductSavingRequest $request): RedirectResponse
	{
		/** @var Product $product */
		$product = Product::create([
			'price' => $request->input('price'),
			'is_published' => $request->has('is_published'),
		]);
		$product->makeTranslation();
		$product->categories()->attach($request->input('categories', []));

		if ($request->has('files')) {
			foreach ($request->input('files') as $file) {
				$product->addMediaFromBase64($file)->toMediaCollection('products');
			}
		}

		return redirect()->route('admin.products.edit', $product);
	}

	/**
	 * @param Product $product
	 * @return View
	 */
	public function edit(Product $product): View
	{
		return \view('admin.products.edit', [
			'product' => $product,
			'categories' => Category::latest('id')->get(),
		]);
	}

	/**
	 * @param ProductSavingRequest $request
	 * @param Product $product
	 * @return RedirectResponse
	 * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
	 * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\InvalidBase64Data
	 */
	public function update(ProductSavingRequest $request, Product $product): RedirectResponse
	{
		$product->updateTranslation();
		$product->categories()->sync($request->input('categories'));
		$product->update([
			'price' => $request->input('price'),
			'is_published' => $request->has('is_published'),
		]);

		if ($request->has('files')) {
			foreach ($request->input('files') as $file) {
				$product->addMediaFromBase64($file)->toMediaCollection('products');
			}
		}

		return redirect()->route('admin.products.edit', $product);
	}

	/**
	 * @param Product $product
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Product $product): RedirectResponse
	{
		$product->delete();
		return \redirect()->route('admin.products.index');
	}
}
