<?php

namespace Web\Model\Api;

use LisDev\Delivery\NovaPoshtaApi2;

class NewPost
{
    /**
     * @var NovaPoshtaApi2
     */
    public $nova;

    /**
     * NewPost constructor.
     */
    public function __construct()
    {
        $this->nova = new NovaPoshtaApi2('d377a60144e728551a22f71b59024c0f', 'ua');
    }

    /**
     * @param $name
     */
    public function getCity($name)
    {
        $result = $this->nova
            ->model('Address')
            ->method('getCities')
            ->params([
                'FindByString' => $name,
                'Limit' => '500',
            ])
            ->execute();


        $str = '';
        foreach ($result['data'] as $item) {
            $type = $this->settElementType($item['SettlementTypeDescription']);
            $str .= '<option value="' . $item['Ref'] . '">' . $type . $item['Description'] . '</option>';
        }
        echo $str;
    }

    /**
     * @param $element
     * @return string
     */
    public function settElementType($element)
    {
        if ($element == 'село') {
            return 'с. ';
        } elseif ($element == 'селище міського типу') {
            return 'смт. ';
        } elseif ($element == 'місто') {
            return 'м. ';
        } else {
            return '?. ';
        }
    }

    /**
     * @param $ref
     * @return mixed
     */
    public function getCityByRef($ref)
    {
        $result = $this->nova
            ->model('Address')
            ->method('getCities')
            ->params([
                'Ref' => $ref,
            ])
            ->execute();

        return ($result);

    }

    /**
     * @param $ref
     * @return string
     */
    public function getNameCityByRef($ref)
    {
        $search = $this->getCityByRef($ref);

        if (isset($search['data'][0])) {
            $city = $search['data'][0];
            $type = $this->settElementType($city['SettlementTypeDescription']);
            return (
                $type
                . $city['Description']
            );
        } else {
            return ('not_found');
        }
    }

    /**
     * @return mixed
     */
    public function get_cards()
    {
        $result = $this->nova
            ->model('Payment')
            ->method('getCards')
            ->execute();

        return ($result['data']);
    }

    /**
     * @param $city
     * @return array
     */
    public function search_warehouses($city)
    {
        $data = [];

        $result = $this->nova
            ->model('AddressGeneral')
            ->method('getWarehouses')
            ->params([
                'CityRef' => $city
            ])
            ->execute();

        if (count($result['data']) > 0) {
            $data['disabled'] = false;
            $data['data'] = $result['data'];
        } else {
            $data['disabled'] = true;
            $data['data'] = [];
        }

        return $data;
    }

    /**
     * @param $city
     * @param $warehouse
     * @return array
     */
    public function get_address($city, $warehouse)
    {
        $warehouses = $this->search_warehouses($city);

        foreach ($warehouses['data'] as $item) {
            if($item['Ref'] == $warehouse){
                $war = $item['Description'];
                break;
            }
        }

        if(!isset($war))
            $war = 'not_found';

        $data = [
            'city' => $this->getNameCityByRef($city),
            'warehouse' => $war
        ];

        return $data;
    }

}