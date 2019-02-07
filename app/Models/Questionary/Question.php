<?php

namespace App\Models\Questionary;

use App\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Talanoff\ImpressionAdmin\Traits\Translatable;

class Question extends Model
{
    use SluggableTrait, Translatable;

    protected $fillable = [
      'slug',
      'order',
    ];

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class);
    }
}
