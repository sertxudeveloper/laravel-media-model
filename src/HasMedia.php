<?php

namespace SertxuDeveloper\Media;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;
use SertxuDeveloper\Media\Exceptions\InvalidUrlException;

trait HasMedia
{
    protected string $media = Media::class;

    protected array $unattachedMedia = [];

    /**
     * The table associated with the media.
     */
    protected string $mediaTable = 'media';

    /**
     * Save the content to the disk and attach it to the model.
     */
    public function addMediaFromContent(string $content, string $originalName, string $toFolder, string $toDisk = null, bool $keepOriginalName = false): MediaManager {
        return app(MediaManagerFactory::class)
            ->createFromContent($this, $content, $originalName, $toFolder, $toDisk ?: config('filesystems.default'),
                $keepOriginalName);
    }

    /**
     * Attach a media to the model from a disk.
     */
    public function addMediaFromDisk(string $path, string $disk = null): MediaManager {
        return app(MediaManagerFactory::class)
            ->createFromDisk($this, $path, $disk ?: config('filesystems.default'));
    }

    /**
     * Attach a media to the model from a URL.
     *
     *
     * @throws InvalidUrlException
     */
    public function addMediaFromUrl(string $url): MediaManager {
        if (!Str::startsWith($url, ['http://', 'https://'])) {
            throw InvalidUrlException::doesNotStartWithProtocol($url);
        }

        return app(MediaManagerFactory::class)
            ->createFromUrl($this, $url);
    }

    /**
     * Get the model that will be used to store the media.
     */
    public function getMediaModel(): Media {
        $model = new $this->media;
        $model->setTable($this->getMediaTable());

        return $model;
    }

    /**
     * Get the media table for the relationship.
     */
    public function getMediaTable(): string {
        return $this->mediaTable;
    }

    /**
     * Check if the model has defined a custom media table.
     */
    public function hasCustomMediaTable(): bool {
        return $this->getMediaTable() !== $this->mediaTable;
    }

    /**
     * Get the medias attached to the model.
     */
    public function media(): HasMany|MorphMany {
        if (!$this->hasCustomMediaTable()) {
            return $this->morphMany($this->getMediaModel(), 'model');
        }

        return new HasMany($this->getMediaModel()->newQuery(), $this, 'model_id', $this->getKeyName());
    }

    /**
     * Prepare media for being attached once the model has been saved.
     */
    public function prepareToAttachMedia(Media $media): void {
        $this->unattachedMedia[$media->path] = $media;
    }

    /**
     * Process the media that has been attached to the model.
     */
    public function processUnattachedMedia(callable $callable): void {
        foreach ($this->unattachedMedia as $item) {
            $callable($item);

            unset($this->unattachedMedia[$item->path]);
        }
    }
}
