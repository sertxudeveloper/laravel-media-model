<?php

namespace SertxuDeveloper\Media\Exceptions;

use Exception;

class UploadedFileWriteException extends Exception {

    /**
     * @param string $getTmpPath
     * @param string $destinationPath
     * @return static
     */
    static public function cannotMoveTemporaryFile(string $getTmpPath, string $destinationPath): static {
        return new static("Cannot move temporary file from `$getTmpPath` to `$destinationPath`");
    }

    /**
     * @param string $url The url that was given
     */
    static public function cannotWriteTemporaryFile(string $url): static {
        return new static("Cannot write temporary file for `$url`");
    }
}
