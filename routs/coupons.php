<?php
/**
 * Купони
 * @GET
 */
$app->get('/coupons', ['as' => 'coupons', 'uses' => 'CouponController/index'], ['access' => 'coupons_view']);

/**
 * @POST
 */
$app->post('/coupons/create', 'CouponController/create', ['access' => 'coupons_create']);
$app->post('/coupons/update', 'CouponController/update', ['access' => 'coupons_update']);
$app->post('/coupon/get_form', 'CouponController/get_form', ['access' => 'coupons_update']);
$app->post('/coupons/delete', 'CouponController/delete', ['access' => 'coupons_delete']);
