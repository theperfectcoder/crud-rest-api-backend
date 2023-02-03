<?php

namespace App\Console\Commands;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use JetBrains\PhpStorm\ArrayShape;

class CustomInterfaceMakeCommand extends CustomGeneratorCommand
{
    use CreatesMatchingTest;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:custom-interface';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     */
    protected static $defaultName = 'make:custom-interface';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new interface class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected string $type = 'Interface';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        $stub = '/stubs/Interface.stub';

        return $this->resolveStubPath($stub);
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
            : __DIR__.$stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace(string $rootNamespace): string
    {
        return $rootNamespace.'\Clusters';
    }

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in the base namespace.
     *
     * @param string $name
     * @return string
     * @throws FileNotFoundException
     */
    protected function buildClass(string $name): string
    {
        $controllerNamespace = $this->getNamespace($name);

        $replace = $this->buildClassReplacements($name);

        $replace["use {$controllerNamespace}\Interface;\n"] = '';

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }


    /**
     * Build the model replacement values.
     *
     * @param string $name
     * @return array
     */
    #[ArrayShape([
        '{{ directory }}' => "string",
        '{{ controller }}' => "string",
    ])]
    protected function buildClassReplacements(string $name): array
    {
        $name = explode('\\', $name);
        $directory = $name[count($name) - 2];
        $controllerName = str_replace('Interface', '', $name[count($name) - 1]);
        return [
            '{{ directory }}' => $directory,
            '{{ controller }}' => $controllerName,
        ];
    }
}
