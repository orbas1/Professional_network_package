<?php

use Illuminate\Support\Facades\Route;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\CompanyProfileController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\ConnectionsController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\HashtagController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\MarketplaceDisputeController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\MarketplaceEscrowController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\MusicLibraryController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\PostEnhancementController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\ProfessionalProfileController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\RecommendationsController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\ReactionsController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\StoryEnhancementController;

Route::middleware(['api', 'auth:sanctum'])->prefix('api/pro-network')->group(function () {
    Route::get('/connections', [ConnectionsController::class, 'list']);
    Route::get('/connections/mutual/{user}', [ConnectionsController::class, 'mutual']);

    Route::get('/recommendations/people', [RecommendationsController::class, 'people']);
    Route::get('/recommendations/companies', [RecommendationsController::class, 'companies']);
    Route::get('/recommendations/groups', [RecommendationsController::class, 'groups']);
    Route::get('/recommendations/content', [RecommendationsController::class, 'content']);

    Route::get('/profile/professional', [ProfessionalProfileController::class, 'show']);
    Route::post('/profile/professional', [ProfessionalProfileController::class, 'update']);

    Route::get('/company/{company}', [CompanyProfileController::class, 'show']);
    Route::post('/company/{company}', [CompanyProfileController::class, 'update'])->middleware('can:update,company');

    Route::post('/marketplace/orders/{order}/escrow/open', [MarketplaceEscrowController::class, 'open']);
    Route::post('/marketplace/escrow/{escrow}/release', [MarketplaceEscrowController::class, 'release']);
    Route::post('/marketplace/escrow/{escrow}/refund', [MarketplaceEscrowController::class, 'refund']);

    Route::post('/marketplace/orders/{order}/disputes', [MarketplaceDisputeController::class, 'store']);
    Route::get('/marketplace/disputes/{dispute}', [MarketplaceDisputeController::class, 'show']);
    Route::post('/marketplace/disputes/{dispute}/reply', [MarketplaceDisputeController::class, 'reply']);
    Route::post('/marketplace/disputes/{dispute}/resolve', [MarketplaceDisputeController::class, 'resolve'])
        ->middleware('can:resolve,dispute');

    Route::post('/stories', [StoryEnhancementController::class, 'store']);
    Route::get('/stories/{story}/viewers', [StoryEnhancementController::class, 'viewers']);

    Route::post('/posts/polls', [PostEnhancementController::class, 'storePoll']);
    Route::post('/posts/polls/{poll}/vote', [PostEnhancementController::class, 'votePoll']);
    Route::post('/posts/threads', [PostEnhancementController::class, 'storeThread']);
    Route::post('/posts/reshare', [PostEnhancementController::class, 'reshare']);
    Route::post('/posts/celebrate', [PostEnhancementController::class, 'storeCelebrate']);

    Route::post('/reactions', [ReactionsController::class, 'react']);
    Route::delete('/reactions', [ReactionsController::class, 'unreact']);
    Route::post('/reactions/dislike', [ReactionsController::class, 'dislike']);
    Route::delete('/reactions/dislike', [ReactionsController::class, 'undislike']);
    Route::get('/profiles/{user}/reaction-score', [ReactionsController::class, 'profileScore']);

    Route::get('/hashtags', [HashtagController::class, 'index']);
    Route::post('/hashtags/search', [HashtagController::class, 'search']);

    Route::get('/music-library', [MusicLibraryController::class, 'index']);
    Route::post('/music-library/search', [MusicLibraryController::class, 'search']);
});
