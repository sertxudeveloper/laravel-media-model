<?php

namespace SertxuDeveloper\Media;

use SertxuDeveloper\Media\Interfaces\MediaInteraction;
use SertxuDeveloper\Media\Types\LocalFile;
use SertxuDeveloper\Media\Types\RemoteFile;
use SertxuDeveloper\Media\Types\TemporaryFile;

/**
 * Class MediaManagerFactory
 */
class MediaManagerFactory
{
    /**
     * Save the content to the disk and attach it to the model.
     *
     * @param  MediaInteraction  $model
     * @param  string  $content
     * @param  string  $originalName
     * @param  string  $toFolder
     * @param  string  $toDisk
     * @param  bool  $keepOriginalName
     * @return MediaManager
     *
     * @throws Exceptions\UploadedFileWriteException
     */
    public static function createFromContent(MediaInteraction $model, string $content, string $originalName, string $toFolder, string $toDisk, bool $keepOriginalName): MediaManager {
        $manager = app(MediaManager::class);

        return $manager
            ->setModel($model)
            ->setFile(new TemporaryFile($content, $originalName, $toFolder, $toDisk, $keepOriginalName));
    }

    /**
     * Attach a media to the model from a disk.
     *
     * @param  MediaInteraction  $model
     * @param  string  $path
     * @param  string  $disk
     * @return MediaManager
     */
    public static function createFromDisk(MediaInteraction $model, string $path, string $disk): MediaManager {
        $manager = app(MediaManager::class);

        return $manager
            ->setModel($model)
            ->setFile(new LocalFile($path, $disk));
    }

    /**
     * Attach a media to the model from a URL.
     *
     * @param  MediaInteraction  $model
     * @param  string  $url
     * @return MediaManager
     */
    public static function createFromUrl(MediaInteraction $model, string $url): MediaManager {
        $manager = app(MediaManager::class);

        return $manager
            ->setModel($model)
            ->setFile(new RemoteFile($url));
    }
}
