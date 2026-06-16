<?php

namespace App\Modules\Library\Actions;

use App\Modules\Library\Models\UserReadingStatsModel;
use Carbon\Carbon;

class UpdateReadingStreakAction
{
    public function execute(int $userId)
    {
        $stats = UserReadingStatsModel::firstOrCreate(
            ['user_id' => $userId]
        );

        $today = Carbon::today();
        $lastReadDate = $stats->last_read_date;

        if (!$lastReadDate) {
            // First time reading
            $stats->current_streak = 1;
            $stats->max_streak = 1;
        } else {
            $diffInDays = $today->diffInDays($lastReadDate);

            if ($diffInDays === 1) {
                // Read yesterday, increment streak
                $stats->current_streak += 1;
                if ($stats->current_streak > $stats->max_streak) {
                    $stats->max_streak = $stats->current_streak;
                }
            } elseif ($diffInDays > 1) {
                // Last read more than a day ago, reset streak
                $stats->current_streak = 1;
            }
            // If diffInDays is 0, they already read today, streak remains same
        }

        $stats->last_read_date = $today;
        $stats->save();

        return $stats;
    }
}
