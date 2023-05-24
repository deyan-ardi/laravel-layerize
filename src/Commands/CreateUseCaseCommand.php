<?php

namespace DeyanArdi\LaravelLayerize\Commands;

use DeyanArdi\LaravelLayerize\Core\HandleCreateUseCase;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateUseCaseCommand extends Command
{
    protected $signature = 'layerize:usecase {usecaseName}';

    protected $description = 'Create a new use case file for Business Layer';

    public function handle()
    {
        $usecaseName = $this->argument('usecaseName');

        $useCaseFolderPath = app_path('Http/UseCase');
        $handleCreateUseCase = new HandleCreateUseCase();
        if (!File::isDirectory($useCaseFolderPath)) {
            File::makeDirectory($useCaseFolderPath);
        }

        $useCasePath = $handleCreateUseCase->getuseCasePath($useCaseFolderPath, $usecaseName);

        if (File::exists($useCasePath)) {
            $this->line('');
            $this->line(sprintf('<bg=red;fg=black>%s</>', ' ERROR ') . ' ' . "File use case '{$usecaseName}UseCase.php' already exists");
            $this->line('');
            return;
        }

        $generate = $handleCreateUseCase->createSingleUseCases($useCasePath, $usecaseName);
        $this->line('');
        $this->line(sprintf('<bg=blue;fg=black>%s</>', ' INFO ') . ' ' . $generate);
        $this->line('');
    }
}
