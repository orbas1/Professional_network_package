<?php

namespace ProNetwork\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsletterSubscription extends Model
{
    protected $table = 'pro_network_newsletter_subscriptions';
    protected $fillable = ['user_id','email','subscribed'];
    protected $casts = [
        'subscribed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model', \App\Models\User::class));
    }
}
