<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\QuestionSavingRequest;
use App\Models\Questionary\Question;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class QuestionsController extends Controller
{
    /**
     * @return View
     */
    public function index():View
    {
        return \view('admin.questionary.question.index', [
            'questions' => Question::latest('id')->paginate(20),
        ]);
    }

    /**
     * @return View
     */
    public function create():View
    {
        return \view('admin.questionary.question.create',[
            'questions' => Question::get(),
        ]);

    }

    /**
     * @param Question $question
     * @return View
     */
    public function edit(Question $question): View
    {
        return \view('admin.questionary.question.edit', [
            'question' => $question,
            'questions' => Question::latest('id')->get(),
        ]);
    }

    /**
     * @param QuestionSavingRequest $request
     * @return RedirectResponse
     */
    public function store(QuestionSavingRequest $request): RedirectResponse
    {
        /** @var Question $question */
        $question = Question::create($request->only('order'));
        $question->makeTranslation();

        return \redirect()->route('admin.questions.edit', $question);
    }

    /**
     * @param QuestionSavingRequest $request
     * @param Question $question
     * @return RedirectResponse
     */
    public function update(QuestionSavingRequest $request, Question $question): RedirectResponse
    {
        if ($request->get('en')['title'] !== $question->translate('title', 'en')) {
            $question->slug = null;
        }
        /** @var Question $question */
        $question->update($request->only('order'));
        $question->updateTranslation();

        return \redirect()->route('admin.questions.edit', $question);
    }

    /**
     * @param Question $question
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Question $question): RedirectResponse
    {
        $question->delete();
        return \redirect()->route('admin.answers.index');
    }


}
