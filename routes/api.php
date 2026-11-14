
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DetectionEventController;

Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'DecoyGuard API aktif',
    ]);
});

Route::post('/events', [DetectionEventController::class, 'store']);
