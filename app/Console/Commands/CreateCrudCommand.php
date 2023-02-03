<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:crud {--name=} {--directory=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will be create all crud functionality and files';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        Artisan::call('make:custom-model '. $this->option('name'));
        $this->components->info(Artisan::output());
        Artisan::call("make:custom-service", ['name' => $this->option('directory') . '/' . $this->option('name').'sControllerService']);
        $this->components->info(Artisan::output());
        Artisan::call('make:custom-interface', ['name' => $this->option('directory') . '/' . $this->option('name').'sControllerInterface']);
        $this->components->info(Artisan::output());
        Artisan::call('make:custom-controller ' . $this->option('directory') . '/' . $this->option('name'). 'sController');
        $this->components->info(Artisan::output());
        Artisan::call('make:custom-request', ['name' => $this->option('directory') . "/" . $this->option('name') . "sControllerRequests/CreateRequest"]);
        $this->components->info(Artisan::output());
        Artisan::call('make:custom-request', ['name' => $this->option('directory') . "/" . $this->option('name') . "sControllerRequests/UpdateRequest"]);
        $this->components->info(Artisan::output());
    }


}
