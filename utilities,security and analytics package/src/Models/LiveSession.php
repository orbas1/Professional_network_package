<?php

namespace ProNetwork\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LiveSession extends Model
{
    protected $table = 'pro_network_live_sessions';
    protected $fillable = ['user_id','title','guests','likes','donations','record_to_story'];
    protected $casts = [
        'guests' => 'array',
        'record_to_story' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model', \App\Models\User::class));
    }
}
