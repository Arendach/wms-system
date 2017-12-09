<?php

/**
 * Закупки
 * @GET
 */
$app->get('/purchases', ['as' => 'purchases', 'uses' => 'PurchasesController/index']);
$app->get('/purchases/update/{id}', ['as' => 'purchases_update', 'uses' => 'PurchasesController/update']);
$app->get('/purchases/create', ['as' => 'purchases_create', 'uses' => 'PurchasesController/create']);
$app->get('/purchases/print/{id}', ['as' => 'purchases_print', 'uses' => 'PurchasesController/print_']);

/**
 * @POST
 */
$app->post('/purchases/get_products', 'PurchasesController/getProducts');
$app->post('/purchases/search_products', 'PurchasesController/searchProducts');
$app->post('/purchases/update', 'PurchasesController/post_update');
$app->post('/purchases/update_info', 'PurchasesController/update_info');
$app->post('/purchases/create', 'PurchasesController/post_create');
$app->post('/purchases/close_form', 'PurchasesController/close_form');
$app->post('/purchases/close', 'PurchasesController/close');