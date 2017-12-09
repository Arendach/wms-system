<?php

/**
 * Виробники
 * @GET
 */
$app->get('/manufacturer', ['as' => 'manufacture', 'uses' => 'ManufacturerController/index'], ['access' => ['manufacture_view']]);

/**
 * Виробники
 * @POST
 */
$app->post('/manufacturer/showAdd', 'ManufacturerController/showAdd', ['access' => 'manufacture_create']);
$app->post('/manufacturer/add', 'ManufacturerController/add', ['access' => 'manufacture_create']);
$app->post('/manufacturer/delete', 'ManufacturerController/delete', ['access' => 'manufacture_delete']);
$app->post('/manufacturer/update', 'ManufacturerController/updateManufacturer', ['access' => 'manufacture_update']);
$app->post('/manufacturer/save', 'ManufacturerController/saveManufacturer', ['access' => 'manufacture_update']);
$app->post('/manufacturer/print', 'ManufacturerController/printManufacturer', ['access' => 'manufacture_view']);

/**
 * Групи виробників
 * @GET
 */
$app->get('/manufacture_groups', ['as' => 'manufacture_group', 'uses' => 'ManufacturerGroupsController/index'], ['access' => 'manufacture_group_view']);
$app->post('/manufacture_groups/get_form', 'ManufacturerGroupsController/get_form', ['access' => 'manufacture_group_update']);
$app->post('/manufacture_groups/create', 'ManufacturerGroupsController/create', ['access' => 'manufacture_group_create']);
$app->post('/manufacture_groups/update', 'ManufacturerGroupsController/update', ['access' => 'manufacture_group_update']);
$app->post('/manufacture_groups/delete', 'ManufacturerGroupsController/delete', ['access' => 'manufacture_group_delete']);

/**
 * @POST
 */
$app->get('/storage', ['as' => 'storage', 'uses' => 'StorageController/index'], ['access' => 'storage_view']);
$app->post('/storage/get_form', 'StorageController/get_form');
$app->post('/storage/create', 'StorageController/create', ['access' => 'storage_create']);
$app->post('/storage/update', 'StorageController/update', ['access' => 'storage_update']);
$app->post('/storage/delete', 'StorageController/delete', ['access' => 'storage_delete']);
