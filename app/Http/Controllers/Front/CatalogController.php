<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\AskQuestion;
use App\Models\Additional\Page;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class CatalogController extends Controller
{
	private $page;

	/**
	 * CatalogController constructor.
	 */
	public function __construct()
	{
		$this->page = Page::whereSlug('catalog')->first();
	}

	/**
	 * @param Request $request
	 * @return View
	 */
	public function index(Request $request): View
	{
		$products = $this->handleSearch($request);
		$products = $this->handleFilters($request, $products);

		return \view('app.catalog.index', [
			'page' => $this->page,
			'search' => $request->input('search'),
			'categories' => Category::get(),
			'products' => $products->paginate(24),
		]);
	}

	/**
	 * @param Request $request
	 * @return View
	 */
	public function all(Request $request): View
	{
		$products = $this->handleSearch($request);
		$products = $this->handleFilters($request, $products);

		return \view('app.catalog.all', [
			'page' => $this->page,
			'search' => $request->input('search'),
			'categories' => Category::get(),
			'products' => $products->get(),
		]);
	}

	/**
	 * @param Product $product
	 * @return View
	 */
	public function show(Product $product): View
	{
		$product->handleViewed();
		$processing = false;

		if (Auth::check()) {
			$processing = $product->orders()
								  ->where('user_id', Auth::user()->id)
								  ->where('status', '!=', 'declined')
								  ->count();
		}

		return \view('app.catalog.show', [
			'page' => $this->page,
			'product' => $product,
			'popular' => Product::orderByDesc('views_count')->take(4)->get(),
			'processing' => (bool)$processing,
		]);
	}

	/**
	 * @param Product $product
	 * @return JsonResponse
	 */
	public function toggleFavorites(Product $product): JsonResponse
	{
		$message = 'added';

		if ($product->in_favorites) {
			$product->favorites()->delete();
			$message = 'removed';
		} else {
			$product->favorites()->create([
				'user_id' => Auth::user()->id,
			]);
		}

		return \response()->json([
			'status' => $message,
		]);
	}

	/**
	 * @param Request $request
	 * @param Product $product
	 * @return RedirectResponse
	 */
	public function question(Request $request, Product $product): RedirectResponse
	{
		$data = [
			'user' => Auth::check() ? Auth::user() : (object)$request->only('name', 'contact'),
			'message' => $request->input('message'),
		];
		Mail::send(new AskQuestion($data, $product));

		session()->put('product', $product);
		session()->put('message', 'pages.thanks.question');

		return redirect()->route('app.thanks');
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
			}
		}
		return $products;
	}
}
