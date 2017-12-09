<?php

/**
 * @GET
 */
$app->get('/products', ['as' => 'products', 'uses' => 'ProductController/index'], ['access' => 'products_view']);
$app->get('/products/archive', ['as' => 'products_archive', 'uses' => 'ProductController/archive'], ['access' => 'products_view']);
$app->get('/products/add', ['as' => 'add_product', 'uses' => 'ProductController/showAdd'], ['access' => 'products_create']);
$app->get('/products/to_archive/{id}', ['as' => 'to_archive', 'uses' => 'ProductController/to_archive'], ['access' => 'products_update']);
$app->get('/products/un_archive/{id}', ['as' => 'un_archive', 'uses' => 'ProductController/un_archive'], ['access' => 'products_update']);
$app->get('/products/edit/{id}', ['as' => 'product_update', 'uses' => 'ProductController/update'], ['access' => 'products_update']);
$app->get('/products/search_product', 'ProductController/searchInTable');
$app->get('/products/history/{id}', ['as' => 'history_product', 'uses' => 'ProductController/getHistory'], ['access' => 'products_view']);

/**
 * @POST
 */
$app->post('/products/upload_image', 'ProductController/upload_image', ['access' => 'products_create']);
$app->post('/products/update', 'ProductController/post_update', ['access' => 'products_update']);
$app->post('/products/new_upload_image', 'ProductController/new_upload_image', ['access' => 'products_update']);
$app->post('/delete_temp_file', 'ProductController/delete_temp_file', ['access' => 'products_update']);
$app->post('/products/save', 'ProductController/save', ['access' => 'products_create']);
$app->post('/products/delete', 'ProductController/delete', ['access' => 'products_delete']);
$app->post('/products/edit', 'ProductController/updateAction', ['access' => 'products_update']);
$app->post('/products/search', 'ProductController/search_combine');
$app->post('/products/history/save', 'ProductController/saveHistory');
$app->post('/products/copy', ['as' => 'copy_product', 'uses' => 'ProductController/copy']);
$app->post('/products/get_service_code', 'ProductController/get_service_code');
