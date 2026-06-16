<?php

namespace App\Modules\Library\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserReadingStatsModel extends Model
{
    protected $table = 'user_reading_stats';

    protected $fillable = [
        'user_id',
        'current_streak',
        'max_streak',
        'last_read_date',
        'total_reading_minutes',
        'daily_reading_minutes',
        'weekly_reading_minutes',
        'chapters_read_count',
        'stories_finished_count'
    ];

    protected $casts = [
        'last_read_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
