<?php

/**
 * Аттрибути
 * @GET
 */
$app->get('/attribute', ['as' => 'attributes', 'uses' => 'AttributeController/index'], ['access' => 'attribute_view']);

/**
 * @POST
 */
$app->post('/attribute/get_form', 'AttributeController/get_form', ['access' => 'attribute_update']);
$app->post('/attribute/create', 'AttributeController/create', ['access' => 'attribute_create']);
$app->post('/attribute/update', 'AttributeController/update', ['access' => 'attribute_update']);
$app->post('/attribute/delete', 'AttributeController/delete', ['access' => 'attribute_delete']);
$app->post('/attribute/search', 'ProductController/search_attribute');

