<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SlideSavingRequest;
use App\Models\Slider\Slide;
use App\Models\Slider\Slider;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SlidesController extends Controller
{
	/**
	 * @return View
	 */
	public function index(): View
	{
		return \view('admin.slides.index', [
			'slides' => Slide::paginate(20),
		]);
	}

	/**
	 * @return View
	 */
	public function create(): View
	{
		return \view('admin.slides.create', [
			'sliders' => Slider::latest('id')->get(),
		]);
	}

	/**
	 * @param Slide $slide
	 * @return View
	 */
	public function edit(Slide $slide): View
	{
		return \view('admin.slides.edit', [
			'slide' => $slide,
			'sliders' => Slider::latest('id')->get(),
		]);
	}

	/**
	 * @param SlideSavingRequest $request
	 * @return RedirectResponse
	 */
	public function store(SlideSavingRequest $request): RedirectResponse
	{
		/** @var Slide $slide */
		$slide = Slide::create($this->handleRequest($request));

		if ($request->hasFile('image')) {
			$slide->addMediaFromRequest('image')
                ->usingFileName(create_file_name($request->file('image')))
                ->toMediaCollection('slides');
		}

		return \redirect()->route('admin.slides.edit', $slide);
	}

	/**
	 * @param SlideSavingRequest $request
	 * @param Slide $slide
	 * @return RedirectResponse
	 */
	public function update(SlideSavingRequest $request, Slide $slide): RedirectResponse
	{
		/** @var Slide $slide */
		$slide->update($this->handleRequest($request));

		if ($request->hasFile('image')) {
			$slide->clearMediaCollection('slides');
			$slide->addMediaFromRequest('image')
                ->usingFileName(create_file_name($request->file('image')))
                ->toMediaCollection('slides');
		}

		return \back();
	}

	/**
	 * @param Slide $slide
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function destroy(Slide $slide)
	{
		$slide->delete();

		return \redirect()->route('admin.slides.index');
	}

	/**
	 * @param SlideSavingRequest $request
	 * @return array
	 */
	private function handleRequest(SlideSavingRequest $request): array
	{
		return [
			'has_background' => $request->has('has_background'),
			'is_visible' => $request->has('is_visible'),
			'slider_id' => $request->slider_id,
		];
	}
}
