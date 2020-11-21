<?php

namespace App\Http\Controllers;

use App\Model\SystemInfo;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Url;

class MsgTemplateController extends Controller
{
    protected $header = '模板消息';

    public function grid()
    {
        return $this->admin->grid(SystemInfo::class, function (Grid $grid) {
            $grid->column('id', 'id');
            $grid->disablePagination();
        });
    }

    public function form($id = null)
    {

        return $this->admin->form(SystemInfo::class, function (Form $form) use ($id) {

            $msg_template = SystemInfo::instance()->first()->msg_template;


            $form->switch('enable_msg_template', '开通模板消息?')
                ->states($this->getStateList())->value(!empty($msg_template));


           /*
            //$pay_success = "";
            if(!empty($msg_template)){
                //$arr = json_decode($msg_template,true);
                //$pay_success = $arr["pay_success"];
            }
           $form->text('pay_success', '支付通知')
                ->placeholder("请输入'支付通知'模板消息ID")
                ->help("*模板编号AT0048,关键词(订单号,物品名称,物品数量,支付金额，支付时间)")
                ->value($pay_success);*/

            $form->tools(function (Form\Tools $tools){
                $tools->disableBackButton();
            });
            $form->setAction(Url::update('msg_template', $id));
            $form->saving(function (Form $form) use($id){
                $sys_info = SystemInfo::instance()->first();
                $template = $form->msg_template;
                if(!empty($template) && $form->enable_msg_template != "on"){
                    $sys_info->msg_template = "";
                    $sys_info->save();
                }else if(empty($template) && $form->enable_msg_template == "on")
                {
                    $template_id = $this->getMsgTemplateID("AT0048",[1,2,5,4,3]);
                    $arr["pay_success"] = $template_id;
                    $sys_info->msg_template = json_encode($arr);
                    $sys_info->save();
                }
                admin_toastr(trans('admin.update_succeeded'));
                return redirect(Url::show('msg_template', $id));

            });
        });
    }
}
