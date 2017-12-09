<?php

/**
 * @GET
 */
$app->get('/orders/settings', ['as' => 'couriers', 'uses' => 'OrdersSettingsController/index'], ['access' => 'settings_view']);
$app->get('/orders/settings/logistics', ['as' => 'logistics', 'uses' => 'OrdersSettingsController/logistics_view'], ['access' => 'settings_view']);
$app->get('/orders/settings/pay', ['as' => 'pays', 'uses' => 'OrdersSettingsController/pay_view'], ['access' => 'settings_view']);
$app->get('/orders/settings/color', ['as' => 'colors', 'uses' => 'OrdersSettingsController/color_view'], ['access' => 'settings_view']);
$app->get('/orders/settings/region', ['as' => 'regions', 'uses' => 'OrdersSettingsController/region_view'], ['access' => 'settings_view']);

/**
 * @POST
 */
$app->post('/orders/settings/get_form', 'OrdersSettingsController/get_form', ['access' => 'settings_update']);
$app->post('/orders/settings/create', 'OrdersSettingsController/save', ['access' => 'settings_create']);
$app->post('/orders/settings/update', 'OrdersSettingsController/update', ['access' => 'settings_update']);
$app->post('/orders/settings/delete', 'OrdersSettingsController/remove', ['access' => 'settings_delete']);
