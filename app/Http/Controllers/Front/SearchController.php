<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article\Article;
use App\Models\Catalog\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\View\View;

class SearchController extends Controller
{
	/**
	 * Handle the incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return View
	 */
	public function index(Request $request): View
	{
		$search = $request->input('q');

		$products = Product::whereHas('translates', function ($q) use ($search) {
			$this->handleQuery($q, $search);
		})->get()->each(function ($i) {
			$i->category = 'catalog';
			$i->type = 'product';
		});

		$articles = Article::whereHas('translates', function ($q) use ($search) {
			$this->handleQuery($q, $search);
		})->get()->each(function ($i) {
			$i->category = 'articles';
			$i->type = 'article';
		});

		$results = $this->collection_paginate($products->concat($articles));

		return \view('app.pages.search', compact('results', 'search'));
	}

	/**
	 * @param $q
	 * @param $search
	 */
	private function handleQuery($q, $search): void
	{
		$q->where('lang', app()->getLocale())
		  ->where('title', 'like', '%' . $search . '%')
		  ->orWhere('description', 'like', '%' . $search . '%');
	}

	/**
	 * @param $items
	 * @param int $per_page
	 * @return LengthAwarePaginator
	 */
	private function collection_paginate($items, $per_page = 20)
	{
		$page = request()->input('page', 1);

		return new LengthAwarePaginator(
			$items->forPage($page, $per_page)->values(),
			$items->count(),
			$per_page,
			Paginator::resolveCurrentPage(),
			['path' => Paginator::resolveCurrentPath()]
		);
	}
}
