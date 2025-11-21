<?php

namespace ProNetwork\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InviteContribution extends Model
{
    protected $table = 'pro_network_invite_contributions';
    protected $fillable = ['user_id','post_id','status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model', \App\Models\User::class));
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Post::class);
    }
}
