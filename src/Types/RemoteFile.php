<?php

namespace SertxuDeveloper\Media\Types;

/**
 * Class RemoteFile
 */
class RemoteFile
{
    /**
     * Create a new instance.
     *
     * @param  string  $url
     */
    public function __construct(
        protected string $url,
    ) {
    }

    /**
     * Get the media's filename.
     *
     * @return string
     */
    public function getFilename(): string {
        return basename($this->url);
    }

    /**
     * Get the media's URL.
     *
     * @return string
     */
    public function getUrl(): string {
        return $this->url;
    }
}
