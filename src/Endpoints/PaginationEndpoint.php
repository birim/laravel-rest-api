<?php

namespace Birim\Laravel\RestApi\Endpoints;

/**
 * Class ListEndpoint
 * @package Birim\Laravel\RestApi\Endpoints
 */
class PaginationEndpoint extends Endpoint
{
    protected $uri = 'skip/{skip}/take/{take}';

    public function register()
    {
        $this->get(function($skip, $take) {
            $response = $this->queryBuilder()
                ->select($this->selectAttributes())
                ->skip($skip)
                ->take($take)
                ->get();

            return $this->response($response);
        }, [
            'skip' => '[0-9]+',
            'take' => '[0-9]+',
        ]);
    }
}
