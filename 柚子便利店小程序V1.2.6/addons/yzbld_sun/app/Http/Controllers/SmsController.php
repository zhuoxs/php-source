<?php

namespace App\Http\Controllers;

use App\Lib\SmsTemplate;
use App\Model\SystemInfo;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Url;

class SmsController extends Controller
{
    protected $header = '短信配置';

    public function grid()
    {
        return $this->admin->grid(SystemInfo::class, function (Grid $grid) {
            $grid->column('id', 'id');
            $grid->disablePagination();
        });
    }

    public function getDeault()
    {
        
    }
    public function form($id = null)
    {

        $self = $this;
        return $this->admin->form(SystemInfo::class, function (Form $form) use ($id,$self) {

            $sms = new SmsTemplate();

            $form->switch('is_enable', '开通短信?')
                ->states($this->getStateList())->value($sms->isEnable());

            $form->radio("sms_type","短信通道")->options($sms->getSmsTypeList())
            ->value($sms->getType());

            $cloud253 = $sms->getResult()["cloud253"];


            $form->text('cloud253_appId', 'API接口账号')
                ->help("*位置：验证码通知短信-->产品概览-->api接口信息<br>
链接：点击前往注册253云通信 <br>
备注：点击链接--注册后---技术客服一对一 7*24小时服务")
                ->value($cloud253["cloud253_appId"]);

            $form->text('cloud253_appSecret', 'API接口密码')
                ->help("*位置：验证码通知短信-->产品概览-->api接口信息")
                ->value($cloud253["cloud253_appSecret"]);

            $form->text('cloud253_order_template_code', '新订单提醒')
                ->help("*输入内容:【XX】您有新的订单，请登录商家管理页面查看 <br>
模板内容：您有新的订单，请登录商家管理页面查看 <br>
为空不发送")
                ->value($cloud253["cloud253_order_template_code"]);


            $aliyun = $sms->getResult()["aliyun"];
            $form->text('aliyun_appId', 'AccessKeyId')
                ->help("AccessKeyId")
                ->value($aliyun["aliyun_appId"]);

            $form->text('aliyun_appSecret', 'AccessKeySecret')
                ->help("AccessKeySecret")
                ->value($aliyun["aliyun_appSecret"]);

            $form->text('aliyun_sign', '签名名称')
                ->help("设置签名名称，应严格按\"签名名称\"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign")
                ->value($aliyun["aliyun_sign"]);


            $form->text('aliyun_order_template_code', '订单下单提醒(模版CODE)')
                ->help("例如：SMS_140105861。模板内容:您有一条新的订单,请登录商家后台查看。为空不发送；应严格按\"模板CODE\"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template")
                ->value($aliyun["aliyun_order_template_code"]);

           /* $self->admin->script = "

            ";*/

            $form->tools(function (Form\Tools $tools){
                $tools->disableBackButton();
            });
            $form->setAction(Url::update('sms', $id));
            $form->saving(function (Form $form) use($id){

                $res = [
                    "is_enable"=>$form->is_enable == "on" ? 1 :0,
                    "type"=>$form->sms_type,
                    "cloud253"=>[
                        "cloud253_appId"=>$form->cloud253_appId,
                        "cloud253_appSecret"=>$form->cloud253_appSecret,
                        "cloud253_order_template_code"=>$form->cloud253_order_template_code,
                    ],
                    "aliyun"=>[
                        "aliyun_appId"=>$form->aliyun_appId,
                        "aliyun_appSecret"=>$form->aliyun_appSecret,
                        "aliyun_sign"=>$form->aliyun_sign,
                        "aliyun_order_template_code"=>$form->aliyun_order_template_code,
                    ],
                ];
                SmsTemplate::setValue($res);
                admin_toastr(trans('admin.update_succeeded'));
                return redirect(Url::show('sms', $id));

            });
        });
    }
}
