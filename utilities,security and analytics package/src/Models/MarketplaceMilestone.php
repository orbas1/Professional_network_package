<?php

namespace ProNetwork\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarketplaceMilestone extends Model
{
    protected $table = 'pro_network_marketplace_milestones';
    protected $fillable = ['escrow_id','title','amount','status','due_at'];
    protected $casts = [
        'due_at' => 'datetime',
    ];

    public function escrow(): BelongsTo
    {
        return $this->belongsTo(MarketplaceEscrow::class, 'escrow_id');
    }
}
