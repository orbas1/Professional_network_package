<?php

namespace ProNetwork\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ReactionAggregate extends Model
{
    protected $table = 'pro_network_reaction_aggregates';
    protected $fillable = ['reactable_id','reactable_type','score','dislikes'];

    public function reactable(): MorphTo
    {
        return $this->morphTo();
    }
}
