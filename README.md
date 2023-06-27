# Laravel Layerize - Develop Laravel App With Layer Architecture
[![Laravel](https://img.shields.io/badge/Laravel-^7.0-red.svg)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-^7.3-blue.svg)](https://www.php.net/)

:::warning
Versi paket ini kedaluwarsa dan dukungan berakhir pada Juni 2023. Harap gunakan paket versi 2.x.x
:::
## What Is Layer Architecture
<div style="display: flex;">
  <img src="https://sv1.static.ganadev.com/deyan/layer-architecture.png" alt="Gambar" width="400px" style="margin-right: 20px;">
  <div>
    <p>In the Laravel Framework, the standard uses an architecture, namely MVC (Model - View - Controller). This architecture is also included in the example of implementing the Layer Architecture, but there are obstacles that are encountered when we only implement MVC.</p>
    <p> This problem is mainly encountered when we start developing a complex and continuous Laravel-based application, the MVC Architecture cannot handle it as a whole because all business logic is located only in the Controller. So if there is a change in the development team, the newly joined team will spend a lot of time studying the previous code. </p>
    <p>One of the things that can be done to overcome is to develop from the standard Laravel Framework architecture to a more Clean Code architecture, but the problem is that there is no official standard for this and many novice programmers find it difficult to learn it.</p>
    <p>With Laravel Layerize, you can separate the business logic from the Controller and organize your code into clear, separate layers. This package provides a ready-to-use directory structure and best practice approach to organize code according to their respective functions</p>
    <p>The Laravel Layerize package has several layers namely: </p>
    <ul>
      <li><strong>Presentation Layer:</strong> The layer closest to the user or the "presentation" of the application. Its main tasks include handling user interaction, such as receiving user input, displaying views, and sending responses to the user. Components in this layer include route, controllers, dto or form validation</li>
      <li><strong>Business Layer:</strong> The layer that contains the business logic or business rules of the application. Its main tasks include orchestrating business processes, performing validation, making decisions, and processing data. This layer is technology-agnostic and responsible for keeping the business logic isolated from other implementation details. Components in this layer include use cases.</li>
      <li><strong>Persistence Layer:</strong> The layer responsible for storing and retrieving data from persistent resources, such as databases or file storage. Its main tasks include performing CRUD (Create, Read, Update, Delete) operations on data. This layer provides an interface to access persistent resources and enables the application to store and retrieve data. Components in this layer include Command Service, Query Service, Datatable Service, and Other Service depend on requirements</li>
      <li><strong>Database Layer:</strong> The layer that directly refers to the database system used by the application. It involves components such as the database server, database schema, tables, and queries. This layer serves as the infrastructure that supports the persistence layer in storing and retrieving data from the database.</li>
    </ul>
    <p>By adopting a Laravel Layerize, applications can be well organized, have a clear structure, and separate responsibilities between each layer. This allows for easier maintenance, more structured development, and increases the scalability and flexibility of your application.</p>
  </div>
</div>

## Laravel Support Version

| Laravel Version | Support |
| --------------- | ------- |
| 4.2.x           | `No`    |
| 5.x.x           | `No`    |
| 6.x.x           | `No`    |
| 7.x.x           | `Yes`   |
| 8.x.x           | `Yes`   |
| 9.x.x           | `Yes`   |
| 10.x.x          | `Yes`   |

## System Requerements

- PHP Version "^7.3|7.4|^8.0|^8.1|^8.2"
- File (Default By Laravel Illuminate)

## How To Install
- Open terminal, run this command

    ```php
    composer require deyan-ardi/laravel-layerize
    ```
- After finish install, you can start use this package by run the command
  
## How To Update
- Open terminal, run this command

    ```php
    composer update deyan-ardi/laravel-layerize
    ```
  
## How To Use (Documentation By Layer)
### Presentation Layer
- Route
    - There are no changes to the route, you can implement the route according to the Laravel framework standards
  
- DTO/Validation
  - DTO/Validation in Laravel Framework is handled by FormRequest. This package helps you create a FormRequest framework for you to validate on the user request side before going to the Controller. To create a FormRequest with Layerize, use the following command
  
    ```php
    php artisan layerize:dto User/StoreUser
    ```
  - The result of the above command will give a class named `UserStorRequest` which will be added to the `App/Http/Requests/User` folder

    ```php
    <?php

    namespace App\Http\Requests\User;

    use Illuminate\Foundation\Http\FormRequest;

    class StoreUserRequest extends FormRequest
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
            $this->merge([
                // prepare for validation
            ]);
        }

        public function messages()
        {
            return [
                // custom message of validation
            ];
        }
    }
    ```
- Controller
  - This package helps you create a Controller framework for you to send requests to the next layer. To create a Controller with Layerize, use the following command
    ```php
    php artisan layerize:controller User
    ```
  - The result of the above command will give a class named `UserController` which will be added to the `App/Http/Controllers` folder
    ```php
        <?php

    namespace App\Http\Controllers;

    use App\Helpers\Json;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Throwable;

    class UserController extends Controller
    {
        // Controller code with example implementation

        public function __construct(
            // protected UserUseCase UserUseCase,
        ) {
        }

        public function index()
        {
            try {
                // Render from use case

                // DB::beginTransaction();
                // $view = $this->UserUseCase->renderIndex();
                // DB::commit();

                // return $view;
            } catch(Throwable $th) {
                // DB::rollBack();

                // return redirect()->back()->with('error', $th->getMessage());
            }
        }

        public function datatable(Request $request)
        {
            try {
                // Render from use case

                // DB::beginTransaction();
                // $datatable = $this->UserUseCase->renderDatatable($request);
                // DB::commit();

                // return $datatable;
            } catch (Throwable $th) {
                // DB::rollBack();

                // return Json::error($th->getMessage());
            }
        }

        public function create()
        {
            try {
                // Render from use case

                // DB::beginTransaction();
                // $view = $this->UserUseCase->renderCreate();
                // DB::commit();

                // return $view;
            } catch(Throwable $th) {
                // DB::rollBack();

                // return redirect()->back()->with('error', $th->getMessage());
            }
        }

        public function store(StoreUserRequest $request)
        {
            try {
                // Render from use case

                // DB::beginTransaction();
                // $this->UserUseCase->execStore($request);
                // DB::commit();

                // return redirect()->back()->with('success', "Data Successfully Added");
            } catch(Throwable $th) {
                // DB::rollBack();

                // return redirect()->back()->with('error', $th->getMessage());
            }
        }

        public function edit(string $id)
        {
            try {
                // Render from use case

                // DB::beginTransaction();
                // $view = $this->UserUseCase->renderEdit($id);
                // DB::commit();

                // return $view;
            } catch(Throwable $th) {
                // DB::rollBack();

                // return redirect()->back()->with('error', $th->getMessage());
            }
        }

        public function update(UpdateUserRequest $request, string $id)
        {
            try {
                // Render from use case

                // DB::beginTransaction();
                // $this->UserUseCase->execUpdate($request, $id);
                // DB::commit();

                // return redirect()->back()->with('success', "Data Successfully Updated");
            } catch(Throwable $th) {
                // DB::rollBack();

                // return redirect()->back()->with('error', $th->getMessage());
            }
        }

        public function delete(string $id)
        {
            try {
                // Render from use case

                // DB::beginTransaction();
                // $this->UserUseCase->execDelete($request);
                // DB::commit();

                // return redirect()->back()->with('success', "Data Successfully Delete");
            } catch(Throwable $th) {
                // DB::rollBack();

                // return redirect()->back()->with('error', $th->getMessage());
            }
        }
    }

    ```
### Business Layer
- Use Case
  - This package helps you create a UseCase framework for you to perform business logic on your application. To create a UseCase with Layerize, use the following command
    ```php
    php artisan layerize:usecase User
    ```
  - The result of the above command will give a class named `UserUseCase` which will be added to the `App/Http/UseCase` folder
    ```php
    <?php

    namespace App\Http\UseCase;

    class UserUseCase
    {
        // Use case code with example implementation

        public function __construct(
            // protected UserQueryService UserQueryService,
            // protected UserCommandService UserCommandService,
            // protected UserDatatableService UserDatatableService,
        ) {
        }

        public function renderIndex()
        {
            // render view index
            // return view('index');
        }

        public function renderDatatable(Request $request)
        {
            // render datatable
            // return $this->UserDatatableService->datatable($request);
        }

        public function renderCreate()
        {
            // render view create
            // return view('create');
        }

        public function execStore(StoreUserRequest $request)
        {
            // exec store data
            // return $this->UserCommandService->store($request),
        }

        public function renderEdit(string $id)
        {
            // render view create
            // $findId = $this->UserQueryService->getByAttr([],['id' => $id],'first);
            // return view('edit', compact('findId'));
        }

        public function execUpdate(UpdateUserRequest $request, string $id)
        {
            // exec store data
            // return $this->UserCommandService->update($request, $id),
        }

        public function execDelete(string $id)
        {
            // exec store data
            // return $this->UserCommandService->delete($id),
        }
    }

    ```
### Persistance Layer
- Generate All Service Default (QueryService, DatatableService, CommandService)
  - This package helps you framework all the default services for you to interact with the database layer. To make all services default with Layerize, use the following command
    ```php
    php artisan layerize:service User -a
    ```
  - The result of the above command will give three class named `UserQueryService`,`UserCommandService`,`UserDatatableService` which will be added to the `App/Services/User` folder
  - `UserQueryService.php`
    ```php
    <?php

    namespace App\Services\User;

    use App\Services\Service;

    class UserQueryService extends Service
    {
        public function __construct()
        {
            // self::setModel(User::class); call your model class name to use getByAttr method
        }

        // Other Query Service here
        public function getCustomQuery(string $id)
        {
            // Other code here if query not support in getByAttr method
        }
    }

    ```
  - `UserCommandService.php`
    ```php
    <?php

    namespace App\Services\User;

    use App\Services\Service;

    class UserCommandService extends Service
    {
        // Command Service here
        public function store(StoreUserRequest $request)
        {
            // Code for store data
        }

        public function update(UpdateUserRequest $request, string $id)
        {
            // Code for update data
        }

        public function delete(string $id)
        {
            // Code for delete data
        }
    }

    ```
  - `UserDatatableService.php`
    ```php
    <?php

    namespace App\Services\DraftPembelianOpr;

    use App\Services\Service;

    class DraftPembelianOprDatatableService extends Service
    {
        // Datatable Service here

        public function datatable(Request $request)
        {
            // Datatable server side processing code here
        }
    }

    ```
- Generate Single Service
  - This package helps you framework a services for you to interact with the database layer. To make a services default with Layerize, use the following command
    ```php
    php artisan layerize:service Custom
    ```
  - The result of the above command will give a class named `CustomeService` which will be added to the `App/Services` folder
    ```php
    <?php

    namespace App\Services;
    use App\Services\Service;

    class CustomService extends Service
    {
        // Your service code here
    }
    ```
### Database Layer
- Model
  - There are no changes to the model, you can implement the model according to the Laravel framework standards

## Contributing

- [GanaDev Com](https://ganadev.com)
- Open Source, to contribution please read [CONTRIBUTING.md](https://github.com/deyan-ardi/laravel-layerize/blob/master/CONTRIBUTING.md)

## Version
- v1.0.3
  
## License

The Laravel Layerize is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
