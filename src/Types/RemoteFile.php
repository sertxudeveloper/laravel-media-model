<?php

namespace SertxuDeveloper\Media\Types;

/**
 * Class RemoteFile
 */
class RemoteFile
{
    /**
     * Create a new instance.
     */
    public function __construct(
        protected string $url,
    ) {
    }

    /**
     * Get the media's filename.
     */
    public function getFilename(): string
    {
        return basename($this->url);
    }

    /**
     * Get the media's URL.
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}
