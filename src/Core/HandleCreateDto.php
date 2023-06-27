<?php

namespace DeyanArdi\LaravelLayerize\Core;

use Illuminate\Support\Facades\File;

class HandleCreateDto
{
    public function getDtoPath($dtoFolderPath, $dtoName)
    {
        $dtoName = str_replace(['/', '\\'], '/', $dtoName);
        return $dtoFolderPath . '/' . $dtoName . '.php';
    }

    public function createSingleDtos($dtoPath, $dtoName)
    {
        $parentDirectory = dirname($dtoPath);
        if (!File::isDirectory($parentDirectory)) {
            File::makeDirectory($parentDirectory, 0755, true);
        }
        $namespace = $this->getDtoNamespace($parentDirectory);
        $className = $this->getClassName($dtoName);
        $dtoContent = <<<EOD
        <?php

        namespace {$namespace};
        use Illuminate\Foundation\Http\FormRequest;

        class ${className} extends FormRequest
        {
            // Dto/validation with example implementation

            public function authorize()
            {
                return true;
            }

            public function rules()
            {
                return [
                    // Validation rules
                ];
            }

            protected function prepareForValidation()
            {
                \$this->merge([
                    // prepare for validation
                ]);
            }

            public function messages()
            {
                return [
                    // custom message of validation
                ];
            }

            public function attributes()
            {
                return [
                    // custom attributes of validation
                ];
            }
        }
        EOD;

        File::put($dtoPath, $dtoContent);

        return "File dto/validation [{$dtoPath}] created successfully.";
    }

    public function getdtoNamespace($directory)
    {
        $basePath = app_path();
        $namespace = str_replace('/', '\\', str_replace($basePath, 'App', $directory));
        return rtrim($namespace, '\\');
    }

    public function getClassName($dtoName)
    {
        $dtoName = str_replace(['/', '\\'], '/', $dtoName);
        $nameParts = explode('/', $dtoName);
        return end($nameParts);
    }
}
