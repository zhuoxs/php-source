<?php

namespace App\Http\Controllers;

use App\Model\DisAmountLog;
use App\Model\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Url;

class DisAmountLogController extends Controller
{
    protected $header = '资金明细';

    public function grid()
    {
        return $this->admin->grid(DisAmountLog::class, function (Grid $grid) {
            $grid->model()->orderBy("id","desc");
            $grid->column('id', 'id');
            $grid->column('dis_user_id', '配送员')->display(function ($user_id) {
                return User::instance()->find($user_id)->name;
            });
            $grid->column('type', '类型')->display(function ($type){
                $type_str = $type == 0 ? "进帐" :"出帐";
                $label_list = ["info","success"];
               return "<span class='label label-".$label_list[$type]."'>".$type_str."</span>";
            });

            $grid->column('name', '名目');
            $grid->column('amount', '金额');
            $grid->column('remark', '备注');
            $grid->disableCreateButton();
            $grid->tools(function (Grid\Tools $tools){
                $tools->disableBatchActions();
            });

            $grid->disableActions();
        });
    }

    public function form($id = null)
    {
        return $this->admin->form(DisAmountLog::class, function (Form $form) use ($id) {

        });
    }
}
