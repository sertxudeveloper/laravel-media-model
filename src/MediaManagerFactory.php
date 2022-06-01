<?php

namespace SertxuDeveloper\Media;

use Illuminate\Database\Eloquent\Model;
use SertxuDeveloper\Media\Types\LocalFile;
use SertxuDeveloper\Media\Types\RemoteFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class MediaManagerFactory
 * @package SertxuDeveloper\Media
 */
class MediaManagerFactory {

    static public function create(Model $model, string|UploadedFile $file): MediaManager {
        $manager = app(MediaManager::class);

        return $manager
            ->setModel($model)
            ->setFile($file);
    }

    static public function createFromDisk(Model $model, string $path, string $disk): MediaManager {
        $manager = app(MediaManager::class);

        return $manager
            ->setModel($model)
            ->setFile(new LocalFile($path, $disk));
    }

    static public function createFromUrl(Model $model, string $url): MediaManager {
        $manager = app(MediaManager::class);

        return $manager
            ->setModel($model)
            ->setFile(new RemoteFile($url));
    }

}
