<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/26
 * Time: 14:46
 */
namespace app\api\controller;

use think\Loader;

class ApiCommon extends Api
{
    //TODO::上传图片
    public function uploadPic(){
        global $_W, $_GPC;
        //检测是否存在文件
        if (!is_uploaded_file($_FILES["file"]['tmp_name'])) {
            //图片不存在
            return_json('图片不存在',1);
        }else{
            $file = $_FILES["file"];

//            require_once IA_ROOT."/framework/class/uploadedfile.class.php";
            Loader::import('upload.uploadfile');
            $upload = new \UploadFile();
//            var_dump($upload);exit;
            //设置上传文件大小,目前相当于无限制,微信会自动压缩图片
            $upload->maxSize = 30292200;
            $upload->allowExts = explode(',', 'png,gif,jpeg,pjpeg,bmp,x-png,jpg');
            $upload->savePath = IA_ROOT."/attachment/";
            $upload->saveRule = uniqid();
            $uploadList = $upload->uploadOne($file);
//            var_dump($uploadList);exit;
            if (!$uploadList) {
                //捕获上传异常
                return_json($upload->getErrorMsg(),1);
            }
            $newimg = $uploadList['0']['savename'];
            //远程附件存储
            @require_once (IA_ROOT."/framework/function/file.func.php");
            @$filename=$newimg;
            @file_remote_upload($filename);
            $imgroot['img_root'] = $_W['attachurl'];
            return_json('success',0,$newimg,$imgroot);
        }
    }
    public function getNowTime(){
        $time=time();
        success_json($time);
    }
}