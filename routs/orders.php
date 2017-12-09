<?php

/**
 * @GET
 */
$app->get('/orders/add/{type}', ['as' => 'add_order', 'uses' => 'OrdersController/create_order'], ['access' => 'orders_create']);
$app->get('/order/{id}', ['as' => 'order', 'uses' => 'OrdersController/view_order'], ['access' => 'orders_view']);
$app->get('/orders', ['as' => 'orders_all', 'uses' => 'OrdersController/index'], ['access' => 'orders_view']);
$app->get('/orders/view/{type}', ['as' => 'orders', 'uses' => 'OrdersController/view_orders'], ['access' => 'orders_view']);
$app->get('/orders/edit/{id}', ['as' => 'order_update', 'uses' => 'OrdersController/edit'], ['access' => 'orders_update']);
$app->get('/orders/changes/{id}', ['as' => 'changes', 'uses' => 'OrdersController/changes'], ['access' => 'orders_view']);
$app->get('/orders/print/{id}', ['as' => 'print_order', 'uses' => 'Orders\PrintController/handle']);
$app->get('/orders/change_type', ['as' => 'change_type', 'uses' => 'OrdersController/change_type']);

/**
 * @POST
 */

$app->post('/orders/drop_product', 'OrdersController/drop_product', ['access' => 'orders_update']);
$app->post('/orders/save_product_to_order', 'OrdersController/save_product_to_order', ['access' => 'orders_update']);
$app->post('/orders/get_product_by_id', 'OrdersController/get_product_by_id', ['access' => 'orders_update']);
$app->post('/ajax/s_products', 'OrdersController/search_products', ['access' => 'orders_view']);
$app->post('/orders/export_xml', 'Orders\\ExportXMLController/handle');

$app->post('/orders/update', 'Orders\\UpdateController/handle');
$app->post('/orders/create', 'Orders\\CreateController/handle');