<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(
    [
        'prefix' => 'api',
    ],
    function ($router) {
        /**
         * Guest Routes
         */
        $router->group(
            [
                'prefix' => 'api',
            ],
            function ($router) {
                $router->post(
                    '/register', [
                        'as' => 'auth.register',
                        'uses' => 'AuthController@register',
                    ]
                );

                $router->post(
                    '/login', [
                        'as' => 'auth.login',
                        'uses' => 'AuthController@login',
                    ]
                );
            }
        );

        $router->group(
            [
                'prefix' => 'products',
            ],
            function ($router) {
                $router->get(
                    '/', [
                        'as' => 'products.index',
                        'uses' => 'ProductController@index',
                    ]
                );

                // Store product
                $router->post(
                    '/', [
                        'as' => 'products.store',
                        'uses' => 'ProductController@create',
                    ]
                );

                //product details
                $router->get(
                    '/detail', [
                        'as' => 'products.show',
                        'uses' => 'ProductController@show',
                    ]
                );
                // Update Product
                $router->put(
                    '/',
                    [
                        'as' => 'products.update',
                        'uses' => 'ProductController@update',
                    ]
                );

                // Delete product table data
                $router->delete(
                    '/',
                    [
                        'as' => 'products.delete',
                        'uses' => 'ProductController@destroy',
                    ]
                );
            }
        );
    });

