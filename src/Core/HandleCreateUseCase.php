<?php

namespace DeyanArdi\LaravelLayerize\Core;

use Illuminate\Support\Facades\File;

class HandleCreateUseCase
{
    public function getuseCasePath($useCaseFolderPath, $usecaseName)
    {
        $usecaseName = str_replace(['/', '\\'], '/', $usecaseName);
        return $useCaseFolderPath . '/' . $usecaseName . 'UseCase.php';
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

        class ${className}UseCase
        {
            // Use case code with example implementation

            public function __construct(
                // protected ${className}QueryService ${classNameLower}QueryService,
                // protected ${className}CommandService ${classNameLower}CommandService,
                // protected ${className}DatatableService ${classNameLower}DatatableService,
            ){}

            public function renderIndex(){
                // render view index
                // return view('index');
            }

            public function renderDatatable(Request \$request){
                // render datatable
                // return \$this->${classNameLower}DatatableService->datatable(\$request);
            }

            public function renderCreate(){
                // render view create
                // return view('create');
            }

            public function execStore(Store${className}Request \$request){
                // exec store data
                // return \$this->${classNameLower}CommandService->store(\$request),
            }

            public function renderEdit(string \$id){
                // render view create
                // \$findId = \$this->${classNameLower}QueryService->getByAttr([],['id' => \$id],'first);
                // return view('edit', compact('findId'));
            }

            public function execUpdate(Update${className}Request \$request, string \$id){
                // exec store data
                // return \$this->${classNameLower}CommandService->update(\$request, \$id),
            }

            public function execDelete(string \$id){
                // exec store data
                // return \$this->${classNameLower}CommandService->delete(\$id),
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
