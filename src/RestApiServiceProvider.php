<?php

namespace Birim\Laravel\RestApi;

use Birim\Laravel\Payone\Payone;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Class RestApiServiceProvider
 * @package Birim\Laravel\RestApi
 */
class RestApiServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom( __DIR__ . '/config/rest-api.php', 'laravel-rest-api');
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/rest-api.php' => config_path('rest-api.php'),
        ], 'laravel-rest-api');

        (RestApi::getInstance())->boot();
    }
}
