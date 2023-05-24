<?php

namespace DeyanArdi\LaravelLayerize\Commands;

use DeyanArdi\LaravelLayerize\Core\HandleCreateDto;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateDtoCommand extends Command
{
    protected $signature = 'layerize:dto {dtoName}';

    protected $description = 'Create a new dto/validation layer file for Business Layer';

    public function handle()
    {
        $dtoName = $this->argument('dtoName');

        $dtoFolderPath = app_path('Http/Requests');
        $handleCreatedto = new HandleCreateDto();
        if (!File::isDirectory($dtoFolderPath)) {
            File::makeDirectory($dtoFolderPath);
        }

        $dtoPath = $handleCreatedto->getDtoPath($dtoFolderPath, $dtoName);

        if (File::exists($dtoPath)) {
            $this->line('');
            $this->line(sprintf('<bg=red;fg=black>%s</>', ' ERROR ') . ' ' . "File dto '{$dtoName}Request.php' already exists");
            $this->line('');
            return;
        }

        $generate = $handleCreatedto->createSingledtos($dtoPath, $dtoName);
        $this->line('');
        $this->line(sprintf('<bg=blue;fg=black>%s</>', ' INFO ') . ' ' . $generate);
        $this->line('');
    }
}
