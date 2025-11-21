<?php

namespace ProNetwork\Services;

use Illuminate\Support\Str;
use ProNetwork\Models\Hashtag;

class HashtagService
{
    public function extract(string $text): array
    {
        preg_match_all('/#(\w+)/u', $text, $matches);
        return array_map(fn($tag) => Str::lower($tag), $matches[1] ?? []);
    }

    public function syncTags($model, array $tags): void
    {
        $ids = [];
        foreach ($tags as $tag) {
            $record = Hashtag::firstOrCreate(['tag' => Str::lower($tag)]);
            $ids[] = $record->id;
        }
        $model->hashtags()->sync($ids);
    }
}
