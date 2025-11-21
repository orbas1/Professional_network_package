<?php

use Illuminate\Support\Facades\Route;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\CompanyProfileController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\ConnectionsController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\HashtagController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\MarketplaceDisputeController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\MarketplaceEscrowController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\PostEnhancementController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\ProfessionalProfileController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\StoryEnhancementController;

Route::middleware(['web', 'auth'])->prefix('pro-network')->group(function () {
    Route::get('/my-network', [ConnectionsController::class, 'index']);
    Route::get('/my-network/connections', [ConnectionsController::class, 'list']);
    Route::get('/my-network/mutual/{user}', [ConnectionsController::class, 'mutual']);

    Route::get('/profile/professional', [ProfessionalProfileController::class, 'show']);
    Route::get('/profile/professional/{user}', [ProfessionalProfileController::class, 'show']);
    Route::get('/profile/professional/edit', [ProfessionalProfileController::class, 'edit']);
    Route::post('/profile/professional', [ProfessionalProfileController::class, 'update']);

    Route::get('/company/{company}', [CompanyProfileController::class, 'show']);
    Route::post('/company/{company}', [CompanyProfileController::class, 'update'])->middleware('can:update,company');

    Route::get('/marketplace/orders/{order}/escrow', [MarketplaceEscrowController::class, 'showByOrder']);
    Route::get('/marketplace/orders/{order}/disputes/create', [MarketplaceDisputeController::class, 'create']);
    Route::get('/marketplace/disputes/{dispute}', [MarketplaceDisputeController::class, 'show']);

    Route::get('/stories/viewer', [StoryEnhancementController::class, 'viewer']);
    Route::get('/stories/creator', [StoryEnhancementController::class, 'creator']);

    Route::get('/hashtags/{hashtag}', [HashtagController::class, 'show']);

    Route::get('/posts/polls/create', [PostEnhancementController::class, 'createPoll']);
    Route::get('/posts/threads/create', [PostEnhancementController::class, 'createThread']);
    Route::get('/posts/celebrate/create', [PostEnhancementController::class, 'createCelebrate']);
});
