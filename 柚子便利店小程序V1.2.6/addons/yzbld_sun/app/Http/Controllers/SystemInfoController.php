<?php

namespace App\Http\Controllers;

use App\Model\SystemInfo;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Url;

class SystemInfoController extends Controller
{
    protected $header = '小程序设置';

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
            $form->text('appid', '小程序appid');
            $form->text('appsecret', '小程序appsecret');
            $form->text('mchid', '商户号');
            $form->text('wxkey', '商户号密钥')->help("请输入微信支付商户后台32位API密钥");
            $form->file("cert_pem","apiclient_cert.pem");
            $form->file("key_pem","apiclient_key.pem");
            $form->text('map_key', '腾讯地图key')->help("腾讯地图要求必须要有自己的key.<a href='https://lbs.qq.com/console/key.html' target='_blank'>申请key</a>");
            $form->tools(function (Form\Tools $tools){
                $tools->disableBackButton();
            });
            //$form->setAction(Url::update('system_info', $id));
            $form->saved(function (Form $form) use($id){
                admin_toastr(trans('admin.update_succeeded'));
                return redirect(Url::show('system_info', $id));
            });
        });
    }
}
