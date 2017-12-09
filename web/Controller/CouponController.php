<?php

namespace Web\Controller;

use Web\Model\Coupon;
use Web\App\Controller;
use Web\App\Log;

class CouponController extends Controller
{
    private $forms = ['edit', 'create', 'cumulative', 'stationary'];

    /**
     * @GET
     */
    public function index()
    {
        $data = [
            'coupons' => Coupon::getAll(),
            'title' => 'Продажі :: Купони',
            'section' => 'Купони',
            'components' => ['modal', 'sweet_alert', 'breadcrumbs'],
            'scripts' => ['coupon/index.js']
        ];
        $this->view->display('/coupon/index', $data);
    }

    /**
     * @POST
     */
    public function get_form($data)
    {
        if (in_array($data->form, $this->forms)) {
            $method_name = $data->form . '_form';
            if (isset($data->data))
                $this->$method_name(get_object($data->data));
            else
                $this->$method_name();
        } else {
            $error = 'Помилка! Форма не знайдена!!';
            Log::error($error . ' Контроллер CouponController, метод get_form()!', 'ajax_request_form');
            status('0', $error);
        }
    }

    /**
     * @FORM
     */
    public function edit_form($post)
    {
        $coupon = Coupon::getOne($post->id);
        $data = [
            'title' => 'Редагування купона',
            'coupon' => $coupon
        ];
        if ($coupon->type == 1)
            $data['cumulative'] = Coupon::get_accumulation($post->id);
        echo $this->view->render('/coupon/forms/update', $data);
    }

    /**
     * @FORM
     */
    public function cumulative_form()
    {
        echo $this->view->render('/coupon/forms/cumulative');
    }

    /**
     * @FORM
     */
    public function stationary_form()
    {
        echo $this->view->render('/coupon/forms/stationary');
    }

    /**
     * @FORM
     */
    public function create_form()
    {
        $data = ['title' => 'Новий купон'];
        echo $this->view->render('/coupon/forms/create', $data);
    }

    /**
     * @POST
     */
    public function update($post)
    {
        $post = get_object($post);

        if ($post->data->type == 'cumulative')
            Coupon::update_cumulative($post->data, $post->id);
        else
            Coupon::update($post->data, $post->id);
    }

    /**
     * @POST
     */
    public function delete($post)
    {
        Coupon::delete($post->id);
    }

    /**
     * @POST
     * @param $post
     */
    public function create($post)
    {
        if ($post->type_coupon == 0) {
            Coupon::insert($post);
        } else {
            Coupon::insert_cumulative($post);
        }
    }
}