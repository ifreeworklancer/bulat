<?php

namespace App\Models\Questionary;

use App\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Talanoff\ImpressionAdmin\Traits\Translatable;

class Question extends Model
{
    use SluggableTrait, Translatable;

    protected $fillable = [
      'slug',
      'order',
    ];

    public static function questions(){
        return self::where('order', '>', 0)->get();
    }
}
