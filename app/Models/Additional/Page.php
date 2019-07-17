<?php

namespace App\Models\Additional;

use Illuminate\Database\Eloquent\Model;
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
}
