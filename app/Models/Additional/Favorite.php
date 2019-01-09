<?php

namespace App\Models\Additional;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Favorite extends Model
{
	protected $fillable = [
		'user_id',
	];

	public function favoritable()
	{
		return $this->morphTo();
	}

	/**
	 * @return BelongsTo
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
