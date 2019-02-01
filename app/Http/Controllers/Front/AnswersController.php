<?php

namespace App\Http\Controllers\Front;

use App\Jobs\FileStoring;
use App\Models\Questionary\Answer;
use App\Models\Questionary\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
	public function index()
	{
		$questions = Question::orderBy('order')->get();
		return \view('app.questionary.index', compact('questions'));
	}

	public function store(Request $request)
	{
		/** @var Answer $answer */
		$answer = Answer::create([
			'user_id' => Auth::user()->id,
			'answers' => $request->input('answers', []),
		]);

		if ($request->filled('files')) {
			foreach ($request->input('files') as $key => $file) {
				dispatch(new FileStoring($answer, $file, $key + 1, str_slug(auth()->user()->name)));
			}
		}

		return redirect()->route('app.thanks');

	}

}
