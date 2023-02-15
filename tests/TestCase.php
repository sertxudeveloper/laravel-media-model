<?php

namespace SertxuDeveloper\Media\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as Orchestra;
use SertxuDeveloper\Media\MediaServiceProvider;

class TestCase extends Orchestra
{
    /**
     * Define environment setup.
     *
     * @param  Application  $app
     */
    public function getEnvironmentSetUp($app): void {
        $app['config']->set('media.max_file_size', 0.5 * 1024 * 1024); // 0.5MB
    }

    /**
     * Define database migrations.
     */
    protected function defineDatabaseMigrations(): void {
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Get package providers.
     *
     * @param  Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array {
        return [
            MediaServiceProvider::class,
        ];
    }
}
