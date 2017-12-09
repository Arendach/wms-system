<?php

/**
 * @GET
 */
$app->get('/manager/{id}', ['as' => 'manager', 'uses' => 'UserController/manager_view'], ['access' => 'managers_view']);
$app->get('/managers', ['as' => 'managers', 'uses' => 'UserController/all'], ['access' => 'managers_view']);
$app->get('/managers/register', ['as' => 'register', 'uses' => 'UserController/register']);
$app->get('/manager/update/{id}', 'UserController/update', ['access' => 'managers_update']);
$app->get('/manager/access_setting/{id}', ['as' => 'access_setting', 'uses' => 'UserController/access_setting'], ['access' => 'managers_access']);
$app->get('/manager/edit/{id}', ['as' => 'manager_edit', 'uses' => 'UserController/manager_edit'], ['access' => 'managers_update']);

/**
 * @POST
 */
$app->post('/manager/update', 'UserController/update_info', ['access' => 'managers_update']);
$app->post('/manager/update_password', 'UserController/update_password', ['access' => 'managers_update']);
$app->post('/managers/create', 'UserController/post_register');

/**
 * @GET
 */

$app->get('/access_groups', ['as' => 'access_groups', 'uses' => 'AccessController/access_groups']);
$app->get('/access_group/create', ['as' => 'access_group_create', 'uses' => 'AccessController/access_group_create']);
$app->get('/access_group/{id}', ['as' => 'access_group', 'uses' => 'AccessController/access_group']);

/**
 * @POST
 */
$app->post('/access_group/create', ['as' => 'access_group_create', 'uses' => 'AccessController/access_group_create_post']);
$app->post('/access_group/update', 'AccessController/update_group');
$app->post('/access_group/delete', 'AccessController/group_delete');

/**
 * @GET
 */

$app->get('/profile/update_password', ['as' => 'password_update','uses' => 'UserController/post_update_password']);