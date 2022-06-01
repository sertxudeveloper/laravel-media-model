<?php

namespace SertxuDeveloper\Media\Exceptions;

use Exception;

class InvalidUrlException extends Exception {

    /**
     * @param string $url The url that was given
     */
    static public function doesNotStartWithProtocol(string $url): static {
        return new static("Could not add the media `$url` because it doesn't start with http:// or https://");
    }
}
