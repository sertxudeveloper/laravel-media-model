<?php

namespace SertxuDeveloper\Media\Exceptions;

use Exception;

class UploadedFileWriteException extends Exception
{
    public static function cannotMoveTemporaryFile(string $getTmpPath, string $destinationPath): static
    {
        return new static("Cannot move temporary file from `$getTmpPath` to `$destinationPath`");
    }

    /**
     * @param  string  $url The url that was given
     */
    public static function cannotWriteTemporaryFile(string $url): static
    {
        return new static("Cannot write temporary file for `$url`");
    }
}
