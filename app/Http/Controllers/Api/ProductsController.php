<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
	public function index(Request $request)
	{

		$products = $this->handleSearch($request);
		$products = $this->handleFilters($request, $products);

		return response()->json(
			new ProductCollection($products->paginate(6))
		);
	}

	/**
	 * @param Request $request
	 * @return Builder
	 */
	private function handleSearch(Request $request)
	{
		$search = null;
		$products = Product::query();

		if ($request->filled('search')) {
			$search = $request->input('search');
			$products = $products->whereHas('translates', function ($q) use ($search) {
				$q->where('lang', app()->getLocale())
				  ->where('title', 'like', '%' . $search . '%')
				  ->orWhere('description', 'like', '%' . $search . '%');
			});
		}
		return $products;
	}

	/**
	 * @param Request $request
	 * @param $products
	 * @return mixed
	 */
	private function handleFilters(Request $request, $products)
	{
		if ($request->filled('category')) {
			$ids = Category::whereIn('slug', explode(',', $request->input('category')))
						   ->pluck('id');

			$products = $products->whereHas('categories', function (Builder $builder) use ($ids) {
				$builder->whereIn('id', $ids);
			});
		}

		if ($request->filled('order')) {
			switch ($request->get('order')) {
				case 'cheap':
					$products = $products->orderBy('price');
					break;
				case 'expensive':
					$products = $products->orderByDesc('price');
					break;
				case 'most_viewed':
					$products = $products->orderByDesc('views_count');
					break;
				default:
					$products = $products->latest('id');
					break;
			}
		} else {
			$products = $products->latest('id');
		}
		return $products;
	}
}
