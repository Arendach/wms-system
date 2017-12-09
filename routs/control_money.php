<?php
/**
 * Звіти співробітників
 * @GET
 */
$app->get('/control_money', ['as' => 'control_money', 'uses' => 'ControlMoneyController/index'], []);
$app->get('/control_money/create', ['as' => 'CMCreate', 'uses' => 'ControlMoney\CreateController/handle'], ['access'=> 'control_money_create']);

/**
 * @POST
 */
$app->post('/control_money/get_form', 'ControlMoneyController/get_form');
