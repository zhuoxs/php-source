<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\UserCoupon;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class UserCouponController extends Controller
{
    protected $header = '会员优惠券';

    public function grid()
    {
        return $this->admin->grid(UserCoupon::class, function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('user_id', '用户')->display(function ($user_id) {
                return (new User())->find($user_id)->name;
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
            $grid->column('is_used', '已使用?')->display(function ($is_used) {

                return $is_used ? "<span class='label label-success'>是</span>" : "<span class='label label-info'>否</span>";
            });

            // $grid->disablePagination();
            $grid->tools(function (Grid\Tools $tools) {
                $tools->disableBatchActions();
            });
            $grid->disableActions();
            $grid->disableCreateButton();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->disableIdFilter();
                $filter->equal('user_id', '用户')->select(
                    User::instance()->pluck('name', 'id')->toArray());
                $filter->equal('is_used',"状态")->radio([
                    0 => '未使用',
                    1 => '已使用',
                ]);
            });
        });
    }

    public function form($id = null)
    {
        return $this->admin->form(UserCoupon::class, function (Form $form) use ($id) {
        });
    }
}
