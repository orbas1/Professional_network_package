<?php

namespace ProNetwork\Services;

use ProNetwork\Models\ProfessionalProfile;

class ProfileService
{
    public function updateProfile(int $userId, array $data): ProfessionalProfile
    {
        return ProfessionalProfile::updateOrCreate(['user_id' => $userId], $data);
    }
}
