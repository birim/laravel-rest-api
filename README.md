# Laravel REST API

The Laravel REST API provides an interface for applications to interact with your application by sending and receiving data as JSON.

## Installation

You can install the package via composer:
```
composer require birim/laravel-rest-api
```
You can publish the config file with:
```
php artisan vendor:publish --tag=laravel-rest-api
```

## Configuration

First define the endpoints for your REST API in the configuration file.
An endpoint contains a label and refers to an Eloquent class. Example:

```
<?php

return [
    'endpoints' => [
        'users' => App\Models\User::class
    ]
];
```

## Routes

After configuration, the REST API endpoints can be called. All endpoints start with laravel-json.

Currently, three types of endpoints are provided: List, Pagination and Search. 

URI | Method | Description 
--- | --- | ---
/laravel-json/users | GET | Get all users
/laravel-json/users/skip/0/take/10 | GET | Get users by skip and take
/laravel-json/users/search/name/john | GET | Get all users with the name john

All available endpoints can be accessed with **/laravel-json**

## Response

Returned data can optionally be configured within the Eloquent Model files. The **$restApiAttributes** property defines all attributes that should be returned. Without this property all attributes will be returned. If you want to exclude only certain attributes, you can use the **$restApiHidden** property.

```
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExampleModel extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public $restApiAttributes = [
        'name',
        'email'
    ];

    public $restApiHiddenAttributes = [
        'name'
    ];
```

## Changelog

Please read [CHANGELOG](CHANGELOG.md) for more information of what was changed recently.

## License

This project and the Laravel framework are open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

