<?php

namespace Web\Controller\Orders;

use Web\App\Controller;
use Web\Model\Orders\ExportXML;
use Web\App\ArrayToXML;

class ExportXMLController extends Controller
{
    /**
     * @var ArrayToXML
     */
    private $xml;

    /**
     * @var array
     */
    private $object = [];

    /**
     * ExportXMLController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->xml = new ArrayToXML();
    }

    /**
     * @param $post
     */
    public function handle($post)
    {
        $this->start($post->ids);

        $content = $this->xml->buildXML($this->object, 'orders');

        $name = "/server/export/orders_" . date('Y-m-d_h.i.s') . ".xml";
        $file = ROOT . $name;
        file_put_contents($file, $content);
        res(['file' => $name, 'status' => '1']);

    }

    /**
     * @param $ids
     */
    private function start($ids)
    {
        $i = 0;
        foreach ($ids as $id) {
            $this->object_items_create($id);
            $this->add_data($id, $i);
            $i++;
        }
    }

    /**
     * @param $id
     * @param $i
     */
    private function add_data($id, $i)
    {
        foreach ($this->get_data($id) as $k => $v)
            $this->object['order'][$i][$k] = $v;
    }

    /**
     * @param $id
     * @return array
     */
    private function get_data($id)
    {
        $data = [];

        $arr = ['getData', 'getPay', 'getPrice', 'getDelivery', 'getSource', 'getProducts', 'getReturnShipping', 'getPlaces'];
        foreach ($arr as $method)
           $data = ExportXML::$method($id, $data);

        return $data;

    }

    /**
     * @param $id
     */
    private function object_items_create($id)
    {
        $this->object['order'][] = [
            '@id' => $id,
            '@state' => 'accepted'
        ];
    }

}
