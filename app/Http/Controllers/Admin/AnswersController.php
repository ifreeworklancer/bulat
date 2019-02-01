<?php

namespace App\Http\Controllers\Admin;

use App\Models\Questionary\Answer;
use App\Models\Questionary\Question;
use App\Models\User\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnswersController extends Controller
{
    public function index()
    {
        return \view('admin.questionary.answer.index', [
            'answers' => Answer::latest('id')->with('user')->paginate(20),
        ]);
    }

    public function edit(Answer $answer)
    {
        return  \view('admin.questionary.answer.edit', compact('answer'));
    }

    public function destroy(Answer $answer): RedirectResponse
    {
        $answer->delete();
        return \redirect()->route('admin.answers.index');
    }
}
