<?php

namespace App\Models\Catalog;

use App\Models\Meta;
use App\Traits\FiltrableTrait;
use App\Traits\SluggableTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Talanoff\ImpressionAdmin\Traits\Translatable;

class Category extends Model implements HasMedia, Sortable
{
	use SluggableTrait, SortableTrait, Translatable, HasMediaTrait, FiltrableTrait;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

	protected $fillable = [
		'slug',
        'sort_order'
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
     * @return MorphMany
     */
    public function meta(): MorphMany
    {
        return $this->morphMany(Meta::class, 'metable');
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
			 ->width(480)
			 ->height(480)
			 ->sharpen(10);
	}

	/**
	 * @return string
	 */
	public function getPreviewAttribute(): string
	{
		return $this->hasMedia('category')
			? $this->getFirstMedia('category')->getFullUrl('preview')
			: asset('images/no-image.png');
	}
    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope('sortById', function (Builder $builder) {
            $builder->orderBy('sort_order');
        });
    }
}
