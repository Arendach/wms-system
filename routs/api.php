<?php

$app->get('/api', 'APIController/index');

$app->post('/api/search_village', 'APIController/search_village');

$app->post('/api/get_city', 'APIController/get_city');

$app->post('/api/search_streets', 'APIController/search_streets');
$app->post('/api/search_coupon', 'APIController/search_coupon');
$app->post('/log', 'LogController/write');

$app->get('/api_post', 'APIController/api_post');

$app->post('/api/search_warehouses', 'APIController/search_warehouses');
$app->post('/api/clean', 'APIController/clean');