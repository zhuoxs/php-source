<?php

namespace App\Http\Controllers;

use App\Lib\SmsTemplate;
use App\Lib\StorageTemplate;
use App\Model\SystemInfo;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Url;

class StorageController extends Controller
{
    protected $header = '远程附件';

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

            $storage= new StorageTemplate();

            $form->switch('is_enable', '开启远程附件?')
                ->states($this->getStateList())->value($storage->isEnable())->help("注:该开关只有效于该应用.重新开启或关闭后,需重新上传图片.");

            $form->radio("storage_type","类型")->options($storage->getStorageTypeList())
            ->value($storage->getType());

            $qiniu = $storage->getResult()["qiniu"];

            $form->text('qiniu_appId', 'Accesskey')
                ->value($qiniu["qiniu_appId"]);
            $form->text('qiniu_appSecret', 'Secretkey')
                 ->value($qiniu["qiniu_appSecret"]);
            $form->text('qiniu_bucket', 'Bucket')
                  ->value($qiniu["qiniu_bucket"]);
            $form->text('qiniu_url', 'Url')
                   ->value($qiniu["qiniu_url"]);




            $form->tools(function (Form\Tools $tools){
                $tools->disableBackButton();
            });
            $form->setAction(Url::update('storage', $id));
            $form->saving(function (Form $form) use($id){

                $url = strtolower($form->qiniu_url);
                if(substr($url,0,7) != "http://" &&
                    substr($url,0,8) != "https://"){
                    $url = "http://". $url;
                }
                $res = [
                    "is_enable"=>$form->is_enable == "on" ? 1 :0,
                    "type"=>$form->storage_type,
                    "qiniu"=>[
                        "qiniu_appId"=>$form->qiniu_appId,
                        "qiniu_appSecret"=>$form->qiniu_appSecret,
                        "qiniu_bucket"=>$form->qiniu_bucket,
                        "qiniu_url"=>$url,
                    ],
                ];
                StorageTemplate::setValue($res);
                admin_toastr(trans('admin.update_succeeded'));
                return redirect(Url::show('storage', $id));

            });
        });
    }
}
