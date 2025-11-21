<?php

namespace ProNetwork\Services;

use Illuminate\Database\Eloquent\Model;
use ProNetwork\Models\ProfileReactionScore;
use ProNetwork\Models\Reaction;
use ProNetwork\Models\ReactionAggregate;
use ProNetwork\Support\Enums\ReactionType;

class ReactionsService
{
    public function react(Model $reactable, int $userId, ReactionType $type): Reaction
    {
        $reaction = Reaction::updateOrCreate([
            'reactable_id' => $reactable->getKey(),
            'reactable_type' => $reactable->getMorphClass(),
            'user_id' => $userId,
        ], [
            'type' => $type,
            'weight' => $type === ReactionType::DISLIKE ? -1 : 1,
        ]);

        $this->aggregate($reactable);

        if (method_exists($reactable, 'user_id')) {
            $this->updateProfileScore($reactable->user_id ?? null, $type);
        }

        return $reaction;
    }

    public function remove(Model $reactable, int $userId): void
    {
        Reaction::where([
            'reactable_id' => $reactable->getKey(),
            'reactable_type' => $reactable->getMorphClass(),
            'user_id' => $userId,
        ])->delete();

        $this->aggregate($reactable);
    }

    public function aggregate(Model $reactable): void
    {
        $reactions = Reaction::where([
            'reactable_id' => $reactable->getKey(),
            'reactable_type' => $reactable->getMorphClass(),
        ])->get();

        $counts = $reactions->groupBy('type')->map->count();
        $dislikes = $counts[ReactionType::DISLIKE->value] ?? 0;

        ReactionAggregate::updateOrCreate([
            'reactable_id' => $reactable->getKey(),
            'reactable_type' => $reactable->getMorphClass(),
        ], [
            'counts' => $counts,
            'dislikes' => $dislikes,
        ]);
    }

    public function updateProfileScore(?int $userId, ReactionType $type): void
    {
        if (!$userId) {
            return;
        }

        $score = ProfileReactionScore::firstOrCreate(['user_id' => $userId]);
        $breakdown = collect($score->reaction_breakdown ?? []);
        $breakdown[$type->value] = ($breakdown[$type->value] ?? 0) + 1;

        $score->update([
            'like_score' => $score->like_score + ($type === ReactionType::DISLIKE ? 0 : 1),
            'dislike_count' => $score->dislike_count + ($type === ReactionType::DISLIKE ? 1 : 0),
            'reaction_breakdown' => $breakdown,
        ]);
    }
}
