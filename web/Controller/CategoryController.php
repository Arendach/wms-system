<?php

namespace Web\Controller;

use Web\Model\Category;
use Web\App\Controller;
use Web\Model\Coupon;

class CategoryController extends Controller
{
    /**
     * Категорії на екран
     */
    public function index()
    {
        $data = [
            'title' => 'Каталог :: Категорії товарів',
            'script' => 'category.js',
            'components' => ['modal', 'sweet_alert', 'breadcrumbs'],
            'section' => 'Категорії товарів',
            'categories' => Category::getCategories()
        ];

        $this->view->display('/category/index', $data);
    }

    /**
     * Віддаємо форму
     */
    public function get_form($data)
    {
        if ($data->form == 'create') {
            $data = [
                'title' => 'Додати нову категорію',
                'from' => 'add'
            ];
        } else {
            $data = [
                'title' => 'Редагування даних',
                'from' => 'update',
                'category' => Category::getOne($data->id)
            ];
        }
        $data['categories'] = Coupon::getCategories();
        $this->view->display('/category/modal', $data);
    }

    /**
     * Зберігаємо категорію
     */
    public function create($data)
    {
        Category::create($data);
    }

    /**
     * Оновлюємо категорію
     */
    public function update($data)
    {
        $id = $data->id;
        unset($data->id);
        unset($data->files);

        Category::update($data, $id);
    }

    /**
     * Форма редагування
     */
    public function modalUpdate($data)
    {
        $c = Category::getOne($data->id);
        $cats = Coupon::getCategories();
        $temp['id'] = $c->id;
        $temp['parent'] = $c->parent;
        $temp['name'] = $c->name;
        $temp['sort'] = $c->sort;
        $temp['categories'] = $cats;

        $temp['action'] = 'category/update';
        $temp['title'] = 'Обновити категорію';
        $temp['from'] = 'update';

        $this->view->display('/category/modal', $temp);
    }

    /**
     * Видалення категорії
     */
    public function delete($data)
    {
        Category::delete_parent($data->id);
    }

    /**
     * Видалення вибраних категорій
     */
    public function deleteSelectedCategory($data)
    {
        Category::deleteSelected($data);
    }
}