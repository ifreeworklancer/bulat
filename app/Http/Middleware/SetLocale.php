<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		if (session()->has('locale')) {
			$locale = session()->get('locale', config('app.locale'));
		} else {
			$locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

			if ($locale !== 'ru' && $locale !== 'uk') {
				$locale = 'ru';
			}
		}

		if (app('router')->currentRouteNamed('admin.*')) {
			app()->setLocale('ru');
		} else {
			app()->setLocale($locale);
		}

		if (app()->getLocale() === 'ru') {
			setlocale(LC_TIME, 'ru_RU.utf-8');
		}

        if (app()->getLocale() === 'uk') {
            setlocale(LC_TIME, 'uk_UA.utf-8');
        }

		return $next($request);
    }
}
