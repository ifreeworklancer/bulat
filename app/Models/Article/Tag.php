<?php

namespace App\Models\Article;

use App\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Talanoff\ImpressionAdmin\Traits\Translatable;

class Tag extends Model
{
	use Translatable, SluggableTrait;

	protected $fillable = [
		'slug',
		'group_id',
	];

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

	/**
	 * Add tag to query string filter
	 * @return array
	 */
	public function buildQueryFilter()
	{
		$tags = request()->filled('tags') ? explode(',', request()->get('tags')) : [];
		if (!in_array($this->id, $tags)) {
			array_push($tags, $this->id);
		}
		sort($tags);

		return ['tags' => implode(',', $tags)];
	}

	/**
	 * Remove tag from query string filter
	 * @return array
	 */
	public function removeFromQueryFilter()
	{
		$tags = explode(',', request()->get('tags', ''));
		if (($key = array_search($this->id, $tags)) !== false) {
			unset($tags[$key]);
		}
		sort($tags);

		return count($tags) ? ['tags' => implode(',', $tags)] : [];
	}
}
