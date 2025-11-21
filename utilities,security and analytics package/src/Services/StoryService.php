<?php

namespace ProNetwork\Services;

use ProNetwork\Models\StoryMetadata;

class StoryService
{
    public function attachMetadata(int $storyId, array $data): StoryMetadata
    {
        return StoryMetadata::updateOrCreate(['story_id' => $storyId], $data);
    }
}
