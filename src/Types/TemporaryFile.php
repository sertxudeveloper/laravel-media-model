<?php

namespace SertxuDeveloper\Media\Types;

use Illuminate\Support\Str;
use SertxuDeveloper\Media\Exceptions\UploadedFileWriteException;

/**
 * Class TemporaryFile
 */
class TemporaryFile
{
    protected string $tmpPath = '';

    /**
     * The cache copy of the file's hash name.
     */
    protected string $hashName = '';

    /**
     * Create a new instance.
     *
     *
     * @throws UploadedFileWriteException
     */
    public function __construct(
        string $content,
        protected string $originalName,
        protected string $toFolder,
        protected string $toDisk,
        protected bool $keepOriginalName,
    ) {
        $this->tmpPath = tempnam(sys_get_temp_dir(), 'tmp');

        if (file_put_contents($this->tmpPath, $content) === false) {
            throw UploadedFileWriteException::cannotWriteTemporaryFile($this->tmpPath);
        }
    }

    /**
     * Get the disk of the media.
     */
    public function getDisk(): string
    {
        return $this->toDisk;
    }

    /**
     * Get the media's filename.
     */
    public function getFilename(): string
    {
        return $this->originalName;
    }

    /**
     * Get the path of the media.
     */
    public function getPath(): string
    {
        if ($this->keepOriginalName) {
            return $this->toFolder.DIRECTORY_SEPARATOR.$this->getFilename();
        }

        return $this->toFolder.DIRECTORY_SEPARATOR.$this->hashName();
    }

    /**
     * Get the temporary path of the media.
     */
    public function getTmpPath(): string
    {
        return $this->tmpPath;
    }

    /**
     * Get the hash name of the media.
     */
    protected function hashName(): string
    {
        if ($this->hashName) {
            return $this->hashName;
        }

        $this->hashName = Str::random(40).'.'.pathinfo($this->originalName, PATHINFO_EXTENSION);

        return $this->hashName;
    }
}
