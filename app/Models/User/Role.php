<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
	public static $ROLES = [
		'admin',
		'customer',
	];

	protected $fillable = [
		'name',
		'display',
	];

	public function users(): HasMany
	{
		return $this->hasMany(User::class);
	}
}
