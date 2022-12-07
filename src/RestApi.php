<?php

namespace Birim\Laravel\RestApi;


use Birim\Laravel\RestApi\Endpoints\Endpoint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

/**
 * Class RestApi
 * @package Birim\Laravel\RestApi
 */
final class RestApi
{
    private static $instance = null;
    private $endpointObjects = [];

    /**
     * Load and register available endpoints
     * @throws \ReflectionException
     */
    public function boot()
    {
        $endpoints = [];
        foreach (File::allFiles(__DIR__ . '/Endpoints') as $file) {
            $endpointClassName = '\\Birim\\Laravel\\RestApi\\Endpoints\\' . $file->getFilenameWithoutExtension();
            if ((new \ReflectionClass($endpointClassName))->isSubclassOf(Endpoint::class)) {
                $endpoints[] = $endpointClassName;
            }
        }

        foreach (Config::get('rest-api.endpoints', []) as $name => $model) {
            if ((new \ReflectionClass($model))->isSubclassOf(Model::class)) {
                foreach ($endpoints as $endpoint) {
                    $object = new $endpoint($model, $name);
                    $object->register();
                    array_Push($this->endpointObjects, $object);
                }
            }
        }

        // Register default endpoint
        Route::get('laravel-json', function() {
            $uris = [];
            foreach ($this->endpointObjects as $object) {
                array_push($uris, $object->uri());
            }
            return response()->json($uris);
        });
    }

    /**
     * Gets the instance via lazy initialization (created on first usage)
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Is not allowed to call from outside to prevent from creating multiple instances,
     * to use the singleton, you have to obtain the instance from Singleton::getInstance() instead
     */
    private function __construct()
    {
    }

    /**
     * Prevent the instance from being cloned (which would create a second instance of it)
     */
    private function __clone()
    {
    }

    /**
     * @throws \Exception
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
}
