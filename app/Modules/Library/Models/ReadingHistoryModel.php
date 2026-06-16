<?php

namespace App\Modules\Library\Models;

use App\Models\User;
use App\Modules\Story\Models\ChapterStoryModel;
use App\Modules\Story\Models\StoryStoryModel;
use Illuminate\Database\Eloquent\Model;

class ReadingHistoryModel extends Model
{
    protected $table = 'reading_history';

    protected $fillable = [
        'user_id',
        'story_id',
        'chapter_id',
        'scroll_position',
        'progress_percent',
        'last_read_at'
    ];

    protected $casts = [
        'last_read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function story()
    {
        return $this->belongsTo(StoryStoryModel::class, 'story_id');
    }

    public function chapter()
    {
        return $this->belongsTo(ChapterStoryModel::class, 'chapter_id');
    }
}
