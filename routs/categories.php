<?php

/**
 * Категорії товарів
 * @GET
 */
$app->get('/category', ['as' => 'category', 'uses' => 'CategoryController/index'], ['access' => 'category_view']);

/**
 * @POST
 */
$app->post('/category/get_form', 'CategoryController/get_form', ['access' => 'category_update']);
$app->post('/category/delete', 'CategoryController/delete', ['access' => 'category_delete']);
$app->post('/category/update', 'CategoryController/update', ['access' => 'category_update']);
$app->post('/category/create', 'CategoryController/create', ['access' => 'category_create']);
$app->post('/category/deleteSelected', 'CategoryController/deleteSelectedCategory', ['access' => 'category_delete']);
