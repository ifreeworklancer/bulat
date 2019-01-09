<?php

namespace App\Models\Article;

use App\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Talanoff\ImpressionAdmin\Traits\Translatable;

class Group extends Model
{
	use Translatable, SluggableTrait;

	protected $fillable = [
		'slug',
	];

	/**
	 * @return HasMany
	 */
	public function tags(): HasMany
	{
		return $this->hasMany(Tag::class);
	}
}
