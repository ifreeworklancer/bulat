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
//		if (session()->has('locale')) {
//			$locale = session()->get('locale', config('app.locale'));
//		} else {
//			$locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
//
//			if ($locale !== 'ru' && $locale !== 'en') {
//				$locale = 'ru';
//			}
//		}
//
//		if (app('router')->currentRouteNamed('admin.*')) {
//			app()->setLocale('ru');
//		} else {
//			app()->setLocale($locale);
//		}
//
//		if (app()->getLocale() === 'ru') {
//			setlocale(LC_TIME, 'ru_RU.utf-8');
//		}

		if (app('router')->currentRouteNamed('admin.*')) {
			app()->setLocale('ru');
		} else {
			app()->setLocale('en');
		}

		return $next($request);
    }
}
