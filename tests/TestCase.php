<?php

namespace SertxuDeveloper\Media\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as Orchestra;
use SertxuDeveloper\Media\MediaServiceProvider;

class TestCase extends Orchestra {

    /**
     * Define environment setup.
     *
     * @param Application $app
     *
     * @return void
     */
    public function getEnvironmentSetUp($app): void {

    }

    /**
     * Define database migrations.
     *
     * @return void
     */
    protected function defineDatabaseMigrations(): void {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadMigrationsFrom(__DIR__ . '/tests/database/migrations');
    }

    /**
     * Get package providers.
     *
     * @param Application $app
     *
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array {
        return [
            MediaServiceProvider::class,
        ];
    }
}
