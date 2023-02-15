<?php

namespace SertxuDeveloper\Media\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class TableCreatorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:create-table {name : The model class or the table name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration for the media table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        protected Filesystem $files
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     *
     * @throws FileNotFoundException
     */
    public function handle(): int
    {
        $class = Str::replace('/', '\\', $this->argument('name'));

        if (! class_exists($class)) {
            if (Str::endsWith($this->argument('name'), '_media')) {
                $name = Str::before($this->argument('name'), '_media');
            } else {
                $name = $this->argument('name');
            }

            $this->info("Creating a migration for the table {$name}_media");

            $this->files->put($this->getMigrationPath($name), $this->buildStub($name));

            $this->info('Migration created successfully!');

            return 0;
        }

        $this->info("Creating a migration for the media table for the $class model.");

        $name = (new $class)->getTable();
        $this->files->put($this->getMigrationPath($name), $this->buildStub($name));

        $this->info('Migration created successfully!');

        return 0;
    }

    /**
     * Build the migration stub.
     *
     *
     * @throws FileNotFoundException
     */
    protected function buildStub(string $name): string
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceModel($stub, $name);
    }

    /**
     * Get the destination path.
     */
    protected function getMigrationPath(string $name): string
    {
        return database_path('migrations/'.date('Y_m_d_His')."_create_{$name}_media_table.php");
    }

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return __DIR__.'/stubs/create_DummyModel_table.php.stub';
    }

    /**
     * Replace the class name for the given stub.
     */
    protected function replaceModel(string $stub, string $name): string
    {
        return str_replace(['DummyModel', '{{ model }}', '{{model}}'], "{$name}_media", $stub);
    }
}
