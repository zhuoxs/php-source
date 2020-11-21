<?php

namespace App\Http\Controllers;

use App\Model\Activity;
use App\Model\ActivityGoods;
use App\Model\Goods;
use App\Model\LimitTimeActivity;
use App\Model\SecKillActivity;
use App\Model\Store;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Url;

class ActivityGoodsController extends Controller
{
    protected $header = '活动商品';

    public function grid()
    {
        return $this->admin->grid(ActivityGoods::class, function (Grid $grid) {
            $grid->column('id');

            $grid->column('activity_id', '活动')->display(function ($activity_id) {
                if($this->activity_type == 1)
                {
                    return LimitTimeActivity::instance()->find($activity_id)->name;

                }
                else
                {
                    return SecKillActivity::instance()->find($activity_id)->name;
                }
            });
            $grid->column('goods_id', '商品')->display(function ($goods_id) {
                return (new Goods())->find($goods_id)->name;
            });


            $grid->column('price', '活动价')->display(function ($price) {
                return '<b>￥</b>'.$price;
            });

            $grid->column('buy_num', '已售')->display(function ($buy_num) {
                return $buy_num?$buy_num:0;
            });

            $grid->column("limited","限购量");
            /*$grid->column("buy_num","已认购量")->display(function ($buy_num){
                if(strpos($buy_num,",") === false){
                    return $buy_num;
                }
                else
                {
                    $res = "";
                    $lists =explode(",",$buy_num);
                    for($i=0; $i< count($lists);++$i)
                    {
                        if($lists[$i] != 0)
                        {
                            $res .= sprintf("%d时:%d",$i,$lists[$i]);
                        }
                    }
                    return $res;

                }
            });*/

            //$grid->disablePagination();
        });
    }

    public function form($id = null)
    {
        return $this->admin->form(ActivityGoods::class, function (Form $form) use ($id) {

            $form->select('activity_type','活动类型')
                ->options([1=>"限时抢购",2=>"每日秒杀"])
                ->load("activity_id",Url::generate("api","getActivityList"));
            if($id == null){
                $form->select('activity_id', '活动');
            }
            else{
                $activity_type = ActivityGoods::instance()->find($id)->activity_type;
                if($activity_type == 1)
                {
                    $options = LimitTimeActivity::instance()->pluck("name","id");
                }
                else
                {
                    $options = SecKillActivity::instance()->pluck("name","id");
                }
                $form->select('activity_id', '活动')->options($options);
            }
            $form->select('goods_id', '商品')->options(
                Goods::instance()->pluck('name', 'id'));
            $form->currency('price', '活动价');
            $form->number('limited', '限购量');
        });
    }
}
