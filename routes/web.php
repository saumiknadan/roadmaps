<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoadmapController;
use App\Http\Controllers\AppInfoController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {


    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // App Info
    Route::get('admin/app-info', [AppInfoController::class, 'index'])->name('app-info.index');
    Route::get('admin/app-info/create', [AppInfoController::class, 'create'])->name('app-info.create');
    Route::post('admin/app-info', [AppInfoController::class, 'store'])->name('app-info.store');
    Route::get('admin/app-info/{app_info}/edit', [AppInfoController::class, 'edit'])->name('app-info.edit');
    Route::put('admin/app-info/{app_info}', [AppInfoController::class, 'update'])->name('app-info.update');

    // Category
    Route::resource('categories', CategoryController::class);
    Route::get('cat-status{category}', [CategoryController::class, 'change_status'])->name('categories.status');

    // Roadmap
    Route::resource('admin/roadmaps', RoadmapController::class);

});


Route::get('/cache/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return redirect()->back()->with('success', 'System Cache Has Been Removed.');
})->name('admin-cache-clear');


require __DIR__.'/auth.php';
