<?php

namespace DeyanArdi\LaravelLayerize\Commands;

use DeyanArdi\LaravelLayerize\Core\HandleCreatecontroller;
use DeyanArdi\LaravelLayerize\Core\HandleCreateJsonHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateControllerCommand extends Command
{
    protected $signature = 'layerize:controller {controllerName}';

    protected $description = 'Create a new controller file for Presentation Layer';

    public function handle()
    {
        $controllerName = $this->argument('controllerName');

        $controllerFolderPath = app_path('Http/Controllers');
        $helperFolderPath = app_path('Helpers');
        $handleCreatecontroller = new HandleCreateController();
        $handleCreateJsonHelper = new HandleCreateJsonHelper();
        if (!File::isDirectory($controllerFolderPath)) {
            File::makeDirectory($controllerFolderPath);
        }

        if (!File::isDirectory($helperFolderPath)) {
            File::makeDirectory($helperFolderPath);
            $generate = $handleCreateJsonHelper->createResponseJsonHelperFile($helperFolderPath);
            $this->line('');
            $this->line(sprintf('<bg=blue;fg=black>%s</>', ' INFO ') . ' ' . $generate);
            $this->line('');
        }

        $controllerPath = $handleCreatecontroller->getControllerPath($controllerFolderPath, $controllerName);

        if (File::exists($controllerPath)) {
            $this->line('');
            $this->line(sprintf('<bg=red;fg=black>%s</>', ' ERROR ') . ' ' . "File controller '{$controllerName}Controller.php' already exists");
            $this->line('');
            return;
        }

        $generate = $handleCreatecontroller->createSinglecontrollers($controllerPath, $controllerName);
        $this->line('');
        $this->line(sprintf('<bg=blue;fg=black>%s</>', ' INFO ') . ' ' . $generate);
        $this->line('');
    }
}
