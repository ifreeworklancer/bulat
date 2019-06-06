<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TagSavingRequest;
use App\Models\Article\Group;
use App\Models\Article\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TagsController extends Controller
{
	/**
	 * @param Request $request
	 * @return View
	 */
	public function index(Request $request): View
	{
		$tags = Tag::with('group');
		if ($request->filled('group')) {
			$tags = $tags->whereHas('group', function ($q) use ($request) {
				$q->whereSlug($request->input('group'));
			});
		}

		return \view('admin.tags.index', [
			'tags' => $tags->latest('id')->paginate(20),
			'has_groups' => Group::count() > 0,
		]);
	}

	/**
	 * @return View
	 */
	public function create(): View
	{
		return \view('admin.tags.create', [
			'groups' => Group::get(),
		]);
	}

	/**
	 * @param TagSavingRequest $request
	 * @return RedirectResponse
	 */
	public function store(TagSavingRequest $request): RedirectResponse
	{
		/** @var Tag $tag */
		$tag = Tag::create($request->only('group_id'));
		$tag->makeTranslation();

		return \redirect()->route('admin.tags.edit', $tag);
	}

	/**
	 * @param Tag $tag
	 * @return View
	 */
	public function edit(Tag $tag): View
	{
		return \view('admin.tags.edit', [
			'tag' => $tag,
			'groups' => Group::get(),
		]);
	}

	/**
	 * @param TagSavingRequest $request
	 * @param Tag $tag
	 * @return RedirectResponse
	 */
	public function update(TagSavingRequest $request, Tag $tag)
	{
		if ($request->get('en')['title'] !== $tag->translate('title', 'en')) {
			$tag->slug = null;
		}

		$tag->update($request->only('group_id'));
		$tag->updateTranslation();

		return \redirect()->route('admin.tags.edit', $tag);
	}

	/**
	 * @param Tag $tag
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Tag $tag): RedirectResponse
	{
		$tag->delete();
		return \redirect()->route('admin.tags.index');
	}
}
