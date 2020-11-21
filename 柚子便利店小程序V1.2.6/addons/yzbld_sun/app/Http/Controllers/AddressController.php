<?php

namespace App\Http\Controllers;

use App\Model\City;
use App\Model\County;
use App\Model\Province;

class AddressController extends Controller
{
    public function province()
    {
        $all = Province::instance()->pluck('name', 'id');
        $res = [];
        foreach ($all as $key => $value) {
            $res[] = ['id' => $key, 'text' => $value];
        }
        header('Content-type: application/json');

        return json_encode($res);
    }

    public function city()
    {
        $q = $_REQUEST['q'];
        $all = City::instance()->where('province_id', $q)->pluck('name', 'id');
        $res = [];
        foreach ($all as $key => $value) {
            $res[] = ['id' => $key, 'text' => $value];
        }
        header('Content-type: application/json');

        return json_encode($res);
    }

    public function county()
    {
        $q = $_REQUEST['q'];
        $all = County::instance()->where('city_id', $q)->pluck('name', 'id');
        $res = [];
        foreach ($all as $key => $value) {
            $res[] = ['id' => $key, 'text' => $value];
        }
        header('Content-type: application/json');

        return json_encode($res);
    }
}
