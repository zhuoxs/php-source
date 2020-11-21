<?php

namespace App\Http\Controllers;

use App\Http\Extensions\Tools\StoreSelect;
use App\Model\DisOrder;
use App\Model\Store;
use App\Model\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Url;

class DisOrderController extends Controller
{
    protected $header = '配送订单';

    public function grid()
    {
        return $this->admin->grid(DisOrder::class, function (Grid $grid) {
            $store_id = isset($_REQUEST['store_id']) ? $_REQUEST['store_id'] :
                0;
            if (0 == intval($store_id)) {
                unset($_REQUEST['store_id']);
                $grid->model()->orderBy("id","desc");
            } else {
                $grid->model()->orderBy("id","desc")->where('store_id', $store_id);
            }
            $grid->column('id', 'id');
            $grid->column('order_sn', '订单号');
            $grid->column('status', '状态')->display(function ($status) {
                $status_list = [
                    -10 => '已删除',
                    10 => '未接单',
                    20 => '已接单',
                    30 => '配送完成',
                ];

                $label_list = [
                    -10 => 'danger',
                    10 => 'warning',
                    20 => 'primary',
                    30 => 'success',
                ];

                return "<span class='label label-".$label_list[$status]."'>".$status_list[$status]."</span>";//$status_list[$status];

            });
            $grid->column('dis_user_id', '配送员')->display(function ($user_id) {
                if($user_id > 0){
                    return User::instance()->find($user_id)->name;
                }
                return "";
            });
            $grid->column('store_id', '门店')->display(function ($store_id) {
                return Store::instance()->find($store_id)->name;
            });


            $grid->column('dis_amount', '配送费');
            $grid->column('receive_at', '接单时间')->display(function ($receive_at){
                return (is_null($receive_at) || $receive_at == "0000-00-00 00:00:00") ?"" :date('m-d H:i',strtotime($receive_at));
            });
            $grid->column('finish_at', '完成时间')->display(function ($finish_at){
                return (is_null($finish_at) || $finish_at == "0000-00-00 00:00:00") ?"" :date('m-d H:i',strtotime($finish_at));
            });

            $grid->disableCreateButton();
            $grid->tools(function (Grid\Tools $tools){
                $tools->disableBatchActions();
            });
            $grid->disableActions();
            /*$grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableEdit();
                $actions->disableDelete();
                // append一个操作
                $id = $actions->getKey();
                // $actions->append(
                //      $actions->append('&nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-tasks"></i>&nbsp;详情</a>')
                // );
            });*/

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
        return $this->admin->form(DisOrder::class, function (Form $form) use ($id) {

        });
    }
}
