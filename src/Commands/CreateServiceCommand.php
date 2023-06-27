<?php

namespace DeyanArdi\LaravelLayerize\Commands;

use DeyanArdi\LaravelLayerize\Core\HandleCreateService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateServiceCommand extends Command
{
    protected $signature = 'layerize:service {serviceName} {--a|a : Create all service file include QueryService, DatatableService, CommandService}';

    protected $description = 'Create a new service file for Persistance Layer';

    public function handle()
    {
        $serviceName = $this->argument('serviceName');

        $serviceFolderPath = app_path('Services');
        $handleCreateService = new HandleCreateService();
        if (!File::isDirectory($serviceFolderPath)) {
            File::makeDirectory($serviceFolderPath);
            $generate =  $handleCreateService->createServicesFile($serviceFolderPath);
            $this->line('');
            $this->line(sprintf('<bg=blue;fg=black>%s</>', ' INFO ') . ' ' . $generate);
            $this->line('');
        }

        if (!$this->option('a')) {
            $servicePath = $handleCreateService->getServicePath($serviceFolderPath, $serviceName);

            if (File::exists($servicePath)) {
                $this->line('');
                $this->line(sprintf('<bg=red;fg=black>%s</>', ' ERROR ') . ' ' . "File Service '{$serviceName}Service.php' already exists");
                $this->line('');
                return;
            }

            $generate = $handleCreateService->createSingleServices($servicePath, $serviceName);
            $this->line('');
            $this->line(sprintf('<bg=blue;fg=black>%s</>', ' INFO ') . ' ' . $generate);
            $this->line('');
        }

        if ($this->option('a')) {
            $serviceName = $this->argument('serviceName');

            $serviceFolderPath = app_path('Services');
            $servicePath = $serviceFolderPath . '/' . str_replace('/', DIRECTORY_SEPARATOR, $serviceName);
            $parentDirectory = dirname($servicePath);

            if (File::exists($servicePath)) {
                $this->line('');
                $this->line(sprintf('<bg=red;fg=black>%s</>', ' ERROR ') . ' ' . "Service '{$serviceName}' already exists.");
                $this->line('');
                return;
            }

            if (!File::exists($parentDirectory)) {
                File::makeDirectory($parentDirectory, 0755, true);
            }

            File::makeDirectory($servicePath, 0755, true);

            $generate = $handleCreateService->createAllServices($servicePath, $serviceName);
            $this->line('');
            $this->line(sprintf('<bg=blue;fg=black>%s</>', ' INFO ') . ' ' . $generate);
            $this->line('');
        }
    }
}
