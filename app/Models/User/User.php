<?php

namespace App\Models\User;

use App\Models\Additional\Application;
use App\Models\Additional\Favorite;
use App\Models\Catalog\Order;
use App\Models\Questionary\Answer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

/**
 * @property mixed processingOrders
 * @property mixed completedOrders
 * @property mixed declinedOrders
 */
class User extends Authenticatable
{
	use Notifiable, SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * @return BelongsTo
	 */
	public function role(): BelongsTo
	{
		return $this->belongsTo(Role::class);
	}

	/**
	 * @param $needle
	 * @return bool
	 */
	public function hasRole($needle): bool
	{
		if (is_array($needle)) {
			return in_array($this->role->name, $needle);
		}

		return $this->role->name === $needle;
	}

	/**
	 * @return HasMany
	 */
	public function orders(): HasMany
	{
		return $this->hasMany(Order::class)->has('product');
	}

	/**
	 * @return HasOne
	 */
	public function profile(): HasOne
	{
		return $this->hasOne(Profile::class);
	}

	/**
	 * @return HasMany
	 */
	public function favorites(): HasMany
	{
		return $this->hasMany(Favorite::class);
	}

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
	}

	/**
	 * @return HasMany
	 */
	public function applications(): HasMany
	{
		return $this->hasMany(Answer::class)->latest('id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Builder|HasMany
	 */
	public function processingOrders()
	{
		return $this->orders()
					->with('product')
					->whereIn('status', ['processing', 'no_dial']);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Builder|HasMany
	 */
	public function completedOrders()
	{
		return $this->orders()
					->with('product')
					->where('status', 'completed');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Builder|HasMany
	 */
	public function declinedOrders()
	{
		return $this->orders()
					->with('product')
					->where('status', 'declined');
	}
}
