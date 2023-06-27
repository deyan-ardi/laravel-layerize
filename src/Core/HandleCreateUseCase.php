<?php

namespace DeyanArdi\LaravelLayerize\Core;

use Illuminate\Support\Facades\File;

class HandleCreateUseCase
{
    public function getuseCasePath($useCaseFolderPath, $usecaseName)
    {
        $usecaseName = str_replace(['/', '\\'], '/', $usecaseName);
        return $useCaseFolderPath . '/' . $usecaseName . '.php';
    }

    public function createSingleUseCases($useCasePath, $usecaseName)
    {
        $parentDirectory = dirname($useCasePath);
        if (!File::isDirectory($parentDirectory)) {
            File::makeDirectory($parentDirectory, 0755, true);
        }
        $namespace = $this->getusecaseNamespace($parentDirectory);
        $className = $this->getClassName($usecaseName);
        $classNameLower = lcfirst($className);
        $useCaseContent = <<<EOD
        <?php

        namespace {$namespace};
        use Illuminate\Http\Request;

        class ${className}
        {
            // Use case code with example implementation

            public function __construct(
                // protected ${className}Query \$${classNameLower}Query,
                // protected ${className}Command \$${classNameLower}Command,
                // protected ${className}Datatable \$${classNameLower}Datatable,
            ){}

            public function renderIndex(){
                // render view index
                // return view('index');
            }

            public function renderDatatable(Request \$request){
                // render datatable
                // return \$this->${classNameLower}Datatable->datatable(\$request);
            }

            public function renderCreate(){
                // render view create
                // return view('create');
            }

            // Please generate Store${className}Request using layerize:dto, must be same with request send by controller
            public function execStore(Store${className}Request \$request){
                // exec store data
                // return \$this->${classNameLower}Command->store(\$request),
            }

            public function renderEdit(string \$id){
                // render view edit, general query can be use when activate Query service __construct
                // \$findId = \$this->${classNameLower}Query->findOrFail(['id' => \$id]);
                // return view('edit', compact('findId'));
            }

            // Please generate Store${className}Request using layerize:dto, must be same with request send by controller
            public function execUpdate(Update${className}Request \$request, string \$id){
                // exec store data
                // return \$this->${classNameLower}Command->update(\$request, \$id),
            }

            public function execDelete(string \$id){
                // exec store data
                // return \$this->${classNameLower}Command->delete(\$id),
            }
        }
        EOD;

        File::put($useCasePath, $useCaseContent);

        return "File UseCase [{$useCasePath}] created successfully.";
    }

    public function getusecaseNamespace($directory)
    {
        $basePath = app_path();
        $namespace = str_replace('/', '\\', str_replace($basePath, 'App', $directory));
        return rtrim($namespace, '\\');
    }

    public function getClassName($usecaseName)
    {
        $usecaseName = str_replace(['/', '\\'], '/', $usecaseName);
        $nameParts = explode('/', $usecaseName);
        return end($nameParts);
    }
}
