<?php

if (!function_exists('remove_tags')) {
	function remove_tags($text, $limit = 100) {
		return str_limit(preg_replace('/<[^>]*>/', ' ', $text), $limit);
	}
}

if (!function_exists('build_filter_url')) {
	function build_filter_url($array, $route = null)
	{
		if (!$array || !is_array($array)) {
			return null;
		}

		return route($route ?? app('router')->currentRouteName(), array_merge(request()->except('page'), $array));
	}
}