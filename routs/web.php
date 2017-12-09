<?php

$app->get('/', ['as' => 'index', 'uses' => 'IndexController/index']);

/**
 * Автентифікація
 * @GET
 */
$app->get('/login', ['as' => 'login', 'uses' => 'UserController/get_login_form'], ['exception' => true]);
$app->get('/logout', ['as' => 'logout', 'uses' => ''], ['middleware' => ['logout'], 'exception' => true]);
$app->get('/reset_password', ['as' => 'reset', 'uses' => 'UserController/get_reset_password'], ['exception' => true]);

/**
 * Автентифікація
 * @POST
 */
$app->post('/login', 'UserController/post_login', ['exception' => true]);
$app->post('/reset_password', 'UserController/post_reset_password', ['exception' => true]);

/**
 * Інше
 * @GET
 */
$app->get('/error/access_denied', ['as' => 'access_denied', 'uses' => function () {
    echo 'access denied';
    exit;
}], ['exception' => true]);
$app->get('/page/error_404', ['as' => '404', 'uses' => 'PageController/error_404', 'exception' => true]);
$app->get('/test', 'TestController/index');

$app->get('/profile', ['as' => 'profile', 'uses' => 'UserController/profile']);