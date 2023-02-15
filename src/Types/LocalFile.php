<?php

namespace SertxuDeveloper\Media\Types;

/**
 * Class LocalFile
 */
class LocalFile
{
    /**
     * Create a new instance.
     */
    public function __construct(
        protected string $path,
        protected string $disk,
    ) {
    }

    /**
     * Get the disk of the media.
     */
    public function getDisk(): string
    {
        return $this->disk;
    }

    /**
     * Get the media's filename.
     */
    public function getFilename(): string
    {
        return basename($this->path);
    }

    /**
     * Get the path of the media.
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
