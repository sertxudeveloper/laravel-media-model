
<p align="center"><img src="/art/socialcard.png" alt="Laravel Media Model by Sertxu Developer"></p>

# Attach media files to your models

![](https://img.shields.io/github/v/release/sertxudeveloper/laravel-media-model) ![](https://github.com/sertxudeveloper/laravel-media-model/actions/workflows/run-tests.yml/badge.svg) ![](https://img.shields.io/github/license/sertxudeveloper/laravel-media-model) ![](https://img.shields.io/librariesio/github/sertxudeveloper/laravel-media-model) ![](https://img.shields.io/github/repo-size/sertxudeveloper/laravel-media-model) ![](https://img.shields.io/packagist/dt/sertxudeveloper/laravel-media-model) ![](https://img.shields.io/github/issues/sertxudeveloper/laravel-media-model) ![](https://img.shields.io/packagist/php-v/sertxudeveloper/laravel-media-model) [![Codecov Test coverage](https://img.shields.io/codecov/c/github/sertxudeveloper/laravel-media-model)](https://app.codecov.io/gh/sertxudeveloper/laravel-media-model)

When developing an app, you may want to attach media files to your models, such as images, videos, or documents.
With this package, you can easily attach media files to your models.

The media files are stored in the specified disk and are related to the model using your database.<br>

You can link local media files or remote ones without needing to download them to your server.

The main difference between this package and the other ones available is that this package allows you to relate media files to your models using a custom table per model.

Allowing you to manage the media tables per model instead of one unique media table for all models.

## Installation

You can install the package via composer:

```bash
composer require sertxudeveloper/laravel-media-model
```

Next, you should publish the config file and the migrations:

```bash
php artisan vendor:publish --provider "SertxuDeveloper\Media\MediaServiceProvider"
```

After that, you can run the new migrations:

```bash
php artisan migrate
```

Finally, you can start using the package!

## Usage

You should modify the model that you want to attach media files to.

```php
<?php

namespace App\Models;

use SertxuDeveloper\Media\HasMedia;
use SertxuDeveloper\Media\Interfaces\MediaInteraction;

class Message extends Model implements MediaInteraction
{
    use HasMedia;
}
```

As you can see, the model has been modified to use the `HasMedia` trait.
Also, the model must implement the `MediaInteraction` interface.

### Separated media tables

If you want to use a separated media table for each model, you should modify the model that you want to attach media files to.

```php
<?php

namespace App\Models;

use SertxuDeveloper\Media\HasMedia;
use SertxuDeveloper\Media\Interfaces\MediaInteraction;

class Message extends Model implements MediaInteraction
{
    use HasMedia;

    public function getMediaTable(): string
    {
        return 'messages_media';
    }
}
```

The specified table needs to be created, you can create it manually or use one of the following command.

```bash
php artisan media:create-table messages_media
```

or

```bash
php artisan media:create-table messages
```

or

```bash
php artisan media:create-table "App\Models\Message"
```

### Attaching media files

Once you configured the model, you can attach media files to it. For example:

> **Note**<br>
> If you don't specify a disk, the default disk will be used.

```php
<?php

$message = Message::find(1);

$message->addMediaFromDisk(path: '/images/image.jpg', disk: 'public');
```

You can also attach a remote file:

> **Note**<br>
> This will not download the file to your server. It will only add the remote file path to the database.

```php
<?php

$message = Message::find(1);

$message->addMediaFromUrl('https://www.sertxudeveloper.com/assets/logo.svg');
```

Also, you can attach a file content, this will save the file to the disk and attach it to the model.

> **Note**<br>
> This is useful if you get the content of a file from an external source, like as an email attachment read by a mail parser.

```php
<?php

$message = Message::find(1);

$message->addMediaFromContent(
  content: file_get_contents('/tmp/tmpA3ds2'),
  originalName: 'image.jpg',
  toFolder: 'avatars',
  toDisk: 'public'
);
```

## Testing

This package contains tests, you can run them using the following command:

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](https://github.com/sertxudeveloper/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Sergio Peris](https://github.com/sertxudev)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

<br><br>
<p align="center">Copyright © 2022 Sertxu Developer</p>
