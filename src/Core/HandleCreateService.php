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
        $classNameSlash = ucwords(str_replace(['/', '\\'], '\\', $serviceName));
        $classNameLowerEnd = ucwords(basename($serviceName));
        $queryServiceContent = <<<EOD
        <?php

        namespace App\Services\\$classNameSlash;
        use App\Services\Service;

        class ${classNameLowerEnd}Query extends Service
        {
            public function __construct(){
                // self::setModel(User::class); call your model class name to use General Service Function
            }

            // Other Query Service here
            public function getCustomQuery(string \$id){
                // Other code here if query not support in getByAttr method
            }
        }
        EOD;

        $commandServiceContent = <<<EOD
        <?php

        namespace App\Services\\$classNameSlash;
        use App\Services\Service;

        class ${classNameLowerEnd}Command extends Service
        {
            // Command Service here
            // Please generate Store${classNameLowerEnd}Request using layerize:dto, must be same with request send by useCase
            public function store(Store${classNameLowerEnd}Request \$request){
                // Code for store data
            }

            // Please generate Store${classNameLowerEnd}Request using layerize:dto, must be same with request send by useCase
            public function update(Update${classNameLowerEnd}Request \$request, string \$id){
                // Code for update data
            }

            public function delete(string \$id){
                // Code for delete data
            }
        }
        EOD;

        $datatableServiceContent = <<<EOD
        <?php

        namespace App\Services\\$classNameSlash;
        use App\Services\Service;
        use Illuminate\Http\Request;

        class ${classNameLowerEnd}Datatable extends Service
        {
            // Datatable Service here
            public function datatable(Request \$request){
                // Datatable server side processing code here
            }
        }
        EOD;

        File::put($servicePath . '/' . $classNameLowerEnd . 'Query.php', $queryServiceContent);
        File::put($servicePath . '/' . $classNameLowerEnd . 'Command.php', $commandServiceContent);
        File::put($servicePath . '/' . $classNameLowerEnd . 'Datatable.php', $datatableServiceContent);

        return "All general service [{$servicePath}] created successfully.";
    }

    public function getServicePath($serviceFolderPath, $serviceName)
    {
        $serviceName = str_replace(['/', '\\'], '/', $serviceName);
        return $serviceFolderPath . '/' . $serviceName . '.php';
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

        class ${className} extends Service
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
