<?php

namespace ProNetwork\Services;

use ProNetwork\Models\MarketplaceDispute;
use ProNetwork\Models\MarketplaceEscrow;
use ProNetwork\Models\MarketplaceMilestone;

class EscrowService
{
    public function hold(int $orderId, float $amount, string $deliveryType = 'delivery'): MarketplaceEscrow
    {
        return MarketplaceEscrow::create([
            'order_id' => $orderId,
            'amount' => $amount,
            'status' => 'held',
            'delivery_type' => $deliveryType,
            'held_at' => now(),
        ]);
    }

    public function release(MarketplaceEscrow $escrow): MarketplaceEscrow
    {
        $escrow->update(['status' => 'released', 'released_at' => now()]);
        return $escrow;
    }

    public function createMilestone(MarketplaceEscrow $escrow, array $data): MarketplaceMilestone
    {
        return $escrow->milestones()->create($data);
    }

    public function openDispute(MarketplaceEscrow $escrow, int $userId, string $reason): MarketplaceDispute
    {
        return $escrow->disputes()->create([
            'raised_by' => $userId,
            'reason' => $reason,
        ]);
    }
}
