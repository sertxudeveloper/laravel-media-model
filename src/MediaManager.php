<?php

namespace SertxuDeveloper\Media;

use Illuminate\Database\Eloquent\Model;
use SertxuDeveloper\Media\Exceptions\UnknownTypeException;
use SertxuDeveloper\Media\Types\LocalFile;
use SertxuDeveloper\Media\Types\RemoteFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class MediaManager
 *
 * @package SertxuDeveloper\Media
 *
 * @property Model|null $model
 * @property string|UploadedFile $file
 * @property string $filename
 * @property string $pathToFile
 */
class MediaManager {

    /** Model where the media is attached */
    protected ?Model $model = null;

    /** The media file */
    protected string|UploadedFile $file = '';

    /** Original filename of the media */
    protected string $filename = '';

    /** The path where the media is stored */
    protected string $pathToFile = '';

    /**
     *
     *
     * @param string|UploadedFile|RemoteFile|LocalFile $file
     * @return $this
     * @throws UnknownTypeException
     */
    public function setFile(string|UploadedFile|RemoteFile|LocalFile $file): self {
        $this->file = $file;

        if (is_string($file)) {
            $this->pathToFile = $file;
            $this->setFilename(pathinfo($file, PATHINFO_BASENAME));

            return $this;
        }

        if ($file instanceof UploadedFile) {
            $this->pathToFile = $file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename();
            $this->setFilename($file->getClientOriginalName());

            return $this;
        }

        if ($file instanceof RemoteFile) {
            $this->pathToFile = $file->getUrl();
            $this->setFilename($file->getFilename());

            return $this;
        }

        if ($file instanceof LocalFile) {
            $this->pathToFile = $file->getPath();
            $this->setFilename($file->getFilename());

            return $this;
        }

        throw new UnknownTypeException;
    }

    public function setFilename(string $filename): self {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Attach the media to a model
     *
     * @param Model $model
     * @return $this
     */
    public function setModel(Model $model): self {
        $this->model = $model;

        return $this;
    }
}
