<?php

namespace SertxuDeveloper\Media\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as Orchestra;
use SertxuDeveloper\Media\MediaServiceProvider;

class TestCase extends Orchestra {

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn(string $modelName) => 'SertxuDeveloper\\Media\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

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
        dd('defineDatabaseMigrations', __DIR__);
//        $this->loadLaravelMigrations();
//        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
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
