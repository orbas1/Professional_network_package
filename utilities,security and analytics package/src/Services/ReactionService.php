<?php

namespace ProNetwork\Services;

use ProNetwork\Models\Reaction;
use ProNetwork\Models\ReactionAggregate;

class ReactionService
{
    public function react($model, int $userId, string $type = 'like'): Reaction
    {
        $reaction = Reaction::updateOrCreate([
            'reactable_id' => $model->getKey(),
            'reactable_type' => get_class($model),
            'user_id' => $userId,
        ], ['type' => $type]);

        $this->aggregate($model);
        return $reaction;
    }

    public function aggregate($model): ReactionAggregate
    {
        $likes = Reaction::where('reactable_id', $model->getKey())
            ->where('reactable_type', get_class($model))
            ->where('type', '!=', 'dislike')
            ->count();

        $dislikes = Reaction::where('reactable_id', $model->getKey())
            ->where('reactable_type', get_class($model))
            ->where('type', 'dislike')
            ->count();

        return ReactionAggregate::updateOrCreate([
            'reactable_id' => $model->getKey(),
            'reactable_type' => get_class($model),
        ], [
            'score' => $likes,
            'dislikes' => $dislikes,
        ]);
    }
}
