<?php

namespace ProNetwork\Services;

use Illuminate\Support\Facades\Cache;
use ProNetwork\Models\Connection;

class ConnectionService
{
    public function addConnection(int $userId, int $connectionId, int $degree = 1): Connection
    {
        $connection = Connection::updateOrCreate([
            'user_id' => $userId,
            'connection_id' => $connectionId,
        ], ['degree' => $degree]);

        Cache::forget($this->cacheKey($userId));
        return $connection;
    }

    public function network(int $userId)
    {
        return Cache::remember($this->cacheKey($userId), 300, function () use ($userId) {
            return Connection::where('user_id', $userId)->with('connection')->get();
        });
    }

    protected function cacheKey(int $userId): string
    {
        return 'pro_network_connections_'.$userId;
    }
}
