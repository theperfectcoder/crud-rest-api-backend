<?php

namespace App\Console\Commands;

use App\Console\Commands\CustomGeneratorCommand;
use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;

class CustomModelMakeCommand extends CustomGeneratorCommand
{
    use CreatesMatchingTest;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:custom-model';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     */
    protected static $defaultName = 'make:custom-model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Eloquent model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected string $type = 'Model';

    /**
     * Execute the console command.
     *
     * @return bool
     * @throws FileNotFoundException
     */
    public function handle(): bool
    {
        if (parent::handle() === false) {
            return false;
        }

        $this->createMigration();

        return true;
    }

    /**
     * Create a migration file for the model.
     *
     * @return void
     */
    protected function createMigration(): void
    {
        $table = Str::snake(Str::pluralStudly(class_basename($this->argument('name'))));

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/Model.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param string $stub
     * @return string
     */
    protected function resolveStubPath(string $stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace(string $rootNamespace): string
    {
        return is_dir(app_path('Models')) ? $rootNamespace . '\\Models' : $rootNamespace;
    }
}
