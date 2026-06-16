<?php

namespace App\Modules\AdminDashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Story\Models\StoryStoryModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDashboardViewController extends Controller
{
    public function __invoke(Request $request): View
    {
        // In a real app, this would use a Query class to fetch aggregate data.
        $stats = [
            'total_users' => User::count(),
            'total_stories' => StoryStoryModel::count(),
            'total_views' => StoryStoryModel::sum('views_count'),
            'monthly_revenue' => '$' . number_format(rand(1000, 10000), 2), // Mock data
        ];

        return view('modules.admin-dashboard.index', compact('stats'));
    }
}
