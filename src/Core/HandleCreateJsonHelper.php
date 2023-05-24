<?php

namespace DeyanArdi\LaravelLayerize\Core;

use Illuminate\Support\Facades\File;

class HandleCreateJsonHelper
{

    public function createResponseJsonHelperFile($serviceFolderPath)
    {
        $servicesFileContent = <<<EOD
        <?php

        namespace App\Helpers;

        use Illuminate\Http\Response;

        class Json
        {
            /**
             * API Response
             *
             * @var array
             */
            protected static \$response = [
                'success' => null,
                'http_status' => null,
                'meta' => [
                    'message' => null,
                    'error' => null,
                ],
                'data' => null,
            ];

            /**
             * Give success response.
             */
            public static function success(\$data)
            {
                self::\$response['success'] = true;
                self::\$response['http_status'] = Response::HTTP_OK;
                self::\$response['meta']['message'] = "Query Execution Success";
                self::\$response['meta']['error'] = [];
                self::\$response['data'] = \$data;

                return response()->json(self::\$response);
            }

            /**
             * Give error response.
             */
            public static function error(\$error)
            {
                self::\$response['success'] = true;
                self::\$response['http_status'] = Response::HTTP_INTERNAL_SERVER_ERROR;
                self::\$response['meta']['message'] = "Query Execution Failed";
                self::\$response['meta']['error'] = \$error;
                self::\$response['data'] = [];

                return response()->json(self::\$response);
            }
        }
        EOD;

        File::put($serviceFolderPath . '/Json.php', $servicesFileContent);
        return "Helper Json Format [{$serviceFolderPath}] created successfully.";
    }
}
