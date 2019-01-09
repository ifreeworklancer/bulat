<?php

namespace App\Models\Additional;

use Illuminate\Database\Eloquent\Model;
use Talanoff\ImpressionAdmin\Traits\Translatable;

class Page extends Model
{
	use Translatable;

	protected $fillable = [
		'slug',
		'props',
	];
}
