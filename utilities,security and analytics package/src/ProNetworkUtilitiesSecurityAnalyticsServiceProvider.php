<?php

namespace ProNetwork;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use ProNetwork\Services\AnalyticsService;
use ProNetwork\Services\AgeVerificationService;
use ProNetwork\Services\ConnectionService;
use ProNetwork\Services\EscrowService;
use ProNetwork\Services\HashtagService;
use ProNetwork\Services\ModerationService;
use ProNetwork\Services\NewsletterService;
use ProNetwork\Services\ReactionService;
use ProNetwork\Services\RecommendationService;
use ProNetwork\Services\SecurityEventService;
use ProNetwork\Services\StorageService;
use ProNetwork\Services\ProfileService;
use ProNetwork\Services\StoryService;

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
        $this->app->singleton(EscrowService::class);
        $this->app->singleton(HashtagService::class);
        $this->app->singleton(ReactionService::class);
        $this->app->singleton(ProfileService::class);
        $this->app->singleton(StoryService::class);
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/pro_network_utilities_security_analytics.php' => config_path('pro_network_utilities_security_analytics.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/pro-network'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/pro-network'),
        ], 'lang');

        $this->loadRoutesFrom(__DIR__.'/../routes.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'pro-network');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'pro-network');

        Blade::componentNamespace('ProNetwork\\View\\Components', 'pro-network');
    }
}
