<?php
/**
 * Графік роботи
 * @GET
 */
$app->get('/work_schedule', ['as' => 'work_schedule', 'uses' => 'WorkScheduleController/index'], ['access' => 'work_schedule_view']);

/**
 * POST
 */
$app->post('/work_schedule/get_form', 'WorkScheduleController/get_form');
$app->post('/work_schedule/update', 'WorkScheduleController/update');
$app->post('/work_schedule/create', 'WorkScheduleController/create');
