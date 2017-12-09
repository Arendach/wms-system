<?php

namespace Web\Controller;

use Web\Model\Attributes;
use Web\Model\Products;
use Web\Tools\Categories;
use Web\Tools\ImageUpload;
use Web\Model\Manufacturers;
use Web\Model\Storage;
use Web\App\Validator;
use Web\App\Controller;

class ProductController extends Controller
{
    /**
     * @GET
     * Товари на екран
     */
    public function index()
    {
        $products = Products::getAll(false);
        $data = [
            'title' => 'Каталог :: Товари',
            'section' => 'Товари',
            'scripts' => ['text_change.js', 'product.js'],
            'components' => ['breadcrumbs'],
            'products' => $products->data,
            'storage' => Storage::getAll(),
            'archive' => false,
            'paginate' => get_array($products->paginate)
        ];
        $this->view->display('/product/index', $data);
    }

    /**
     * @GET
     * Архівні товари на екран
     */
    public function archive()
    {
        $products = Products::getAll(true);
        $data = [
            'title' => 'Каталог :: Архів товарів',
            'section' => 'Архів товарів',
            'scripts' => ['text_change.js', 'product.js'],
            'components' => ['breadcrumbs'],
            'products' => $products->data,
            'archive' => true,
            'paginate' => get_array($products->paginate)
        ];

        $this->view->display('/product/index', $data);
    }

    /**
     * @GET
     * Форму додавання нового товару на екран
     */
    public function showAdd()
    {
        $data = [
            'title' => 'Товари',
            'section' => 'Додати новий товар',
            'scripts' => ['text_change.js', 'product.js', 'products/add.js'],
            'components' => ['ajax_upload'],
            'storageList' => Storage::getAll(),
            'manufacturers' => Manufacturers::all(),
            'categories' => Categories::get(),
            'images' => ImageUpload::get_temp_folder_files()
        ];

        $this->view->display('/product/add', $data);
    }

    /**
     * @GET
     * Форму оновленння товару на екран
     */
    public function update($id)
    {
        $products = Products::getProduct($id);
        if (my_count($products) == 0)
            $this->redirect(route('404'));

        $data = [
            'title' => 'Товари',
            'from' => 1,
            'to_js' => ['id' => $id],
            'route' => true,
            'scripts' => [
                'text_change.js',
                'product.js',
                'products/edit.js',
            ],
            'components' => ['breadcrumbs','sweet_alert', 'ajax_upload', 'jquery'],
            'product' => $products,
            'photos' => ImageUpload::get_product_photos($id),
            'imgsize' => get_object(['width' => 150, 'height' => 150]),
            'manufacturers' => Manufacturers::all(),
            'categories' => Categories::get(),
            'typeStorage' => ['const=0', '+/-'],
            'storageList' => Storage::getAll(),
        ];

        if ($data['product']->type_product == 'combine') {
            $data['isCombine'] = true;
            $data['CombineList'] = $this->prepareCombineList($id);
        }

        $this->view->display('/product/update', $data);
    }

    /**
     * @POST
     * Обробник запиту на оновлення
     */
    public function post_update($post)
    {
        $arr = ['attribute', 'type', 'info'];

        if (!isset($post->data))
            $post->data = [];
        if (in_array($post->method, $arr)) {
            $method_name = 'update_' . $post->method;
            $this->$method_name($post->data, $post->id);
        }
    }

    /**
     * @POST
     * Оновити аттрибути товару
     */
    public function update_attribute($data, $id)
    {
        Products::update_attribute(json_encode($data), $id);
    }

    /**
     * @POST
     * Оновити тип товара
     */
    public function update_type($data, $id)
    {
        Products::update_type($data, $id);
    }

    /**
     * @POST
     * Оновлення інформації про товар
     */
    public function update_info($data, $id)
    {
        Validator::run($data,
            [
                'name' => 'string',
                'articul' => 'string',
                'model' => 'string',
                'identefire_storage' => 'string',
                'manufacturer' => 'integer',
                'storage' => 'integer',
                'services_code' => 'integer',
                'count_on_storage' => 'integer',
                'procurement_costs' => 'float',
                'category' => 'integer',
                'costs' => 'float',
                'sort' => 'integer',
            ],
            [
                'name' => 'Заповніть назву товару!',
                'articul' => 'Заповніть артикул!',
                'model' => 'Заповніть модель! ',
                'identefire_storage' => 'Заповніть ідентифікатор для складу!',
                'manufacturer' => 'Виберіть виробника!',
                'storage' => 'Виберіть склад!',
                'services_code' => 'Заповніть сервісний код!',
                'count_on_storage' => 'Заповніть кількість товару на складі!',
                'procurement_costs' => 'Заповніть закупівельну вартість!',
                'category' => 'Виберіть категорію!',
                'costs' => 'Заповніть ціну!',
                'sort' => 'Сортування тільки цифри!',
            ]);
        if (!Validator::status()) {
            echo Validator::errors();
        } else {
            $data['volume'] = json_encode($data['volume']);
            Products::update($data, $id);
        }
    }

