<?php

namespace ProNetwork\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoryMetadata extends Model
{
    protected $table = 'pro_network_story_metadata';
    protected $fillable = ['story_id','guests','music','links'];
    protected $casts = [
        'guests' => 'array',
        'music' => 'array',
        'links' => 'array',
    ];

    public function story(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Story::class, 'story_id');
    }
}
