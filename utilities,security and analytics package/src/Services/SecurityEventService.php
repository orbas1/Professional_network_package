<?php

namespace ProNetwork\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use ProNetwork\Models\SecurityEvent;

class SecurityEventService
{
    public function logEvent(?int $userId, string $event, array $context = []): SecurityEvent
    {
        $context = config('pro_network_utilities_security_analytics.security.gdpr_logging') ? $context : [];
        return SecurityEvent::create([
            'user_id' => $userId,
            'ip' => request()->ip(),
            'event' => $event,
            'context' => $context,
        ]);
    }

    public function tooManyAttempts(string $key): bool
    {
        $max = (int) config('pro_network_utilities_security_analytics.security.brute_force.max_attempts');
        return Cache::get($this->attemptKey($key), 0) >= $max;
    }

    public function incrementAttempts(string $key): void
    {
        $cacheKey = $this->attemptKey($key);
        $decay = (int) config('pro_network_utilities_security_analytics.security.brute_force.decay_minutes');
        Cache::add($cacheKey, 0, now()->addMinutes($decay));
        Cache::increment($cacheKey);
    }

    public function clearAttempts(string $key): void
    {
        Cache::forget($this->attemptKey($key));
    }

    protected function attemptKey(string $key): string
    {
        return 'pro_network_security_attempts_'.$key;
    }
}
