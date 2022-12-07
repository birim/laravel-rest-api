<?php
namespace Birim\Laravel\RestApi\Endpoints;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/**
 * Class Endpoint
 * @package Birim\Laravel\RestApi\Endpoints
 */
abstract class Endpoint
{
    protected $uri = '';

    protected $name = '';

    protected $endpoint = '';

    protected $model = null;

    protected $modelObject = null;

    /**
     * JsonEndpoint constructor.
     * @param Model $model
     * @param $name
     */
    public function __construct($model, $name)
    {
        $this->name = $name;
        $this->model = $model;
        $this->modelObject = new $model();
    }

    /**
     * Register GET route
     * @param callable $callback
     * @param array $where
     */
    public function get(callable $callback, array $where = [])
    {
        Route::get($this->uri(), $callback)->where($where);
    }

    /**
     * @return string[]
     */
    public function selectAttributes()
    {
        if (property_exists($this->modelObject, 'restApiAttributes') &&
            is_array($this->modelObject->restApiAttributes)) {
            return $this->modelObject->restApiAttributes;
        }

        return ['*'];
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function queryBuilder()
    {
        return DB::table($this->modelObject->getTable());
    }

    /**
     * Get route url
     * @param $string
     * @return string
     */
    public function uri()
    {
        return 'laravel-json/' . $this->name . ($this->uri ? '/' . $this->uri : '');
    }

    /**
     * @param Collection $collection
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(Collection $collection)
    {
        if (property_exists($this->modelObject, 'restApiHiddenAttributes') &&
            is_array($this->modelObject->restApiHiddenAttributes)) {
            $collection->transform(function($item) {
                foreach ($this->modelObject->restApiHiddenAttributes as $key) {
                    unset($item->$key);
                }
                return $item;
            });
        }

        return response()->json($collection);
    }
}
