<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Additional\Page;
use App\Models\Article\Article;
use App\Models\Article\Group;
use App\Models\Article\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ArticlesController extends Controller
{
	/**
	 * @param Request $request
	 * @return View
	 */
	public function index(Request $request): View
	{
		$page = Page::whereSlug('articles')->first();
		$articles = Article::latest();
		$groups = Group::has('tags')->with('tags')->get();
		$tags = $groups->pluck('tags')->flatten();

		if ($request->filled('tags')) {
			$slugs = explode(',', $request->input('tags'));
			$ids = $tags->filter(function($t) use ($slugs) {
				return in_array($t->slug, $slugs);
			})->pluck('id');

			$articles = $articles->whereHas('tags', function (Builder $builder) use ($ids) {
				$builder->whereIn('id', $ids);
			});
		}

		$articles = $articles->paginate(10);

		return \view('app.articles.index', compact('page', 'articles', 'groups'));
	}

	/**
	 * @param Article $article
	 * @return View
	 */
	public function show(Article $article): View
	{
		$page = Page::whereSlug('articles')->first();
		$article->handleViewed();
		$related = Article::where('id', '!=', $article->id)
						  ->orderByDesc('views_count')
						  ->take(2)->get();

		return \view('app.articles.show', compact('article', 'related', 'page'));
	}

	/**
	 * @param Article $article
	 * @return JsonResponse
	 */
	public function toggleFavorites(Article $article): JsonResponse
	{
		$message = 'added';

		if ($article->in_favorites) {
			$article->favorites()->delete();
			$message = 'removed';
		} else {
			$article->favorites()->create([
				'user_id' => Auth::user()->id,
			]);
		}

		return \response()->json([
			'status' => $message,
		]);
	}
}
