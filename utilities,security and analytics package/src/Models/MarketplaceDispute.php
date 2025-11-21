<?php

namespace ProNetwork\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarketplaceDispute extends Model
{
    protected $table = 'pro_network_marketplace_disputes';
    protected $fillable = ['escrow_id','raised_by','reason','status'];

    public function escrow(): BelongsTo
    {
        return $this->belongsTo(MarketplaceEscrow::class, 'escrow_id');
    }

    public function raiser(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model', \App\Models\User::class), 'raised_by');
    }
}
