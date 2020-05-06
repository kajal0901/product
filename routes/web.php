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
         * Route Request for register
         */
        $router->post(
            '/register', [
                'as' => 'auth.register',
                'uses' => 'AuthController@register',
            ]
        );
        /**
         * Route for login
         */
        $router->post(
            '/login', [
                'as' => 'auth.login',
                'uses' => 'AuthController@login',
            ]
        );
        /**
         * show product list
         */
        $router->get(
            '/productsList', [
                'as' => 'products.index',
                'uses' => 'ProductController@index',
            ]
        );

        // Store product
        $router->post(
            '/products', [
                'as' => 'products.store',
                'uses' => 'ProductController@create',
            ]
        );

        //product details
        $router->get(
            '/products/{id}', [
                'as' => 'products.show',
                'uses' => 'ProductController@show',
            ]
        );
        // Update Product
        $router->put(
            '/products/{id}',
            [
                'as' => 'products.update',
                'uses' => 'ProductController@update',
            ]
        );

        // Delete product table data
        $router->delete(
            '/products/{id}',
            [
                'as' => 'products.delete',
                'uses' => 'ProductController@destroy',
            ]
        );

        //Rote request for create cart
        $router->post(
            '/cart',
            [
                'as' => 'carts.create',
                'uses' => 'CartController@store',
            ]
        );

        // empty cart
        $router->delete(
            '/carts/{id}',
            [
                'as' => 'carts.empty',
                'uses' => 'CartController@destroy',
            ]
        );

        // Cart  Update
        $router->put(
            '/carts/{id}',
            [
                'as' => 'carts.update',
                'uses' => 'CartController@update',
            ]
        );
    }
);



