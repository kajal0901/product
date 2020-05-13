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
            '/products', [
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

        // search Api by Price
        $router->post(
            '/products',
            [
                'as' => 'curl.index',
                'uses' => 'DataController@postRequest',
            ]
        );

        // search Api by Price
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

        // call curl request
        $router->post(
            '/curlPost',
            [
                'as' => 'curl.postData',
                'uses' => 'DataController@postRequest',
            ]
        );
    }

        $router->get(
            '/services', [
                'as' => 'services.index',
                'uses' => 'TestController@index',
            ]
        );

        $router->get(
            '/users',[
                'as'=>'users.index',
                'uses'=>'AuthController@index'
            ]
        );

        /**
         * User delete Route Request
         */
        $router->delete(
            '/users/{id}',
            [
                'as' => 'users.delete',
                'uses' => 'AuthController@destroy',
            ]
        );

        /**
         * User detail
         */
        $router->get(
            '/users/{id}',
            [
                'as' => 'users.delete',
                'uses' => 'AuthController@findUserById',
            ]
        );

        // Store order
        $router->post(
            '/order', [
                'as' => 'order.store',
                'uses' => 'OrderController@create',
            ]
        );

        // Order detail
        $router->get(
            '/order/{id}', [
                'as' => 'order.show',
                'uses' => 'OrderController@show',
            ]
        );

        // show order list
        $router->get(
            '/orders', [
                'as' => 'order.index',
                'uses' => 'OrderController@index',
            ]
        );

        //order update
        $router->put(
            '/order/{id}',
            [
                'as' => 'order.update',
                'uses' => 'OrderController@update',
            ]
        );

        //order delete
        $router->delete(
            '/order/{id}',
            [
                'as' => 'order.delete',
                'uses' => 'OrderController@destroy',
            ]
        );
    }
);



