<?php

namespace DeyanArdi\LaravelLayerize;

use Illuminate\Support\ServiceProvider;
use DeyanArdi\LaravelLayerize\Commands\CreateServiceCommand;

class LaravelLayerizeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateServiceCommand::class,
            ]);
        }
    }
}
