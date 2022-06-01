<?php

namespace SertxuDeveloper\Media;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use SertxuDeveloper\Media\Exceptions\InvalidUrlException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait HasMedia {

    protected string $media = Media::class;

    protected string $mediaTable;

    public function __construct() {
        parent::__construct();

        if ($this->mediaTable) {
            $this->media = new $this->media;
            $this->media->setTable($this->mediaTable);
        }
    }

    public function media(): HasMany {
        return $this->hasMany($this->media);
    }

    public function addMedia(string|UploadedFile $file) {
        return app(MediaManagerFactory::class)->create($this, $file);
    }

    public function addMediaFromDisk(string $path, string $disk = null) {
        return app(MediaManagerFactory::class)->createFromDisk($this, $path, $disk ?: config('filesystems.default'));
    }

    /**
     * @throws InvalidUrlException
     */
    public function addMediaFromUrl(string $url) {
        if (!Str::startsWith($url, ['http://', 'https://'])) {
            throw InvalidUrlException::doesNotStartWithProtocol($url);
        }

        return app(MediaManagerFactory::class)->createFromUrl($this, $url);
    }
}
