<?php

namespace ProNetwork\Services;

use ProNetwork\Models\Connection;
use ProNetwork\Models\ProfessionalProfile;

class RecommendationService
{
    public function suggestConnections(int $userId, int $limit = 10)
    {
        $existing = Connection::where('user_id', $userId)->pluck('connection_id');
        return ProfessionalProfile::whereNotIn('user_id', $existing)
            ->orderByDesc('connections_count')
            ->take($limit)
            ->get();
    }
}
