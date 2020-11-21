<?php

namespace App\Http\Controllers;

use App\Model\RechargeLog;
use App\Model\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Url;

class RechargeLogController extends Controller
{
    protected $header = '充值记录';

    public function grid()
    {
        return $this->admin->grid(RechargeLog::class, function (Grid $grid) {
            $grid->column('id', 'id');
            $grid->column('user_id', '用户')->display(function ($user_id) {
                return User::instance()->find($user_id)->name;
                //return "<a href='".Url::show('user', $user_id)."'>".(new User())->find($user_id)->name.'</a>';
            });
            $grid->column("pay_amount","支付金额");
            $grid->column("pay_at","支付时间");
            $grid->column("gift","赠送");
            $grid->column('state', '状态')->display(function ($state) {
                $status_list = [
                    0 => '未支付',
                    1 => '已支付',
                ];

                return $status_list[$state];
            });
            $grid->column('remark', '备注');
            //$grid->disableCreateButton();
            $grid->disableActions();
            $grid->tools(function (Grid\Tools $tools){
                $tools->disableBatchActions();
            });
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableEdit();
                $actions->disableDelete();
                // append一个操作
                $id = $actions->getKey();
                // $actions->append(
                //      $actions->append('&nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-tasks"></i>&nbsp;详情</a>')
                // );
            });
        });

    }

    public function form($id = null)
    {
        return $this->admin->form(RechargeLog::class, function (Form $form) use ($id) {
                //$form->("remark","备注");

                $options = User::instance()->pluck("name","id");
                if($id == null && isset($_REQUEST["user_id"])){
                    $user_id = $_REQUEST["user_id"];
                    $form->select("user_id","用户")->options($options)->setDefault($user_id);


                }else{
                    $form->select("user_id","用户")->options($options);
                }

                $form->text("pay_amount","充值金额");
                $form->text("remark","备注");
                $form->saving(function (Form $form){
                    $rechargeLog = RechargeLog::instance();
                    $rechargeLog->user_id = $form->user_id;
                    $rechargeLog->pay_amount = $form->pay_amount;
                    $rechargeLog->remark = $form->remark;
                    $rechargeLog->amount = $form->pay_amount;
                    $rechargeLog->gift = 0;
                    $rechargeLog->pay_at = date('Y-m-d H:i:s');
                    $rechargeLog->state = 1;
                    $rechargeLog->save();
                    $user = User::instance()->find($form->user_id);
                    $user->amount += $rechargeLog->pay_amount;
                    $user->save();

                   return redirect(Url::index("recharge_log"));
                });
        });
    }
}
