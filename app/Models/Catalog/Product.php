<?php

namespace App\Models\Catalog;

use App\Http\Resources\ImageResource;
use App\Models\Additional\Favorite;
use App\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Talanoff\ImpressionAdmin\Traits\Translatable;

class Product extends Model implements HasMedia
{
	use SluggableTrait, Translatable, HasMediaTrait, SoftDeletes;

	protected $fillable = [
		'slug',
		'price',
		'is_published',
		'views_count',
	];

	protected $casts = [
		'views_count' => 'integer',
	];

	/**
	 * @return BelongsToMany
	 */
	public function categories(): BelongsToMany
	{
		return $this->belongsToMany(Category::class);
	}

	/**
	 * @return HasMany
	 */
	public function orders(): HasMany
	{
		return $this->hasMany(Order::class);
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
		if (!session()->has('viewed_products')) {
			session()->put('viewed_products', []);
		}

		$viewed = collect(session()->get('viewed_products'));

		if (!$viewed->contains($this->id)) {
			$viewed->prepend($this->id);
			session()->put('viewed_products', $viewed->all());

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
			 ->fit(Manipulations::FIT_CROP, 100, 100)
			 ->width(100)
			 ->height(100)
			 ->sharpen(10);

		$this->addMediaConversion('preview')
			 ->fit(Manipulations::FIT_CROP, 368, 468)
			 ->width(368)
			 ->height(468)
			 ->sharpen(10);

		$this->addMediaConversion('banner')
			 ->width(1920)
			 ->height(1920)
			 ->sharpen(10);
	}

	/**
	 * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
	 */
	public function getImagesListAttribute()
	{
		return ImageResource::collection($this->getMedia('uploads'));
	}

	/**
	 * @return string
	 */
	public function getPreviewAttribute(): string
	{
		return $this->hasMedia('uploads')
			? $this->getFirstMediaUrl('uploads', 'preview')
			: asset('images/no-image.png');
	}

	/**
	 * @return string
	 */
	public function getBannerAttribute(): string
	{
		return $this->hasMedia('uploads')
			? $this->getFirstMediaUrl('uploads', 'banner')
			: asset('images/no-image.png');
	}

	/**
	 * @return string
	 */
	public function getSkuAttribute(): string
	{
		return sprintf("%06d", $this->id);
	}

	/**
	 * @return bool
	 */
	public function getInFavoritesAttribute(): bool
	{
		return (bool)$this->favorites()->where('user_id', Auth::user()->id)->count();
	}

	protected static function boot()
	{
		parent::boot();

		self::addGlobalScope('ordered', function (Builder $builder) {
			$builder->latest();
		});
	}
}
