<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InfluencerController;

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

// Influencers
Route::get('/influencers', [InfluencerController::class, 'index'])->name('influencers.index');
Route::post('/influencers', [InfluencerController::class, 'store'])->name('influencers.store');
Route::post('/influencers/{id}/campaigns', [InfluencerController::class, 'campaignStore'])->name('influencers.campaigns.store');