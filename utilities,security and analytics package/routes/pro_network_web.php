<?php

use Illuminate\Support\Facades\Route;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\CompanyProfileController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\ConnectionsController;
use ProNetworkUtilitiesSecurityAnalytics\Http\Controllers\ProfessionalProfileController;

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
});
