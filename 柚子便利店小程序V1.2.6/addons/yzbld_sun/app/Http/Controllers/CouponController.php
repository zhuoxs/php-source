<?php

namespace App\Http\Controllers;

use App\Http\Extensions\Tools\StoreSelect;
use App\Model\Coupon;
use App\Model\Store;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class CouponController extends Controller
{
    protected $header = '优惠券';

    public function grid()
    {
        return $this->admin->grid(Coupon::class, function (Grid $grid) {
            $store_id = isset($_REQUEST['store_id']) ? $_REQUEST['store_id'] :
                0;
            if (0 == intval($store_id)) {
                unset($_REQUEST['store_id']);
            } else {
                $grid->model()->where('store_id', $store_id);
            }
            $grid->column('id');
            $grid->column('store_id', '门店')->display(function ($store_id) {
                return Store::instance()->find($store_id)->name;
            });
            $grid->column('name', '活动名称');
            $grid->column('amount', '优惠券金额')->display(function ($amount) {
                return '<b>￥</b>'.$amount;
            });
            $grid->column('use_amount', '启用金额')->display(function ($use_amount) {
                return '<b>￥</b>'.$use_amount;
            });
            $grid->column('begin_at', '开始时间')->display(function ($begin_at) {
                return date('Y-m-d', strtotime($begin_at));
            });
            $grid->column('end_at', '结束时间')->display(function ($end_at) {
                return date('Y-m-d', strtotime($end_at));
            });
            $grid->column('days', '有效天数');
            $grid->column('total', '总量');
            $grid->column('is_enable', '启用?')->switch($this->getStateList());

            $grid->filter(function (Grid\Filter $filter) {
                $filter->disableIdFilter();

                $filter->equal('store_id', '门店')->select(
                    Store::instance()->pluck('name', 'id')->toArray());
            });

            $grid->tools(function (Grid\Tools $tools) {
                $tools->append(new StoreSelect());
            });
        });
    }

    public function form($id = null)
    {
        return $this->admin->form(Coupon::class, function (Form $form) use ($id) {
            $form->select('store_id', '门店')->options(
                Store::instance()->pluck('name', 'id')
            );
            $form->text('name', '活动名称');
            $form->number('amount', '优惠券金额')->help('只能整数'); //->rules('required');
            $form->number('use_amount', '启用金额')->help('只能整数'); //->rules('required');
            $form->dateRange('begin_at', 'end_at', '活动时间'); //->rules('required');
            $form->number('days', '有效天数')->min(0)->rules('required');
            $form->number('total', '总量')->min(0)->rules('required');
            $form->switch('is_enable', '启用?')
                ->states($this->getStateList())->setDefault(true);
        });
    }
}
