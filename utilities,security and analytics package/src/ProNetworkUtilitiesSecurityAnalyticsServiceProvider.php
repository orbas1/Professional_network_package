<?php

namespace ProNetwork;

use Illuminate\Support\ServiceProvider;
use ProNetwork\Services\AccountTypeService;
use ProNetwork\Services\AgeVerificationService;
use ProNetwork\Services\AnalyticsService;
use ProNetwork\Services\ChatEnhancementService;
use ProNetwork\Services\ConnectionService;
use ProNetwork\Services\HashtagService;
use ProNetwork\Services\InviteContributorsService;
use ProNetwork\Services\LiveStreamingWrapper;
use ProNetwork\Services\MarketplaceEscrowDomain;
use ProNetwork\Services\ModerationService;
use ProNetwork\Services\MultiLanguageService;
use ProNetwork\Services\MusicLibraryService;
use ProNetwork\Services\NewsletterService;
use ProNetwork\Services\NotificationsWrapper;
use ProNetwork\Services\PostEnhancementService;
use ProNetwork\Services\ProfileEnhancementService;
use ProNetwork\Services\ReactionsService;
use ProNetwork\Services\RecommendationService;
use ProNetwork\Services\SearchTagsDomain;
use ProNetwork\Services\SearchUpgradeService;
use ProNetwork\Services\SecurityEventService;
use ProNetwork\Services\StorageService;
use ProNetwork\Services\StoryEnhancementService;

class ProNetworkUtilitiesSecurityAnalyticsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/pro_network_utilities_security_analytics.php', 'pro_network_utilities_security_analytics');

        $this->app->singleton(AnalyticsService::class);
        $this->app->singleton(SecurityEventService::class);
        $this->app->singleton(ModerationService::class);
        $this->app->singleton(StorageService::class);
        $this->app->singleton(AgeVerificationService::class);
        $this->app->singleton(NewsletterService::class);
        $this->app->singleton(ConnectionService::class);
        $this->app->singleton(RecommendationService::class);
        $this->app->singleton(MarketplaceEscrowDomain::class);
        $this->app->singleton(HashtagService::class);
        $this->app->singleton(ReactionsService::class);
        $this->app->singleton(ProfileEnhancementService::class);
        $this->app->singleton(StoryEnhancementService::class);
        $this->app->singleton(PostEnhancementService::class);
        $this->app->singleton(MusicLibraryService::class);
        $this->app->singleton(AccountTypeService::class);
        $this->app->singleton(SearchUpgradeService::class);
        $this->app->singleton(ChatEnhancementService::class);
        $this->app->singleton(LiveStreamingWrapper::class);
        $this->app->singleton(NotificationsWrapper::class);
        $this->app->singleton(SearchTagsDomain::class);
        $this->app->singleton(InviteContributorsService::class);
        $this->app->singleton(MultiLanguageService::class);
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/pro_network_utilities_security_analytics.php' => config_path('pro_network_utilities_security_analytics.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'migrations');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
