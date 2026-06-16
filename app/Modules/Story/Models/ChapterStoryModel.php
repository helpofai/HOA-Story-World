<?php

namespace App\Modules\Story\Models;

use Illuminate\Database\Eloquent\Model;

class ChapterStoryModel extends Model
{
    protected $table = 'chapters';

    protected $fillable = [
        'story_id',
        'order_index',
        'title',
        'subtitle',
        'content',
        'status',
        'words_count',
        'characters_count',
        'views_count',
        'is_premium'
    ];

    public function story()
    {
        return $this->belongsTo(StoryStoryModel::class, 'story_id');
    }
}
