<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionSavingRequest;
use App\Models\Questionary\Question;
use App\Models\Questionary\Variant;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class QuestionsController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return \view('admin.questionary.question.index', [
            'questions' => Question::latest('id')->paginate(20),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return \view('admin.questionary.question.create', [
            'questions' => Question::get(),
            'variants' => Variant::get(),
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

        if ($request->filled('variant')) {
            foreach ($request->input('variant') as $key => $item) {
                $variant = $question->variants()->create();

                foreach (config('app.locales') as $lang) {
                    $variant->translates()->create([
                        'lang' => $lang,
                        'title' => $request->input('variant')[$key][$lang]
                    ]);
                }
            }
        }

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

        if ($request->filled('variant')) {
            foreach ($question->variants as $variant) {
                foreach (config('app.locales') as $lang) {
                    $variant->translates()->where('lang', $lang)->update([
                        'title' => $request->input('variant')[$variant->id][$lang]
                    ]);
                }
            }
        }

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
        return \redirect()->route('admin.questions.index');
    }


}
