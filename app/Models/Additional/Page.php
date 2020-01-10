<?php

namespace App\Models\Additional;

use App\Models\Meta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Talanoff\ImpressionAdmin\Traits\Translatable;

class Page extends Model
{
	use Translatable;

    /**
     * Defining default route key
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

	protected $fillable = [
		'slug',
		'props',
	];

    /**
     * @return MorphMany
     */
    public function meta(): MorphMany
    {
        return $this->morphMany(Meta::class, 'metable');
    }
}
