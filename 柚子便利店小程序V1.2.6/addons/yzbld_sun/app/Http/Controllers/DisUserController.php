<?php

namespace App\Http\Controllers;

use App\Http\Extensions\Tools\StoreSelect;
use App\Model\DisOrder;
use App\Model\Store;
use App\Model\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Url;

class DisUserController extends Controller
{
    protected $header = '配送员';



    public function grid()
    {
        return $this->admin->grid(User::class, function (Grid $grid) {

            $grid->model()->where("is_distribution",1);
            //$grid->column('id', 'id');
            $grid->column('name', '姓名');

            $grid->column("dis_order_count","接单数")->display(function (){
                $count = DisOrder::instance()->where("dis_user_id",$this->id)
                    ->count();
                return $count;
            });
          /*  $grid->column("all_amount","总收入")->display(function (){
                return '<b>￥</b>'."100.00";
            });*/
            $grid->column("dis_amount","余额")->display(function ($dis_amount){
                return '<b>￥</b>'.$dis_amount;
            });
           /* $grid->column("withdraw_amount","提现")->display(function (){
                return '<b>￥</b>'."10.00";
            });*/

            $grid->disableCreateButton();
            $grid->tools(function (Grid\Tools $tools){
                $tools->disableBatchActions();
            });
            $grid->disableActions();
            $grid->disableFilter();
        });
    }

    public function form($id = null)
    {
        return $this->admin->form(User::class, function (Form $form) use ($id) {

        });
    }
}
