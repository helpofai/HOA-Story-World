<?php

namespace App\Modules\Story\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LocationStoryModel extends Model
{
    protected $table = 'story_locations';

    protected $fillable = [
        'story_id',
        'name',
        'description',
        'type',
        'x_pos',
        'y_pos',
        'icon',
        'is_secret'
    ];

    protected $casts = [
        'is_secret' => 'boolean',
        'x_pos' => 'float',
        'y_pos' => 'float',
    ];

    public function story(): BelongsTo
    {
        return $this->belongsTo(StoryStoryModel::class, 'story_id');
    }
}
