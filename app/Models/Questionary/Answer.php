<?php

namespace App\Models\Questionary;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Answer extends Model implements HasMedia
{
	use HasMediaTrait;

	public static $statuses = [
		'processing',
		'confirmed',
		'declined',
	];

	protected $fillable = [
		'user_id',
		'answers',
		'status',
	];

	protected $casts = [
		'answers' => 'array',
	];

	/**
	 * @return BelongsTo
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function registerMediaCollections()
	{
		$this
			->addMediaCollection('answers')
			->registerMediaConversions(function (Media $media) {
				$this
					->addMediaConversion('thumb')
					->crop(Manipulations::CROP_CENTER, 300, 300)
					->width(300)
					->height(300);
			});
	}
}
