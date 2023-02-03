<?php

namespace App\Console\Commands;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use JetBrains\PhpStorm\ArrayShape;

class CustomServiceMakeCommand extends CustomGeneratorCommand
{
    use CreatesMatchingTest;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:custom-service';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     */
    protected static $defaultName = 'make:custom-service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected string $type = 'Service';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        $stub = '/stubs/Service.stub';

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
        return $rootNamespace . '\Services';
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

        $replace = $this->buildModelReplacements($name);

        $replace["use {$controllerNamespace}\Service;\n"] = '';

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    /**
     * Build the model replacement values.
     *
     * @param string $model
     * @return array
     */
    #[ArrayShape([
        'DummyFullModelClass' => "mixed|string",
        '{{ namespacedModel }}' => "mixed|string",
        '{{namespacedModel}}' => "mixed|string",
        'DummyModelClass' => "string",
        '{{ model }}' => "string",
        '{{model}}' => "string",
        'DummyModelVariable' => "string",
        '{{ modelVariable }}' => "string",
        '{{modelVariable}}' => "string",
        '{{ directory }}' => "string",
        '{{ controller }}' => "string",
    ])]
    protected function buildModelReplacements(string $model): array
    {
        $model = explode('\\', $model);
        $modelName = str_replace('sControllerService', '', $model[count($model) - 1]);
        $directory = $model[count($model) - 2];
        $controllerName = str_replace('Service', '', $model[count($model) - 1]);
        return [
            'DummyFullModelClass' => $modelName,
            '{{ namespacedModel }}' => $modelName,
            '{{namespacedModel}}' => $modelName,
            'DummyModelClass' => $modelName,
            '{{ model }}' => $modelName,
            '{{model}}' => $modelName,
            'DummyModelVariable' => $modelName,
            '{{ modelVariable }}' => lcfirst($modelName),
            '{{modelVariable}}' => $modelName,
            '{{ directory }}' => $directory,
            '{{ controller }}' => $controllerName,
        ];
    }

}
