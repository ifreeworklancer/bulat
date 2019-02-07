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
		$products = Product::query();

		list($search, $products) = $this->handleSearch($request, $products);

		$products = $this->handleFilters($request, $products);

		return \view('app.catalog.index', [
			'products' => $products->paginate(6),
			'categories' => Category::latest('id')->get(),
			'page' => $this->page,
			'search' => $search,
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
			'popular' => Product::orderByDesc('views_count')->take(3)->get(),
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
	 * @param \Illuminate\Database\Eloquent\Builder $products
	 * @return array
	 */
	private function handleSearch(Request $request, \Illuminate\Database\Eloquent\Builder $products): array
	{
		$search = null;

		if ($request->filled('search')) {
			$search = $request->input('search');
			$products = $products->whereHas('translates', function ($q) use ($search) {
				$q->where('lang', app()->getLocale())
				  ->where('title', 'like', '%' . $search . '%')
				  ->orWhere('description', 'like', '%' . $search . '%');
			});
		}
		return [$search, $products];
	}

	/**
	 * @param Request $request
	 * @param $products
	 * @return mixed
	 */
	private function handleFilters(Request $request, $products)
	{
		if ($request->filled('category')) {
			$ids = Category::whereIn('slug', explode(',', $request->input('category')))->pluck('id');

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
