<?php

namespace ProNetwork\Services;

use Illuminate\Support\Str;
use ProNetwork\Models\BadWord;
use ProNetwork\Models\ModerationQueue;

class ModerationService
{
    public function enqueue($model, string $reason, array $flags = []): ModerationQueue
    {
        return ModerationQueue::create([
            'moderatable_id' => $model->getKey(),
            'moderatable_type' => get_class($model),
            'reason' => $reason,
            'status' => 'pending',
            'flags' => $flags,
        ]);
    }

    public function containsBadWords(string $content): bool
    {
        $phrases = BadWord::pluck('phrase');
        foreach ($phrases as $phrase) {
            if (Str::contains(Str::lower($content), Str::lower($phrase))) {
                return true;
            }
        }
        return false;
    }
}
