<?php

namespace App\Modules\Library\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReadingActivityModel extends Model
{
    protected $table = 'daily_reading_activity';

    protected $fillable = [
        'user_id',
        'date',
        'chapters_read',
        'minutes_read'
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
