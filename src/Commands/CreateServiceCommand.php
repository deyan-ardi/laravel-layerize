<?php

namespace DeyanArdi\LaravelLayerize\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateServiceCommand extends Command
{
    protected $signature = 'layerize:service {serviceName}';

    protected $description = 'Create a new service';

    public function handle()
    {
        $serviceName = $this->argument('serviceName');

        $serviceFolderPath = app_path('Service');
        if (!File::isDirectory($serviceFolderPath)) {
            File::makeDirectory($serviceFolderPath);
        }

        $servicePath = $serviceFolderPath . '/' . $serviceName;
        File::makeDirectory($servicePath);

        $this->createServiceFiles($servicePath, $serviceName);
    }

    protected function createServiceFiles($servicePath, $serviceName)
    {
        $queryServiceContent = <<<EOD
        <?php

        namespace App\Service\\$serviceName;

        class ${serviceName}QueryService
        {
            // Your code here
        }
        EOD;

        $commandServiceContent = <<<EOD
        <?php

        namespace App\Service\\$serviceName;

        class ${serviceName}CommandService
        {
            // Your code here
        }
        EOD;

        $datatableServiceContent = <<<EOD
        <?php

        namespace App\Service\\$serviceName;

        class ${serviceName}DatatableService
        {
            // Your code here
        }
        EOD;

        File::put($servicePath . '/' . $serviceName . 'QueryService.php', $queryServiceContent);
        File::put($servicePath . '/' . $serviceName . 'CommandService.php', $commandServiceContent);
        File::put($servicePath . '/' . $serviceName . 'DatatableService.php', $datatableServiceContent);

        $this->info('Service created successfully.');
    }
}
