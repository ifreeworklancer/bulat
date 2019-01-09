<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    public static $STATUSES = [
    	'processing',
		'no_dial',
		'finished',
		'declined',
	];
}
