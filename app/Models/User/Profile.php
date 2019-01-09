<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
	protected $fillable = [
		'phone_1',
		'phone_2',
		'country',
		'state',
		'city',
		'address',
	];

	public function owner(): BelongsTo
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}
