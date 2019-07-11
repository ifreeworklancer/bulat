<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\GroupSavingRequest;
use App\Models\Article\Group;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class GroupsController extends Controller
{
	/**
	 * @return View
	 */
	public function index(): View
	{
		return \view('admin.groups.index', [
			'groups' => Group::with('tags')->latest('id')->paginate(20),
		]);
	}

	/**
	 * @return View
	 */
	public function create(): View
	{
		return \view('admin.groups.create');
	}

	/**
	 * @param GroupSavingRequest $request
	 * @return RedirectResponse
	 */
	public function store(GroupSavingRequest $request): RedirectResponse
	{
		/** @var Group $group */
		$group = Group::create();
		$group->makeTranslation();

		return \redirect()->route('admin.groups.edit', $group);
	}

	/**
	 * @param Group $group
	 * @return View
	 */
	public function edit(Group $group): View
	{
		return \view('admin.groups.edit', compact('group'));
	}

	/**
	 * @param GroupSavingRequest $request
	 * @param Group $group
	 * @return RedirectResponse
	 */
	public function update(GroupSavingRequest $request, Group $group): RedirectResponse
	{
		if ($request->get('en')['title'] !== $group->translate('title', 'en')) {
			$group->slug = null;
			$group->update();
		}

		$group->updateTranslation();

		return \redirect()->route('admin.groups.edit', $group);
	}

	/**
	 * @param Group $group
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Group $group)
	{
		$group->delete();
		return \redirect()->route('admin.groups.index');
	}
}
