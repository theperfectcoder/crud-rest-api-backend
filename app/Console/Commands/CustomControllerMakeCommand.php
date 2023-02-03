<?php

namespace App\Console\Commands;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Console\Input\InputOption;

class CustomControllerMakeCommand extends CustomGeneratorCommand
{
    use CreatesMatchingTest;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:custom-controller';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     */
    protected static $defaultName = 'make:custom-controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new controller class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected string $type = 'Controller';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        $stub = '/stubs/Controller.stub';

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
        return $rootNamespace.'\Http\Controllers';
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

        $replace["use {$controllerNamespace}\Controller;\n"] = '';

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
        '{{ controllerVariable }}' => "string",
    ])]
    protected function buildClassReplacements(string $name): array
    {
        $name = explode('\\', $name);
        $directory = $name[count($name) - 2];
        $controllerVariable = $name[count($name) - 1];
        return [
            '{{ directory }}' => $directory,
            '{{ controllerVariable }}' => lcfirst($controllerVariable),
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            ['api', null, InputOption::VALUE_NONE, 'Exclude the create and edit methods from the controller.'],
            ['type', null, InputOption::VALUE_REQUIRED, 'Manually specify the controller stub file to use.'],
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the controller already exists'],
            ['invokable', 'i', InputOption::VALUE_NONE, 'Generate a single method, invokable controller class.'],
            ['resource', 'r', InputOption::VALUE_NONE, 'Generate a resource controller class.'],
            ['requests', 'R', InputOption::VALUE_NONE, 'Generate FormRequest classes for store and update.'],
        ];
    }
}
