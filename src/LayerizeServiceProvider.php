<?php

namespace DeyanArdi\LaravelLayerize;

use DeyanArdi\LaravelLayerize\Commands\CreateControllerCommand;
use DeyanArdi\LaravelLayerize\Commands\CreateDtoCommand;
use Illuminate\Support\ServiceProvider;
use DeyanArdi\LaravelLayerize\Commands\CreateServiceCommand;
use DeyanArdi\LaravelLayerize\Commands\CreateUseCaseCommand;

class LayerizeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateServiceCommand::class,
                CreateUseCaseCommand::class,
                CreateControllerCommand::class,
                CreateDtoCommand::class
            ]);
        }
    }
}
