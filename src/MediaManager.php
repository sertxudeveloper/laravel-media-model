<?php

namespace SertxuDeveloper\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use SertxuDeveloper\Media\Exceptions\FileDoesNotExistException;
use SertxuDeveloper\Media\Exceptions\FileTooBigException;
use SertxuDeveloper\Media\Exceptions\UnknownTypeException;
use SertxuDeveloper\Media\Exceptions\UploadedFileWriteException;
use SertxuDeveloper\Media\Interfaces\MediaInteraction;
use SertxuDeveloper\Media\Types\LocalFile;
use SertxuDeveloper\Media\Types\RemoteFile;
use SertxuDeveloper\Media\Types\TemporaryFile;

/**
 * Class MediaManager
 */
class MediaManager
{
    /** Model where the media is attached */
    protected ?Model $model = null;

    /** The media file */
    protected TemporaryFile|RemoteFile|LocalFile|null $file = null;

    /** Filename of the media */
    protected string $filename = '';

    /** The path where the media is stored */
    protected string $pathToFile = '';

    /**
     * Attach an existing file to the media.
     *
     * @return $this
     *
     * @throws UnknownTypeException
     */
    public function setFile(TemporaryFile|RemoteFile|LocalFile $file): self {
        $this->file = $file;

        if ($file instanceof TemporaryFile) {
            $this->pathToFile = $file->getPath();
            $this->setFilename($file->getFilename());

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

    /**
     * Set the filename of the media.
     *
     * @return $this
     */
    public function setFilename(string $filename): self {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Attach the media to a model.
     *
     * @return $this
     */
    public function setModel(Model $model): self {
        $this->model = $model;

        return $this;
    }

    /**
     * Save the media to the media collection.
     *
     *
     * @throws FileDoesNotExistException|FileTooBigException|UnknownTypeException|UploadedFileWriteException
     */
    public function toMediaCollection(string $collection = 'default'): Media {
        if ($this->file instanceof RemoteFile) {
            return $this->toMediaCollectionFromRemoteFile($collection);
        }

        if ($this->file instanceof TemporaryFile) {
            return $this->toMediaCollectionFromTemporaryFile($collection);
        }

        if ($this->file instanceof LocalFile) {
            return $this->toMediaCollectionFromLocalFile($collection);
        }

        throw new UnknownTypeException;
    }

    /**
     * Save the local media to the media collection.
     *
     *
     * @throws FileDoesNotExistException|FileTooBigException
     */
    public function toMediaCollectionFromLocalFile(string $collection = 'default'): Media {
        /** @var Media $media */
        $media = $this->model->getMediaModel();

        $media->filename = $this->filename;
        $media->path = $this->pathToFile;
        $media->disk = $this->file->getDisk();

        /** Check if the file exists */
        if (!Storage::disk($media->disk)->exists($this->pathToFile)) {
            throw new FileDoesNotExistException;
        }

        if (Storage::disk($media->disk)->size($this->pathToFile) > config('media.max_file_size')) {
            throw new FileTooBigException;
        }

        $media->collection = $collection;

        $media->mime_type = Storage::disk($media->disk)->mimeType($this->pathToFile);
        $media->size = Storage::disk($media->disk)->size($this->pathToFile);

        $this->attachMedia($media);

        return $media;
    }

    /**
     * @return void
     */
    protected function attachMedia(Media $media) {
        if (!$this->model->exists) {
            $this->model->prepareToAttachMedia($media);

            $this->model->created(function ($model) {
                $model->processUnattachedMedia(function (Media $media) use ($model) {
                    $this->processMedia($model, $media);
                });
            });

            return;
        }

        $this->processMedia($this->model, $media);
    }

    protected function processMedia(MediaInteraction $model, Media $media): void {
        if (!$media->getConnectionName()) {
            $media->setConnection($model->getConnectionName());
        }

        $model->media()->save($media);
    }

    /**
     * Save the remote media to the media collection.
     */
    protected function toMediaCollectionFromRemoteFile(string $collection): Media {
        /** @var Media $media */
        $media = $this->model->getMediaModel();

        $media->filename = $this->filename;
        $media->path = $this->pathToFile;

        $media->collection = $collection;
        $media->disk = 'external';

        $this->attachMedia($media);

        return $media;
    }

    /**
     * Save the temporary media to the media collection.
     *
     *
     * @throws FileDoesNotExistException
     * @throws FileTooBigException
     * @throws UploadedFileWriteException
     */
    protected function toMediaCollectionFromTemporaryFile(string $collection): Media {
        $destinationPath = Storage::disk($this->file->getDisk())->path($this->pathToFile);

        if (filesize($this->file->getTmpPath()) > config('media.max_file_size')) {
            throw new FileTooBigException;
        }

        // Check if the folder exists, if not create it
        if (!is_dir(dirname($destinationPath))) {
            mkdir(dirname($destinationPath), recursive: true);
        }

        if (!rename($this->file->getTmpPath(), $destinationPath)) {
            throw UploadedFileWriteException::cannotMoveTemporaryFile($this->file->getTmpPath(), $destinationPath);
        }

        return $this->toMediaCollectionFromLocalFile($collection);
    }
}
