<?php

namespace Bigsnowfr\Larastats;

use Illuminate\Support\ServiceProvider;

class LarastatsServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'larastats');

        $this->publishes([
          __DIR__ . '/../resources/views' => resource_path('views/vendor/larastats'),
        ]);
    }

    public function register()
    {
        return new LarastatsService();
    }
}