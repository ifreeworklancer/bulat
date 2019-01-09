<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSavingRequest;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductsController extends Controller
{
	/**
	 * @return View
	 */
	public function index(): View
	{
		return \view('admin.products.index', [
			'products' => Product::latest('id')->with('categories')->paginate(20),
			'categories' => Category::latest('id')->get(),
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
