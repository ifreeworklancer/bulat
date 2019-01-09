<?php

namespace App\Models\Slider;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Talanoff\ImpressionAdmin\Traits\Translatable;

class Slide extends Model implements HasMedia
{
	use Translatable, HasMediaTrait;

	protected $fillable = [
		'slider_id',
		'has_background',
		'is_visible',
	];

	public function slider(): BelongsTo
	{
		return $this->belongsTo(Slider::class);
	}

	/**
	 * @param Media|null $media
	 * @throws \Spatie\Image\Exceptions\InvalidManipulation
	 */
	public function registerMediaConversions(Media $media = null)
	{
		$this->addMediaConversion('thumb')
			 ->fit(Manipulations::FIT_CROP, 100, 100)
			 ->width(100)
			 ->height(100)
			 ->sharpen(10);

		$this->addMediaConversion('banner')
			 ->width(1920)
			 ->height(1920)
			 ->sharpen(10);
	}

	/**
	 * @return string
	 */
	public function getThumbAttribute(): string
	{
		return $this->getFirstMediaUrl('slides', 'thumb');
	}

	/**
	 * @return string
	 */
	public function getBannerAttribute(): string
	{
		return $this->getFirstMediaUrl('slides', 'banner');
	}
}
