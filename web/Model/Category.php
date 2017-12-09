<?php

namespace Web\Model;

use Web\Model\Settings\BasicModel AS Model;
use RedBeanPHP\R;

class Category extends Model
{
    const table = 'categories';
    const parent = 'parent';

    /**
     * @return array
     */
    public static function getMain()
    {
        return R::findAll('categories', '`parent` = \'0\'');
    }

    /**
     * @param $id
     * @param bool $table
     * @return array
     */
    public static function getOne($id, $table = false)
    {
        return R::getRow('
            SELECT 
                `categories`.*,
                `c`.`name` AS `parent_name`
            FROM 
                `categories`
            LEFT JOIN `categories` AS `c` ON (`c`.`id` = `categories`.`parent`) 
            WHERE 
                `categories`.`id` = ' . $id);
    }

    /**
     * @param $selected
     */
    public static function deleteSelected($selected)
    {
        foreach ($selected->ids as $id) {
            R::exec('DELETE FROM `categories` WHERE `id` = ' . $id);
            R::exec('DELETE FROM `categories` WHERE `parent` = ' . $id);
        }
        status('1');
    }

    /**
     * @param $id
     */
    public static function deleteOne($id)
    {
        try {
            R::exec('DELETE FROM `categories` WHERE `id` = ' . $id);
            R::exec('DELETE FROM `categories` WHERE `parent` = ' . $id);
            response(200, 'Виконано! Категорію вдало видалено!');
        } catch (\Exception $err){
            response(500, 'Помилка! Категорію не видалено!');
        }
    }

    /**
     * @param $arr
     */
    public static function linkingWithProduct($arr)
    {
        //return $this->db->insert('product_to_category', $arr);
    }

    /**
     * @param $id
     * @param $new_id
     */
    public static function updateRelation($id, $new_id)
    {
        R::exec('UPDATE `product_to_category` SET category_id = \''.$new_id.'\' WHERE category_id = \'' . $id .'\'');
        status('1');
    }

    /**
     * @return bool|string
     */
    public static function getCategories()
    {
        $rs = R::findAll('categories');

        if(my_count($rs) == 0)
            return false;

        foreach ($rs as $row) {
            if (empty($arr_cat[$row['parent']])) {
                $arr_cat[$row['parent']] = array();
            }
            $arr_cat[$row['parent']][] = $row;
        }
        $str = Category::getStings(Category::create_tree($arr_cat, ['id' => 'id', 'name' => 'name', 'service_code' => 'service_code'], 0), '');

        return $str;
    }

    /**
     * @param $arr
     * @param array $fields
     * @param int $parent_id
     * @param int $level
     * @return string
     */
    public static function create_tree($arr, $fields = [], $parent_id = 0, $level = 0)
    {
        if (empty($arr[$parent_id])) return '';
        $level++;
        for ($i = 0; $i < count($arr[$parent_id]); $i++) {
            foreach ($fields as $k => $v) $strs[$i][$k] = $arr[$parent_id][$i][$v];
            $strs[$i]['level'] = $level;
            $strs[$i]['childrens'] = Category::create_tree($arr, $fields, $arr[$parent_id][$i]['id'], $level);
        }
        return $strs;
    }

    /**
     * @param $arr
     * @param $str
     * @param string $parent
     * @return string
     */
    public static function getStings($arr, $str, $parent = '')
    {
        if (is_array($arr)) {
            foreach ($arr as $category) {
                $str .= '<tr>
	                <td style="width: 36px;"><input type="checkbox" class="delSelected" value="' . $category['id'] . '"</td>
	                  <td>' . $parent . $category['name'] . '</td>
	                  <td>' . $category['service_code'] . '</td>
	                  <td style="width: 69px;"> 
                      <a href="#" class="get_form btn btn-primary btn-xs" data-id="' . $category['id'] . '" data-form="update" title="Редагувати"><span class="glyphicon glyphicon-pencil"></span></a>
                      <a href="#" class="delete btn btn-danger btn-xs" data-id="' . $category['id'] . '" title="Видалити"><span class="glyphicon glyphicon-remove"></span></a></td>
                  
	                </tr>';
                if (isset($category['childrens']) and is_array($category['childrens']))
                    $str = Category::getStings($category['childrens'], $str, $parent . "	&ensp;	&ensp;");
            }
            return $str;
        } else {
            return '';
        }
    }

    /**
     * @param $data
     */
    public static function create($data)
    {
        try {
            $c = R::dispense('categories');
            foreach ($data as $k => $v)
                $c->$k = $v;
            R::store($c);
            response(200, 'Виконано! Категорію вдало створено!');
        } catch (\Exception $error) {
            response(500, 'Помилка! Категорыю не створено!');
        }
    }

}

?>