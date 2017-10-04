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

// User routes //

$router->group(['prefix'=> 'api/v1'], function ($router){
    $router->post('/auth/login', 'AuthController@loginPost');
    $router->get('/users/', 'UserController@index');
    $router->post('/users/', 'UserController@store');
    $router->get('/users/{user_id}', 'UserController@show');
    $router->put('/users/{user_id}', 'UserController@update');
    $router->delete('/users/{user_id}', 'UserController@destroy');
});


// Bucketlist Routes //

$router->group(['prefix'=>'api/v1','middleware'=>'auth'], function ($router) {
    $router->get('/bucketlists', 'BucketlistController@index');
    $router->post('/bucketlists', 'BucketlistController@store');
    $router->get('/bucketlists/{bucketlist_id}', 'BucketlistController@show');
    $router->put('/bucketlists/{bucketlist_id}', 'BucketlistController@update');
    $router->delete('/bucketlists/{bucketlist_id}', 'BucketlistController@destroy');
});

// Item routes //

$router->group(['prefix'=>'api/v1'], function ($router) {
    $router->get('/bucketlists/{bucketlist_id/items', 'ItemController@index');
    $router->post('/bucketlists/{bucketlist_id/items', 'ItemController@store');
    $router->get('/bucketlists/{bucketlist_id/items/{items_id}', 'ItemController@store');
    $router->put('/bucketlists/{bucketlist_id/items/{items_id}', 'ItemController@store');
    $router->delete('/bucketlists/{bucketlist_id/items/{items_id}', 'ItemController@store');
});