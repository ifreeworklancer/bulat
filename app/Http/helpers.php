<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

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

if (!function_exists('create_file_name')) {
    function create_file_name(UploadedFile $file)
    {
        $fileName = $file->getClientOriginalName();
        $fileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);

        return Str::slug($fileName).'.'.$file->getClientOriginalExtension();
    }
}