<?php

namespace SertxuDeveloper\Media\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use SertxuDeveloper\Media\Media;
use SertxuDeveloper\Media\MediaManager;

interface MediaInteraction
{
    public function addMediaFromContent(string $content, string $originalName, string $toFolder, string $toDisk = null, bool $keepOriginalName = false): MediaManager;

    public function addMediaFromDisk(string $path, string $disk = null): MediaManager;

    public function addMediaFromUrl(string $url): MediaManager;

    public function getMediaModel(): Media;

    public function getMediaTable(): string;

    public function media(): HasMany|MorphMany;
}
