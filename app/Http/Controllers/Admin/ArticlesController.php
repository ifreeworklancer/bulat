<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleSavingRequest;
use App\Models\Article\Article;
use App\Models\Article\Group;
use App\Models\Article\Tag;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use function redirect;

class ArticlesController extends Controller
{
    /**
     * @param  Request  $request
     * @return View
     */
    public function index(Request $request): View
    {
        $tags = collect([]);
        $articles = Article::with(['tags', 'translates']);

        if ($request->filled('tags')) {
            $ids = explode(',', $request->input('tags'));
            $tags = Tag::whereIn('slug', $ids)->get();
            $articles = $articles->whereHas('tags', function ($q) use ($ids) {
                $q->whereIn('slug', $ids);
            });
        }

        if ($request->filled('q')) {
            $query = $request->input('q');
            $articles = $articles->whereHas('translates', function (Builder $builder) use ($query) {
                $builder->where('title', 'like', "%{$query}%");
            });
        }

        return \view('admin.articles.index', [
            'articles' => $articles->latest('id')->paginate(20),
            'tags' => $tags,
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return \view('admin.articles.create', [
            'groups' => Group::has('tags')->get(),
            'tags' => Tag::with('group')->get()->groupBy('group_id'),
        ]);
    }

    /**
     * @param  ArticleSavingRequest  $request
     * @return RedirectResponse
     */
    public function store(ArticleSavingRequest $request): RedirectResponse
    {
        /** @var Article $article */
        $article = Article::create([
            'video' => $request->input('video'),
            'is_published' => $request->has('is_published'),
        ]);
        $article->makeTranslation();
        $article->tags()->attach($request->input('tags'));

        if ($request->hasFile('image')) {
            $article->addMediaFromRequest('image')
                ->usingFileName(create_file_name($request->file('image')))
                ->toMediaCollection('articles');
        }

        if ($request->has('meta')) {
            foreach ($request->get('meta') as $key => $meta) {
                $article->meta()->create([
                    $key => $meta
                ]);
            }
        }
        return redirect()->route('admin.articles.edit', $article);
    }

    /**
     * @param  Article  $article
     * @return View
     */
    public function edit(Article $article): View
    {
        return \view('admin.articles.edit', [
            'article' => $article,
            'groups' => Group::has('tags')->get(),
            'tags' => Tag::with('group')->get()->groupBy('group_id'),
        ]);
    }

    /**
     * @param  ArticleSavingRequest  $request
     * @param  Article  $article
     * @return RedirectResponse
     */
    public function update(ArticleSavingRequest $request, Article $article): RedirectResponse
    {
        if ($request->get('en')['title'] !== $article->translate('title', 'en')) {
            $article->slug = null;
        }

        $article->update([
            'video' => $request->input('video'),
            'is_published' => $request->has('is_published'),
        ]);
        $article->updateTranslation();
        $article->tags()->sync($request->input('tags'));

        if ($request->hasFile('image')) {
            $article->clearMediaCollection('articles');
            $article->addMediaFromRequest('image')
                ->usingFileName(create_file_name($request->file('image')))
                ->toMediaCollection('articles');
        }

        if($request->has('meta')){
            foreach ($request->get('meta') as $key => $meta) {
                $article->meta()->updateOrCreate([
                    'metable_id' => $article->id
                ], [
                    $key => $meta
                ]);
            }
        }

        return redirect()->route('admin.articles.edit', $article);
    }

    /**
     * @param  Article  $article
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();
        return redirect()->route('admin.articles.index');
    }
}
