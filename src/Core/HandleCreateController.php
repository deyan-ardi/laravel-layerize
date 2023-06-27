<?php

namespace DeyanArdi\LaravelLayerize\Core;

use Illuminate\Support\Facades\File;

class HandleCreateController
{
    public function getControllerPath($controllerFolderPath, $controllerName)
    {
        $controllerName = str_replace(['/', '\\'], '/', $controllerName);
        return $controllerFolderPath . '/' . $controllerName . 'Controller.php';
    }

    public function createSingleControllers($controllerPath, $controllerName)
    {
        $parentDirectory = dirname($controllerPath);
        if (!File::isDirectory($parentDirectory)) {
            File::makeDirectory($parentDirectory, 0755, true);
        }
        $namespace = $this->getControllerNamespace($parentDirectory);
        $className = $this->getClassName($controllerName);
        $classNameLower = lcfirst($className);
        $controllerContent = <<<EOD
        <?php

        namespace {$namespace};
        use App\Http\Controllers\Controller;
        use Illuminate\Http\Request;
        use Illuminate\Support\Facades\DB;
        use Throwable;
        use App\Helpers\Json;

        class ${className}Controller extends Controller
        {
            // Controller code with example implementation

            public function __construct(
                // protected ${className}UseCase \$${classNameLower}UseCase,
            ){}

            public function index(){
                // Render from use case
                // return \$this->${classNameLower}UseCase->renderIndex();
            }

            public function datatable(Request \$request){
                try {
                    // Render from use case

                    // DB::beginTransaction();
                    // \$datatable = \$this->${classNameLower}UseCase->renderDatatable(\$request);
                    // DB::commit();

                    // return \$datatable;
                } catch (Throwable \$th) {
                    // DB::rollBack();

                    // return Json::error(\$th->getMessage());
                }
            }

            public function create(){
                // Render from use case

                // return \$this->${classNameLower}UseCase->renderCreate();       
            }

            public function store(Store${className}Request \$request){
                try{
                    // Render from use case

                    // DB::beginTransaction();
                    // \$this->${classNameLower}UseCase->execStore(\$request);
                    // DB::commit();

                    // return redirect()->back()->with('success', "Data Successfully Added");
                }catch(Throwable \$th){
                    // DB::rollBack();

                    // return redirect()->back()->with('error', \$th->getMessage());
                }
            }

            public function edit(string \$id){
                // Render from use case

                // return \$this->${classNameLower}UseCase->renderEdit(\$id);
            }

            public function update(Update${className}Request \$request, string \$id){
                try{
                    // Render from use case

                    // DB::beginTransaction();
                    // \$this->${classNameLower}UseCase->execUpdate(\$request, \$id);
                    // DB::commit();

                    // return redirect()->back()->with('success', "Data Successfully Updated");
                }catch(Throwable \$th){
                    // DB::rollBack();

                    // return redirect()->back()->with('error', \$th->getMessage());
                }
            }

            public function delete(string \$id){
                try{
                    // Render from use case

                    // DB::beginTransaction();
                    // \$this->${classNameLower}UseCase->execDelete(\$request);
                    // DB::commit();

                    // return redirect()->back()->with('success', "Data Successfully Delete");
                }catch(Throwable \$th){
                    // DB::rollBack();

                    // return redirect()->back()->with('error', \$th->getMessage());
                }
            }
        }
        EOD;

        File::put($controllerPath, $controllerContent);

        return "File controller [{$controllerPath}] created successfully.";
    }

    public function getControllerNamespace($directory)
    {
        $basePath = app_path();
        $namespace = str_replace('/', '\\', str_replace($basePath, 'App', $directory));
        return rtrim($namespace, '\\');
    }

    public function getClassName($controllerName)
    {
        $controllerName = str_replace(['/', '\\'], '/', $controllerName);
        $nameParts = explode('/', $controllerName);
        return end($nameParts);
    }
}
