<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InfluencerController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Auth
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::group(['middleware' => ['auth.jwt']], function () {
    // Influencers
    Route::get('/influencers', [InfluencerController::class, 'index'])->name('influencers.index');
    Route::post('/influencers', [InfluencerController::class, 'store'])->name('influencers.store');
    Route::post('/influencers/{id}/campaigns', [InfluencerController::class, 'campaignStore'])->name('influencers.campaigns.store');

    // Campaigns
    Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
    Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
    Route::post('/campaigns/{id}/influencers', [CampaignController::class, 'influencerStore'])->name('campaigns.influencers.store');

    // Category
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
});