<?php

namespace App\Http\Controllers\Front;

use App\Mail\Subscribe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class SubscribeController extends Controller
{
	/**
	 * Handle the incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function __invoke(Request $request)
	{
		$validated = $request->validate([
			'email' => 'required|email',
		]);

		Mail::send(new Subscribe($validated['email']));

		session()->put('message', 'pages.thanks.subscribe');

		return redirect()->route('app.thanks');
	}
}
