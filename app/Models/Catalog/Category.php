<?php

namespace App\Models\Catalog;

use App\Traits\FiltrableTrait;
use App\Traits\SluggableTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Talanoff\ImpressionAdmin\Traits\Translatable;

class Category extends Model implements HasMedia
{
	use SluggableTrait, Translatable, HasMediaTrait, FiltrableTrait;

	protected $fillable = [
		'slug',
	];

	protected $filtrable = 'category';

	/**
	 * @return BelongsToMany
	 */
	public function products(): BelongsToMany
	{
		return $this->belongsToMany(Product::class);
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

		$this->addMediaConversion('preview')
			 ->fit(Manipulations::FIT_CROP, 368, 368)
			 ->width(368)
			 ->height(368)
			 ->sharpen(10);
	}

	/**
	 * @return string
	 */
	public function getPreviewAttribute(): string
	{
		return $this->hasMedia('category')
			? $this->getFirstMediaUrl('category', 'preview')
			: asset('images/no-image.png');
	}
}
