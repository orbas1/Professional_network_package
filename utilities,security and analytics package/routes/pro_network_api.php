<?php

use Illuminate\Support\Facades\Route;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\CompanyProfileController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\ConnectionsController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\MarketplaceDisputeController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\MarketplaceEscrowController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\ProfessionalProfileController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\RecommendationsController;

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
});
