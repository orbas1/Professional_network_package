<?php

namespace ProNetwork\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ModerationQueue extends Model
{
    protected $table = 'pro_network_moderation_queue';
    protected $fillable = ['moderatable_id','moderatable_type','reason','status','flags'];
    protected $casts = [
        'flags' => 'array',
    ];

    public function moderatable(): MorphTo
    {
        return $this->morphTo();
    }
}
