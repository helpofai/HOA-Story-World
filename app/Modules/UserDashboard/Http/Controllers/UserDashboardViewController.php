<?php

namespace App\Modules\UserDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Library\Models\ReadingHistoryModel;
use App\Modules\Library\Models\UserReadingStatsModel;
use App\Modules\Library\Models\DailyReadingActivityModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserDashboardViewController extends Controller
{
    public function __invoke(Request $request): View
    {
        $userId = Auth::id();

        $recentReading = ReadingHistoryModel::where('user_id', $userId)
            ->with(['story', 'chapter'])
            ->orderBy('last_read_at', 'desc')
            ->first();

        $statsModel = UserReadingStatsModel::where('user_id', $userId)->first();

        $stats = [
            'reading_streak' => $statsModel->current_streak ?? 0,
            'daily_reading_time' => $statsModel->daily_reading_minutes ?? 0,
            'finished_stories' => $statsModel->stories_finished_count ?? 0,
            'avg_speed' => 245,
        ];

        // Fetch activity for last 40 days (10 columns x 4 rows approx in UI)
        $activities = DailyReadingActivityModel::where('user_id', $userId)
            ->where('date', '>=', Carbon::now()->subDays(40))
            ->get()
            ->pluck('chapters_read', 'date')
            ->toArray();

        // Prepare heatmap data
        $heatmap = [];
        for ($i = 39; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $count = $activities[$date] ?? 0;
            
            // Map count to intensity 0-4
            $intensity = 0;
            if ($count > 0) $intensity = 1;
            if ($count > 2) $intensity = 2;
            if ($count > 5) $intensity = 3;
            if ($count > 10) $intensity = 4;

            $heatmap[$date] = $intensity;
        }

        return view('modules.user-dashboard.index', compact('stats', 'recentReading', 'heatmap'));
    }
}
