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

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->post('/register', 'UserController@postCreateUser');
    $router->post('/login', 'UserController@postLogin');

    $router->group(['prefix' => 'confession', 'middleware' => 'passport'], function () use ($router) {
       $router->post('/posts', 'Confession\PostController@postCreatePost');
       $router->post('/comments', 'Confession\CommentController@postCreateComment');

       $router->post('/like/posts', 'Confession\PostController@postUserLikePost');
       $router->post('/like/comments', 'Confession\CommentController@postUserLikeComment');

       $router->get('/samples', 'Confession\PostController@getSample');
       $router->get('/lists', 'Confession\PostController@getLists');
    });
});
