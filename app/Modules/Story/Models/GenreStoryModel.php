<?php

namespace App\Modules\Story\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GenreStoryModel extends Model
{
    protected $table = 'genres';

    protected $fillable = ['name', 'slug', 'description'];

    public function stories(): BelongsToMany
    {
        return $this->belongsToMany(StoryStoryModel::class, 'story_genre', 'genre_id', 'story_id');
    }
}
