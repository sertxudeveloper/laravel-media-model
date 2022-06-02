<?php

namespace SertxuDeveloper\Media;

use Illuminate\Support\ServiceProvider;
use SertxuDeveloper\Media\Console\TableCreatorCommand;

class MediaServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void {
        $this->registerPublishables();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void {
        $this->mergeConfigFrom(__DIR__ . '/../config/media.php', 'media');

        $this->registerCommands();
    }

    /**
     * Register the package commands.
     *
     * @return void
     */
    protected function registerCommands(): void {
        $this->app->bind('command.media:create-table', TableCreatorCommand::class);

        $this->commands([
            TableCreatorCommand::class,
        ]);
    }

    /**
     * Register the publishable resources.
     *
     * @return void
     */
    protected function registerPublishables(): void {
        $this->publishes([
            __DIR__ . '/../config/media.php' => config_path('media.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'migrations');
    }
}
