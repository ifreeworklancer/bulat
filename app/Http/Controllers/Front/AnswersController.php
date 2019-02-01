<?php

namespace App\Http\Controllers\Front;

use App\Models\Questionary\Answer;
use App\Models\Questionary\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $questions = Question::questions();
            return \view('app.questionary.index', compact('questions'));

        } else {
            return \redirect()->route('login');
        }
    }

    public function store(Request $request)
    {
        Answer::create([
            'user_id' => Auth::user()->id,
            'answers' => $request->input('answers', [])
        ]);

        return redirect()->route('app.thanks');

    }

}
