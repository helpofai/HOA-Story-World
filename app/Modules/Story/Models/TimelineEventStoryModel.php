<?php

namespace App\Modules\Story\Models;

use Illuminate\Database\Eloquent\Model;

class TimelineEventStoryModel extends Model
{
    protected $table = 'timeline_events';

    protected $fillable = [
        'story_id',
        'year',
        'month',
        'title',
        'description'
    ];

    public function story()
    {
        return $this->belongsTo(StoryStoryModel::class, 'story_id');
    }
}
