
# Attach media files to your models

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sertxudeveloper/laravel-media-model.svg)](https://packagist.org/packages/sertxudeveloper/laravel-media-model)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/sertxudeveloper/laravel-media-model/run-tests?label=tests)](https://github.com/sertxudeveloper/laravel-media-model/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/sertxudeveloper/laravel-media-model/Check%20&%20fix%20styling?label=code%20style)](https://github.com/sertxudeveloper/laravel-media-model/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/sertxudeveloper/laravel-media-model.svg)](https://packagist.org/packages/sertxudeveloper/laravel-media-model)

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

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider "SertxuDeveloper\Media\MediaServiceProvider"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-media-model-config"
```

## Usage

```php
$media = new SertxuDeveloper\Media();
echo $media->echoPhrase('Hello, SertxuDeveloper!');
```

## Testing

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
