<?php

namespace SertxuDeveloper\Media\Types;

use Illuminate\Support\Str;
use SertxuDeveloper\Media\Exceptions\UploadedFileWriteException;

/**
 * Class TemporaryFile
 *
 * @package SertxuDeveloper\Media
 */
class TemporaryFile {

    protected string $tmpPath = '';

    /**
     * The cache copy of the file's hash name.
     *
     * @var string
     */
    protected string $hashName = '';

    /**
     * Create a new UploadedFile instance.
     *
     * @param string $content
     * @param string $originalName
     * @param string $toFolder
     * @param string $toDisk
     * @param bool $keepOriginalName
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
     *
     * @return string
     */
    public function getDisk(): string {
        return $this->toDisk;
    }

    /**
     * Get the media's filename.
     *
     * @return string
     */
    public function getFilename(): string {
        return $this->originalName;
    }

    /**
     * Get the path of the media.
     *
     * @return string
     */
    public function getPath(): string {
        if ($this->keepOriginalName) {
            return $this->toFolder . DIRECTORY_SEPARATOR . $this->getFilename();
        }

        return $this->toFolder . DIRECTORY_SEPARATOR . $this->hashName();
    }

    /**
     * Get the temporary path of the media.
     *
     * @return string
     */
    public function getTmpPath(): string {
        return $this->tmpPath;
    }

    /**
     * Get the hash name of the media.
     *
     * @return string
     */
    protected function hashName(): string {
        if ($this->hashName) return $this->hashName;

        $this->hashName = Str::random(40) . '.' . pathinfo($this->originalName, PATHINFO_EXTENSION);

        return $this->hashName;
    }
}
