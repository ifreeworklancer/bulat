<?php

namespace App\Models\Questionary;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Talanoff\ImpressionAdmin\Traits\Translatable;

class Variant extends Model
{
    use Translatable;

    protected $fillable = [
        'question_id',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
