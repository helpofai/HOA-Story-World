<?php

use App\Http\Controllers\ProfileController;
use App\Modules\Story\Http\Controllers\StoryHomeViewController;
use App\Modules\Story\Http\Controllers\StoryExploreViewController;
use App\Modules\Story\Http\Controllers\StoryDetailViewController;
use App\Modules\Story\Http\Controllers\ChapterReaderViewController;
use App\Modules\AdminDashboard\Http\Controllers\AdminDashboardViewController;
use App\Modules\UserDashboard\Http\Controllers\UserDashboardViewController;
use App\Modules\Library\Http\Controllers\LibraryViewController;
use App\Modules\Author\Http\Controllers\AuthorStudioViewController;
use App\Modules\Author\Http\Controllers\StoryCreatorViewController;
use App\Modules\Author\Http\Controllers\AuthorWorksViewController;
use App\Modules\Story\Http\Controllers\StorySearchController;
use App\Modules\Story\Http\Controllers\StoryMapController;
use Illuminate\Support\Facades\Route;

Route::get('/', StoryHomeViewController::class);
Route::get('/api/search', StorySearchController::class)->name('api.search');
Route::get('/explore', [StoryExploreViewController::class, 'index']);
Route::get('/story/{slug}', [StoryDetailViewController::class, 'show'])->name('story.show');
Route::get('/story/{slug}/map', [StoryMapController::class, 'show'])->name('story.map');
Route::post('/story/{storyId}/location', [StoryMapController::class, 'storeLocation'])->middleware(['auth', 'verified']);
Route::get('/read/{slug}/{chapterId}', [ChapterReaderViewController::class, 'show'])->name('story.reader');
Route::post('/read/progress/{chapterId}', [ChapterReaderViewController::class, 'trackProgress'])->name('story.reader.progress');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/studio', [AuthorStudioViewController::class, 'index'])->name('author.studio');
    Route::post('/studio/autosave/{chapterId}', [AuthorStudioViewController::class, 'autosave'])->name('author.studio.autosave');
    Route::post('/studio/chapter/create/{storyId}', [AuthorStudioViewController::class, 'createChapter'])->name('author.studio.chapter.create');
    
    Route::get('/author/works', [AuthorWorksViewController::class, 'index'])->name('author.works');
    Route::get('/author/create-story', [StoryCreatorViewController::class, 'create'])->name('author.story.create');
    Route::post('/author/create-story', [StoryCreatorViewController::class, 'store'])->name('author.story.store');
});

Route::get('/dashboard', UserDashboardViewController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/library', [LibraryViewController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('library');

Route::get('/admin', AdminDashboardViewController::class)
    ->middleware(['auth', 'admin'])
    ->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
