# Changelog
All notable changes to `Laravel Layerize` will be documented in this file
## 2.0.0 - What's New?
### Remove
- Remove support for general query service getByAttr
- Remove auto write end of class name (Request, Controller, UseCase, Service), now you must write full name of class (ex: php artisan layerize:dto Example => php artisan layerize:dto ExampleRequest)
- Remove end of class name (Service) from Service, now the service class name without Service (ex: ConfigQueryServices => ConfigQuery, ConfigDatatableServices => ConfigDatatable, ConfigCommandService => ConfigCommand)
### Add or Fixing
- Add new general query service method list function
- Bug fixing cant create file with folder when run php artisan layerize:service {serviceName} --all
- Fixing command, now to generate all request must use --all, not -a
- Fixing bug in example query
