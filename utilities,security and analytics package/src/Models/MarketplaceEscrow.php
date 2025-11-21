<?php

namespace ProNetwork\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MarketplaceEscrow extends Model
{
    protected $table = 'pro_network_marketplace_escrows';
    protected $fillable = ['order_id','status','amount','delivery_type','held_at','released_at'];
    protected $casts = [
        'held_at' => 'datetime',
        'released_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(\App\Models\MarketplaceOrder::class, 'order_id');
    }

    public function milestones(): HasMany
    {
        return $this->hasMany(MarketplaceMilestone::class, 'escrow_id');
    }

    public function disputes(): HasMany
    {
        return $this->hasMany(MarketplaceDispute::class, 'escrow_id');
    }
}
