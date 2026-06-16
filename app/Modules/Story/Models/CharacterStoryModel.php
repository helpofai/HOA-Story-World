<?php

namespace App\Modules\Story\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterStoryModel extends Model
{
    protected $table = 'characters';

    protected $fillable = [
        'story_id',
        'name',
        'initials',
        'role',
        'age',
        'description',
        'color_theme'
    ];

    public function story()
    {
        return $this->belongsTo(StoryStoryModel::class, 'story_id');
    }
}
