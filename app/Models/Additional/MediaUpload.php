<?php

namespace App\Models\Additional;

use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class MediaUpload extends Model implements HasMedia
{
    use HasMediaTrait;

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

        $this->addMediaConversion('preview')
            ->width(480)
            ->height(480)
            ->sharpen(10);

		$this->addMediaConversion('banner')
			 ->width(1200)
			 ->height(1200)
			 ->sharpen(10);
	}
}
