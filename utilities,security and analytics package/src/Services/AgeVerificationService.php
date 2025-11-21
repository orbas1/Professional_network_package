<?php

namespace ProNetwork\Services;

use ProNetwork\Models\AgeVerification;

class AgeVerificationService
{
    public function requestVerification(int $userId): AgeVerification
    {
        return AgeVerification::updateOrCreate(['user_id' => $userId], ['status' => 'pending']);
    }

    public function markVerified(int $userId, ?string $reference = null): AgeVerification
    {
        return AgeVerification::updateOrCreate(['user_id' => $userId], [
            'status' => 'verified',
            'provider_reference' => $reference,
        ]);
    }

    public function status(int $userId): string
    {
        return AgeVerification::where('user_id', $userId)->value('status') ?? 'pending';
    }
}
