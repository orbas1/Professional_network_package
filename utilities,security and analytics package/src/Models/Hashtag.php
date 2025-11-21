<?php

namespace ProNetwork\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Hashtag extends Model
{
    protected $table = 'pro_network_hashtags';
    protected $fillable = ['tag'];

    public function posts(): BelongsToMany
    {
        return $this->morphedByMany(\App\Models\Post::class, 'hashtaggable', 'pro_network_hashtaggables');
    }
}
