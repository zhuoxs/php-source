<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/16
 * Time: 15:52.
 */

namespace App\Http\Controllers;

use App\Model\Goods;
use App\Model\GoodsClass;
use App\Model\LimitTimeActivity;
use App\Model\SecKillActivity;

class ApiController extends Controller
{
    public function getGoodsShopPrice()
    {
        $goods_id = $_REQUEST['q'];
        $shop_price = Goods::instance()->find($goods_id)->shop_price;

        return $shop_price;
    }

    public function getActionList()
    {
        $action_type = $_REQUEST['q'];
        if (0 == $action_type) {
            $all = config('actions');
            $res = [];
            foreach ($all as $key => $item) {
                $res[] = ['id' => $key, 'text' => $item];
            }

        } else if(1 == $action_type){
            $all = Goods::instance()->where('is_enable', true)->pluck('name', 'id');
            $res = [];
            foreach ($all as $key => $value) {
                $res[] = ['id' => $key, 'text' => $value];
            }


        }else{
            $all = GoodsClass::instance()->where('is_enable', true)
                ->where("parent_id",0)
                ->pluck('title', 'id');
            $res = [];
            foreach ($all as $key => $value) {
                $res[] = ['id' => $key, 'text' => $value];
            }
        }
        header('Content-type: application/json');

        return json_encode($res);
    }

    public function getActivityList()
    {
        $activity_type = $_REQUEST['q'];
        if($activity_type == 1)
        {
            $all = LimitTimeActivity::instance()->pluck("name","id");
        }
        else
        {
            $all = SecKillActivity::instance()->pluck("name","id");
        }
        $res = [];
        foreach ($all as $key => $value) {
            $res[] = ['id' => $key, 'text' => $value];
        }

        header('Content-type: application/json');

        return json_encode($res);
    }
}
