<?php

namespace App\Http\Controllers\Front;

use App\Jobs\FileStoring;
use App\Models\Questionary\Answer;
use App\Models\Questionary\Question;
use App\Models\Questionary\Variant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
	public function index()
	{
		$questions = Question::orderBy('order')->get();
		$variants = Variant::get();
		return \view('app.questionary.index', compact('questions', 'variants'));
	}

	public function store(Request $request)
	{
	    $answers = collect($request->get('answers'))->filter(function($answer) {
	        return $answer;
        });

		/** @var Answer $answer */
		$answer = Auth::user()->answers()->create([
			'answers' => $answers->all(),
		]);

		if ($request->filled('files')) {
			foreach ($request->input('files') as $key => $file) {
				dispatch(new FileStoring($answer, $file, $key + 1, str_slug(auth()->user()->name)));
			}
		}

		return redirect()->route('app.thanks');

	}

}
