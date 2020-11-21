<?php

namespace App\Http\Controllers;

use App\Model\Goods;
use App\Model\Recharge;
use App\Model\Store;
use App\Model\StoreGoods;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class RechargeController extends Controller
{
    protected $header = '充值赠送';

    public function grid()
    {
        return $this->admin->grid(Recharge::class, function (Grid $grid) {
            $grid->column('id');

            $grid->column('money', '充值金额')->display(function ($money) {
                return '<b>￥</b>'.$money;
            });
            $grid->column('gift', '赠送金额')->display(function ($gift) {
                return '<b>￥</b>'.$gift;
            });
            $grid->column('is_enable', '启用?')->switch($this->getStateList());
           // $grid->disablePagination();
        });
    }

    public function form($id = null)
    {
        return $this->admin->form(Recharge::class, function (Form $form) use ($id) {

            $form->number('money', '充值金额');
            $form->number('gift', '赠送金额');
            $form->switch('is_enable', '启用?')
                ->states($this->getStateList())->setDefault(true);
        });
    }
}
