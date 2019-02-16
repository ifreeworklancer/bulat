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
		return \view('app.catalog.index', [
			'categories' => Category::latest('id')->get(),
			'page' => $this->page,
			'search' => $request->input('search'),
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
}
