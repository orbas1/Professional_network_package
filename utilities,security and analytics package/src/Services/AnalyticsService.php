<?php

namespace ProNetwork\Services;

use Illuminate\Support\Facades\Log;
use ProNetwork\Models\AnalyticsEvent;
use Throwable;

class AnalyticsService
{
    public function track(string $event, array $properties = [], $user = null): AnalyticsEvent
    {
        $payload = ['event' => $event, 'properties' => $properties];
        if ($user) {
            $payload['user_id'] = $user->id ?? $user;
        }

        $record = AnalyticsEvent::create($payload);

        if (config('pro_network_utilities_security_analytics.analytics.forward')) {
            Log::channel(config('pro_network_utilities_security_analytics.analytics.driver', 'stack'))
                ->info('pro-network-analytics', $payload);
        }

        return $record;
    }
}
