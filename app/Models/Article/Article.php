<?php

namespace App\Models\Article;

use App\Models\Additional\Favorite;
use App\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Talanoff\ImpressionAdmin\Traits\Translatable;

class Article extends Model implements HasMedia
{
	use Translatable, SluggableTrait, HasMediaTrait;

	protected $fillable = [
		'slug',
		'is_published',
		'views_count',
        'video',
	];

	protected $casts = [
		'views_count' => 'integer',
	];

	/**
	 * @return BelongsToMany
	 */
	public function tags(): BelongsToMany
	{
		return $this->belongsToMany(Tag::class);
	}

	/**
	 * @return MorphMany
	 */
	public function favorites(): MorphMany
	{
		return $this->morphMany(Favorite::class, 'favoritable');
	}

	/**
	 * Store viewed articles and count up
	 */
	public function handleViewed()
	{
		if (!session()->has('viewed_articles')) {
			session()->put('viewed_articles', []);
		}

		$viewed = collect(session()->get('viewed_articles'));

		if (!$viewed->contains($this->id)) {
			$viewed->prepend($this->id);
			session()->put('viewed_articles', $viewed->all());

			$this->update([
				'views_count' => $this->views_count + 1,
			]);
		}
	}

	/**
	 * @param Media|null $media
	 * @throws \Spatie\Image\Exceptions\InvalidManipulation
	 */
	public function registerMediaConversions(Media $media = null)
	{
		$this->addMediaConversion('thumb')
			 ->fit(Manipulations::FIT_CROP, 368, 368)
			 ->width(368)
			 ->height(368)
			 ->sharpen(10);

		$this->addMediaConversion('preview')
			 ->fit(Manipulations::FIT_CROP, 768, 468)
			 ->width(768)
			 ->height(468)
			 ->sharpen(10);

		$this->addMediaConversion('banner')
			 ->fit(Manipulations::FIT_CROP, 1920, 630)
			 ->width(1920)
			 ->height(630)
			 ->sharpen(10);
	}

	public function getPreviewAttribute(): string
	{
		return $this->getFirstMediaUrl('articles', 'preview');
	}

	public function getBannerAttribute(): string
	{
		return $this->getFirstMediaUrl('articles', 'banner');
	}

	/**
	 * @return bool
	 */
	public function getInFavoritesAttribute(): bool
	{
		return (bool)$this->favorites()->where('user_id', Auth::user()->id)->count();
	}
}
