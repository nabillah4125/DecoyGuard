<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DetectionEventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\DecoyAssetController;
use App\Http\Controllers\DecoyFolderController;
Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonitoredHostController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::middleware(['auth'])->group(function () {
    Route::get('/decoy-folders', [DecoyFolderController::class, 'index'])
        ->name('decoy-folders.index');

    Route::get('/decoy-folders/create', [DecoyFolderController::class, 'create'])
        ->name('decoy-folders.create');

    Route::post('/decoy-folders', [DecoyFolderController::class, 'store'])
        ->name('decoy-folders.store');

    Route::get('/monitored-hosts', [MonitoredHostController::class, 'index'])
        ->name('monitored-hosts.index');

    Route::get('/monitored-hosts/create', [MonitoredHostController::class, 'create'])
        ->name('monitored-hosts.create');

    Route::post('/monitored-hosts', [MonitoredHostController::class, 'store'])
        ->name('monitored-hosts.store');

    Route::post('/monitored-hosts/{id}/regenerate-token', [MonitoredHostController::class, 'regenerateToken'])
        ->name('monitored-hosts.regenerate-token');
});
Route::get('/detection-events/{id}', [DetectionEventController::class, 'show'])
    ->name('detection-events.show');

Route::middleware('auth')->group(function () {
    Route::get('/detection-events', [DetectionEventController::class, 'index'])
        ->name('detection-events.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {
    Route::get('/alerts', [AlertController::class, 'index'])
        ->name('alerts.index');

    Route::get('/alerts/{id}', [AlertController::class, 'show'])
        ->name('alerts.show');
    Route::post('/alerts/{id}/acknowledge', [AlertController::class, 'acknowledge'])
        ->name('alerts.acknowledge');

    Route::post('/alerts/{id}/resolve', [AlertController::class, 'resolve'])
        ->name('alerts.resolve');
});
// Decoy Assets
Route::get('/decoy-folders/{folderId}/assets', [DecoyAssetController::class, 'index'])
    ->name('decoy-assets.index');

Route::get('/decoy-folders/{folderId}/assets/create', [DecoyAssetController::class, 'create'])
    ->name('decoy-assets.create');

Route::post('/decoy-folders/{folderId}/assets', [DecoyAssetController::class, 'store'])
    ->name('decoy-assets.store');
require __DIR__.'/auth.php';
