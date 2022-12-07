<?php

namespace Birim\Laravel\RestApi\Endpoints;

/**
 * Class SearchEndpoint
 * @package Birim\Laravel\RestApi\Endpoints
 */
class SearchEndpoint extends Endpoint
{
    protected $uri = 'search/{attribute}/{str}';

    public function register()
    {
        $this->get(function($attribute, $str) {
            $response = $this->queryBuilder()
                ->where($attribute, 'LIKE', '%' . $str . '%')
                ->select($this->selectAttributes())
                ->get();

            return $this->response($response);
        }, [
            'attribute' => '[a-zA-Z\_\-]+'
        ]);
    }
}