    /**
     * @GET
     * Товар в архів
     */
    public function to_archive($id)
    {
        if (Products::to_archive($id))
            $this->redirect('products/edit/' . (int)$id);
    }

    /**
     * @GET
     * Товар з архіву
     */
    public function un_archive($id)
    {
        if (Products::un_archive($id))
            $this->redirect('products/edit/' . (int)$id);
    }

    /**
     * @POST
     * Пошук товарів для комбінування
     */
    public function search_combine($post)
    {
        $data['options'] = Products::searchCombine($post->search);
        $this->view->display('/source/datalist', $data);
    }

    /**
     * @POST
     * Видалити товар
     */
    public function delete($id)
    {
        Products::delete($id);
    }

    /**
     * @POST
     * Пошук атрибутів
     */
    public function search_attribute($data)
    {
        $attr = Attributes::search($data->value);
        $this->view->display('/attributes/list', ['attrs' => $attr]);
    }

    /**
     * Генерація списку комбінованих товарів
     */
    protected function prepareCombineList($id)
    {
        return $this->view->render('/source/product/combinelist', ['combines' => Products::getCombine($id)]);
    }

    /**
     * @GET
     * Історію на екран
     */
    public function getHistory($id)
    {
        $data = [
            'title' => 'Історія товарів',
            'section' => 'Товари',
            'link_css' => ['changes.css'],
            'scripts' => ['textchange.js', 'product.js', 'products/history.js'],
            'histories' => Products::getHistory($id)
        ];

        $this->view->display('/product/history', $data);
    }

    /**
     * @POST
     * Зберігаємо істроію
     */
    public function save_history($data)
    {
        Products::saveHistory($data);
    }

    /**
     * Вивантажуємо зображення
     */
    public function upload_image($data)
    {
        res(ImageUpload::upload('image_upload', $data->id));
    }

    /**
     * Вивантажуємо зображення в тимчасову папку
     */

    public function new_upload_image()
    {
        res(ImageUpload::run('image_upload'));
    }

    /**
     * Видаляємо фото з товару(Тимчасові і Привязані до замовлення)
     */

    public function delete_temp_file($data)
    {
        res(ImageUpload::delete($data->path));
    }

    /**
     * @POST
     * Зберігаємо товар в базу даних
     */
    public function save($post)
    {
        $errors = [];

        if (empty($post->data['name']))
            $errors[] = 'Заповніть назву!';

        if (empty($post->data['articul']))
            $errors[] = 'Заповніть артикул!';

        if (empty($post->data['model']))
            $errors[] = 'Заповніть модель!';

        if (empty($post->data['identefire_storage']))
            $errors[] = 'Заповніть ідентифікатор складу!';

        if (empty($post->data['services_code']))
            $errors[] = 'Заповніть сервісний код!';

        if (empty($post->data['procurement_costs']))
            $errors[] = 'Заповніть закупівельну вартість!';

        if (empty($post->data['costs']))
            $errors[] = 'Заповніть ціну!';

        if (count($errors) > 0) {
            $response = '<ul class="text-danger">';
            foreach ($errors as $error)
                $response .= '<li>' . $error . '</li>';
            $response .= '</ul>';
            response(400, $response);
        } else {
            Products::save($post);
        }
    }

    /**
     * @param $post
     */
    public function copy($post)
    {
        if(preg_match('/^[1-9]$/', $post->amount)) {
            Products::copy($post->id, $post->amount);
        } else {
            Products::copy($post->id, 1);
        }
    }

    /**
     * @param $post
     */
    public function get_service_code($post)
    {
        $result = Products::get_service_code($post->id);

        if($result === false)
            response(400, 'Неправильні вхідні параметри!');
        elseif (is_int($result))
            response(200, (string)$result);
        else
            response(500, 'Невідома помилка!');
    }
}

?>