<?php

namespace App\Modules\Story\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class StoryStoryModel extends Model
{
    protected $table = 'stories';

    protected $fillable = [
        'author_id', 'language', 'title', 'slug', 'subtitle', 'synopsis',
        'cover_image', 'banner_image', 'map_image', 'status', 'age_rating',
        'views_count', 'readers_count', 'followers_count', 'favorites_count',
        'rating', 'is_featured', 'is_editor_pick'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_editor_pick' => 'boolean',
        'rating' => 'decimal:2',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(GenreStoryModel::class, 'story_genre', 'story_id', 'genre_id');
    }

    public function chapters()
    {
        return $this->hasMany(ChapterStoryModel::class, 'story_id')->orderBy('order_index');
    }

    public function characters()
    {
        return $this->hasMany(CharacterStoryModel::class, 'story_id');
    }

    public function locations()
    {
        return $this->hasMany(LocationStoryModel::class, 'story_id');
    }

    public function timelineEvents()
    {
        return $this->hasMany(TimelineEventStoryModel::class, 'story_id')->orderBy('year')->orderBy('month');
    }
}
