<?php
/**
 * @GET
 */
$app->get('/clients', ['as' => 'clients', 'uses' => 'ClientsController/index'], ['access' => 'clients_view']);
$app->get('/clients/{id}', 'ClientsController/view', ['access' => ['clients_view']]);
$app->get('/client/orders/{id}', ['as' => 'client_orders', 'uses' => 'ClientsController/get_orders'], ['access' => 'clients_view']);

/**
 * @POST
 */
$app->post('/clients/create', 'ClientsController/create', ['access' => 'clients_create']);
$app->post('/clients/update', 'ClientsController/update', ['access' => 'clients_update']);
$app->post('/clients/delete', 'ClientsController/delete', ['access' => 'clients_delete']);
$app->post('/clients/order_remove', 'ClientsController/order_remove', ['access' => 'clients_update']);
$app->post('/clients/get_form', 'ClientsController/get_form', ['access' => 'clients_update']);
$app->post('/clients/search_order', 'ClientsController/search_order', ['access' => 'clients_update']);
$app->post('/clients/save_orders', 'ClientsController/save_orders', ['access' => 'clients_update']);

/**
 * @GET
 */
$app->get('/clients_group', ['as' => 'client_group', 'uses' => 'ClientsGroupController/index'], ['access' => 'clients_group_view']);

/**
 * @POST
 */
$app->post('/clients_group/create', 'ClientsGroupController/create', ['access' => 'clients_group_create']);
$app->post('/clients_group/edit', 'ClientsGroupController/edit', ['access' => 'clients_group_update']);
$app->post('/clients_group/get_form', 'ClientsGroupController/get_form', ['access' => 'clients_group_update']);
$app->post('/clients_group/delete', 'ClientsGroupController/delete', ['access' => 'clients_group_delete']);
