<?php

namespace SertxuDeveloper\Media\Types;

/**
 * Class LocalFile
 *
 * @package SertxuDeveloper\Media
 */
class LocalFile {

    /**
     * Create a new instance.
     *
     * @param string $path
     * @param string $disk
     */
    public function __construct(
        protected string $path,
        protected string $disk,
    ) {}

    /**
     * Get the disk of the media.
     *
     * @return string
     */
    public function getDisk(): string {
        return $this->disk;
    }

    /**
     * Get the media's filename.
     *
     * @return string
     */
    public function getFilename(): string {
        return basename($this->path);
    }

    /**
     * Get the path of the media.
     *
     * @return string
     */
    public function getPath(): string {
        return $this->path;
    }
}
