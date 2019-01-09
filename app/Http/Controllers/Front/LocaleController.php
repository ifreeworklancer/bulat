<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocaleController extends Controller
{
	public function switch($lang): RedirectResponse
	{
		if (in_array($lang, config('app.locales'))) {
			app()->setLocale($lang);
			session()->put('locale', $lang);
		}

		return \back();
	}
}
