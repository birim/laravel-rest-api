<?php

namespace Birim\Laravel\RestApi\Endpoints;

/**
 * Class ListEndpoint
 * @package Birim\Laravel\RestApi\Endpoints
 */
class ListEndpoint extends Endpoint
{
    public function register()
    {
        $this->get(function() {
            $response = $this->queryBuilder()
                ->select($this->selectAttributes())
                ->get();

            return $this->response($response);
        });
    }
}
