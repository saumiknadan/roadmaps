<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\RoadmapController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\UpvoteController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\AppInfoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication
Route::post('register', [RegisterController::class, 'store'])->name('api.register');
Route::post('login', [LoginController::class, 'store'])->name('api.login');

Route::get('/roadmaps', [RoadmapController::class, 'index'])->name('api.roadmaps.index');
Route::get('/roadmaps/{id}', [RoadmapController::class, 'show'])->name('api.roadmaps.show');



Route::middleware('auth:sanctum')->group(function () {
    // Logout route (requires being logged in to log out)
    Route::post('logout', [LoginController::class, 'destroy'])->name('api.logout');

    // Comment routes
    Route::get('roadmaps/{roadmapId}/comments', [CommentController::class, 'index'])->name('api.roadmaps.comments');
    Route::post('roadmaps/{roadmapId}/comments', [CommentController::class, 'store'])->name('api.roadmaps.comments.store');
    Route::put('comments/{commentId}', [CommentController::class, 'update'])->name('api.comments.update');
    Route::delete('comments/{commentId}', [CommentController::class, 'destroy'])->name('api.comments.destroy');

    // Upvote route
    Route::post('roadmaps/{roadmapId}/upvote', [UpvoteController::class, 'toggle'])->name('api.roadmaps.upvote.toggle');

    // Category
    Route::get('categories', [CategoryController::class, 'index'])->name('api.categories.index');
    Route::get('app-info', [AppInfoController::class, 'index'])->name('api.app-info.index');

});


