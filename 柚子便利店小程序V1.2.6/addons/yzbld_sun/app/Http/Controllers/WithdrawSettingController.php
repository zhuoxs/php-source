<?php

namespace App\Http\Controllers;

use App\Model\WithdrawSetting;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Url;

class WithdrawSettingController extends Controller
{
    protected $header = '提现设置';

    public function grid()
    {
        return $this->admin->grid(WithdrawSetting::class, function (Grid $grid) {
            $grid->column('id', 'id');
        });
    }

    public function form($id = null)
    {

        return $this->admin->form(WithdrawSetting::class, function (Form $form) use ($id) {
            $form->switch('is_enable', '启用?')
                ->states($this->getStateList())->setDefault(false)
                ->help('提现开关，关闭之后无法提现');
            $form->currency('min_amount', '最低提现金额')
            ->help('例如：设置 100 ，那么只有达到 100 配送员才能提现');
            $form->currency('no_verify_amount', '免审金额')
                ->help('例如：设置 1000 ，那么 1000 以内可以直接不需要后台审核打款（该操作只限使用 微信 方式提现）');
            $form->text('poundage', '微信提现手续费费率')->setWidth(4)->prepend('')->append("%")
                ->help('微信转账收取的手续费，例如：提现1000，设置 2% ，那么手续费就是20，0为不收取手续费');
            $form->text('commission', '平台抽成比率')->setWidth(4)->prepend('')->append("%")
                ->help('配送员提现的时候收取的抽成');
            $form->editor('rule', '提现须知');
            $form->tools(function (Form\Tools $tools){
                $tools->disableBackButton();
            });

            $form->setAction(Url::update('withdraw_setting', $id));
            $form->saved(function (Form $form) use($id){
                admin_toastr(trans('admin.update_succeeded'));
                return redirect(Url::show('withdraw_setting', $id));
            });
        });
    }
}
