<?php

namespace App\Modules\Library\Actions;

use App\Modules\Library\Models\DailyReadingActivityModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TrackReadingActivityAction
{
    public function execute(int $userId)
    {
        $today = Carbon::today()->toDateString();

        // Use DB update or create to be atomic
        DB::table('daily_reading_activity')->updateOrInsert(
            ['user_id' => $userId, 'date' => $today],
            [
                'chapters_read' => DB::raw('chapters_read + 1'),
                'updated_at' => now(),
                'created_at' => DB::raw('IFNULL(created_at, "'.now().'")')
            ]
        );
    }
}
