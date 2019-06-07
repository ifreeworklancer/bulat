<?php

namespace App\Traits;


use Cviebrock\EloquentSluggable\Sluggable;

trait SluggableTrait
{
	use Sluggable;

	/**
	 * Defining default route key
	 * @return string
	 */
	public function getRouteKeyName()
	{
		return 'slug';
	}

	/**
	 * Configuring sluggable
	 * @return array
	 */
	public function sluggable()
	{
		return [
			'slug' => [
				'source' => 'slug_title',
			],
		];
	}

	/**
	 * Get title for slug generating
	 * @return string
	 */
	public function getSlugTitleAttribute(): string
	{
	    dd(request()->all());
		return request()->get('ua')['title'];
	}
}