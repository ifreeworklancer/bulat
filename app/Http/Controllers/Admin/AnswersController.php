<?php

namespace App\Http\Controllers\Admin;

use App\Models\Questionary\Answer;
use App\Models\Questionary\Question;
use App\Models\User\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AnswersController extends Controller
{
	/**
	 * @return View
	 */
	public function index(): View
	{
		return \view('admin.questionary.answer.index', [
			'answers' => Answer::latest('id')->with('user')->paginate(20),
		]);
	}

	/**
	 * @param Answer $answer
	 * @return View
	 */
	public function edit(Answer $answer): View
	{
		return \view('admin.questionary.answer.edit', compact('answer'));
	}

	/**
	 * @param Request $request
	 * @param Answer $answer
	 * @return RedirectResponse
	 */
	public function update(Request $request, Answer $answer): RedirectResponse
	{
		$answer->update($request->only('status'));
		return \back();
	}

	/**
	 * @param Answer $answer
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Answer $answer): RedirectResponse
	{
		$answer->delete();
		return \redirect()->route('admin.answers.index');
	}
}
