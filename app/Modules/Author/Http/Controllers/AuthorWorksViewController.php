<?php

namespace App\Modules\Author\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Story\Models\StoryStoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorWorksViewController extends Controller
{
    public function index()
    {
        $stories = StoryStoryModel::where('author_id', Auth::id())
            ->withCount('chapters')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('modules.author.works', [
            'stories' => $stories
        ]);
    }
}
