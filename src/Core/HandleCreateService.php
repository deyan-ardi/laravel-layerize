<?php

namespace DeyanArdi\LaravelLayerize\Core;

use Illuminate\Support\Facades\File;

class HandleCreateService
{
    public function createServicesFile($serviceFolderPath)
    {
        $servicesFileContent = <<<EOD
        <?php

        namespace App\Services;
        use DeyanArdi\LaravelLayerize\Service\BaseService;

        class Service extends BaseService
        {

        }
        EOD;

        File::put($serviceFolderPath . '/Service.php', $servicesFileContent);
        return "Service configuration [{$serviceFolderPath}/Service.php] created successfully.";
    }

    public function createAllServices($servicePath, $serviceName)
    {
        $classNameLower = ucwords($serviceName);
        $queryServiceContent = <<<EOD
        <?php

        namespace App\Services\\$serviceName;
        use App\Services\Service;

        class ${serviceName}QueryService extends Service
        {
            public function __construct(){
                // self::setModel(User::class); call your model class name to use getByAttr method
            }

            // Other Query Service here
            public function getCustomQuery(string \$id){
                // Other code here if query not support in getByAttr method
            }
        }
        EOD;

        $commandServiceContent = <<<EOD
        <?php

        namespace App\Services\\$serviceName;
        use App\Services\Service;

        class ${serviceName}CommandService extends Service
        {
            // Command Service here
            public function store(Store${classNameLower}Request \$request){
                // Code for store data
            }

            public function update(Update${classNameLower}Request \$request, string \$id){
                // Code for update data
            }

            public function delete(string \$id){
                // Code for delete data
            }
        }
        EOD;

        $datatableServiceContent = <<<EOD
        <?php

        namespace App\Services\\$serviceName;
        use App\Services\Service;

        class ${serviceName}DatatableService extends Service
        {
            // Datatable Service here

            public function datatable(Request \$request){
                // Datatable server side processing code here
            }
        }
        EOD;

        File::put($servicePath . '/' . $serviceName . 'QueryService.php', $queryServiceContent);
        File::put($servicePath . '/' . $serviceName . 'CommandService.php', $commandServiceContent);
        File::put($servicePath . '/' . $serviceName . 'DatatableService.php', $datatableServiceContent);

        return "All general service [{$servicePath}] created successfully.";
    }

    public function getServicePath($serviceFolderPath, $serviceName)
    {
        $serviceName = str_replace(['/', '\\'], '/', $serviceName);
        return $serviceFolderPath . '/' . $serviceName . 'Service.php';
    }

    public function createSingleServices($servicePath, $serviceName)
    {
        $parentDirectory = dirname($servicePath);
        if (!File::isDirectory($parentDirectory)) {
            File::makeDirectory($parentDirectory, 0755, true);
        }
        $namespace = $this->getServiceNamespace($parentDirectory);
        $className = $this->getClassName($serviceName);
        $serviceContent = <<<EOD
        <?php

        namespace {$namespace};
        use App\Services\Service;

        class ${className}Service extends Service
        {
            // Your service code here
        }
        EOD;

        File::put($servicePath, $serviceContent);

        return "Service file [{$servicePath}] created successfully.";
    }

    public function getServiceNamespace($directory)
    {
        $basePath = app_path();
        $namespace = str_replace('/', '\\', str_replace($basePath, 'App', $directory));
        return rtrim($namespace, '\\');
    }

    public function getClassName($serviceName)
    {
        $serviceName = str_replace(['/', '\\'], '/', $serviceName);
        $nameParts = explode('/', $serviceName);
        return end($nameParts);
    }
}
