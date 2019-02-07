<?php

namespace App\Models\Article;

use App\Traits\FiltrableTrait;
use App\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Talanoff\ImpressionAdmin\Traits\Translatable;

class Tag extends Model
{
	use Translatable, SluggableTrait, FiltrableTrait;

	protected $fillable = [
		'slug',
		'group_id',
	];

	protected $filtrable = 'tags';

	/**
	 * @return BelongsTo
	 */
	public function group(): BelongsTo
	{
		return $this->belongsTo(Group::class);
	}

	/**
	 * @return BelongsToMany
	 */
	public function articles(): BelongsToMany
	{
		return $this->belongsToMany(Article::class);
	}
}
