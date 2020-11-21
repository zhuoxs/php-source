<?php
namespace Ht\Controller;

use Think\Controller;
use Think\Upload;
use Think\Upload\Driver\Oss;
use Qiniu\Storage\UploadManager;
use Qiniu\Auth;
use Qiniu\Config;
use Qiniu\Storage\BucketManager;

class UploadController extends Controller
{

    public function uploadpic()
    {
        $this->mb();
        $Img = I('file');
        $Path = null;

        if ($_FILES['file']) {
            switch(C('upload_type')){
                case 0:
                    $Img = $this->saveimg_local($_FILES);
                    break;
                case 1:
                    $Img = $this->saveimg($_FILES);
                    break;
                case 2:
                    $Img = $this->qiniu_saveimg($_FILES);
                    break;
            }
			
        }

         exit(json_encode($Img));
    }

    private function saveimg_local($files)
    {
        $exts = array(
            'jpeg',
            'jpg',
            'jpeg',
            'png',
            'pjpeg',
            'gif',
            'bmp',
            'x-png'
        );
        $upload = new Upload(array(
            'mimes' => C("uptype"),
            'exts' => $exts,
            'rootPath' => './Public/',
            'savePath' => 'Uploads/Ads/',
            'subName'  =>  array('date', 'd'),
            'maxSize' =>C('max_upload_size')
        ));
        $info = $upload->upload($files);
        $code = 0;
        $error ='';
        $data='';
        if(!$info) {// 上传错误提示错误信息
            $error = $upload->getError();
            $code=1;
        }else{// 上传成功
            foreach ($info as $item) {
                $filePath[] = "https://".$_SERVER['SERVER_NAME'].__ROOT__."/Public/".$item['savepath'].$item['savename'];
            }
            $ImgStr = implode("|", $filePath);
            $data=$ImgStr;
            $error="上传成功";

        }
        $ret=array();
        if($code){
            $ret["retCode"]="0001";
            $ret["retDesc"]="上传失败";
        }else{
            $ret["retCode"]="0000";
            $ret["retDesc"]="上传成功";
            $ret["pathfile"]=$data;
        }
        return $ret;
    }
    private function saveimg($files)
    {
		
        //oss上传 
		$bucketName = C('oss_bucket');
		$ossClient = new \Org\OSS\OssClient(C('oss_access_id'), C('oss_access_key'), C('oss_endpoint'), false);
		$web=C('oss_web_site');
		//图片  
		$fFiles=$_FILES['file']; 
		$rs=ossUpPic($fFiles,date("Y"),$ossClient,$bucketName,$web,1);
        $ret=array();
        if($rs['code']){
            $ret["retCode"]="0001";
            $ret["retDesc"]="上传失败";
        }else{
            $ret["retCode"]="0000";
            $ret["retDesc"]="上传成功";
            $ret["pathfile"]=$rs['url'];
        }

        return $ret;



    }
    //七牛上传
    private function qiniu_saveimg($files){
        vendor("qiniu.autoload");
        vendor("qiniu.src.Qiniu.Auth");
        vendor("qiniu.src.Qiniu.Etag");
        vendor("qiniu.src.Qiniu.Zone");
        $auth=new Auth(C("qiniu_ak"), C("qiniu_sk"));
        $token=$auth->uploadToken(C("qiniu_bucket"));
        $um=new UploadManager();
        $ext=explode(".",$_FILES['file']["name"]);//文件拓展名
        $key=date('YmdHis').mt_rand(1,9).mt_rand(1,9).mt_rand(1,9).mt_rand(1,9).".".$ext[count($ext)-1];//保存文件名称
        $filePath=$_FILES['file']["tmp_name"];
        list($ret, $err)=$um->putFile($token,$key, $filePath);//$_FILES['img']["name"]
        if ($err !== null) {
            return ['retCode'=>'0001','retDesc'=>'上传失败','pathfile'=>''];
        } else {
            return ['retCode'=>'0000','retDesc'=>'上传成功','pathfile'=>C("qiniu_site")."/".$ret["key"]];
        }
    }

    public function batchpic()
    {
        $ImgStr = I('file');
        $ImgStr = trim($ImgStr, '|');
        $Img = array();
        if (strlen($ImgStr) > 1) {
            $Img = explode('|', $ImgStr);
        }
        $Path = null;
        $newImg = array();
        $newImgStr = null;
		
        if ($_FILES) {
			if(C('isoss')){
				$newImgStr = $this->saveimgs($_FILES);
			}else{
				$newImgStr = $this->saveimg_local($_FILES);
			}
            if ($newImgStr) {
                $newImg = explode('|', $newImgStr);
            }

        }
        $Img = array_merge($Img,$newImg);
        $ImgStr = implode("|", $Img);
        $BackCall = I('BackCall');
        $Width = I('u');
        $Height = I('Height');
        if (!$BackCall) {
            $Width = $_POST['BackCall'];
        }
        if (!$Width) {
            $Width = $_POST['Width'];
        }
        if (!$Height) {
            $Width = $_POST['Height'];
        }
        $this->assign('Width', $Width);
        $this->assign('BackCall', $BackCall);
        $this->assign('ImgStr', $ImgStr);
        $this->assign('Img', $Img);
        $this->assign('Height', $Height);
        $this->display('Batchpic');
    }
	private function saveimgs($files)
    {
		
        //oss上传 
		$bucketName = C('OSS_BUCKET'); 
		$ossClient = new \Org\OSS\OssClient(C('OSS_ACCESS_ID'), C('OSS_ACCESS_KEY'), C('OSS_ENDPOINT'), false); 
		$web=C('OSS_WEB_SITE'); 
		//图片  
		$fFiles=$_FILES['img']; 
		$rs=ossUpPics($fFiles,'ekcms',$ossClient,$bucketName,$web,0);  

		if($rs['code']==1){ 
			//图片  
			$img = $rs['url']; 
			//如返回里面有缩略图： 
			//$thumb=$rs['thumb']; 
			return $img;            
		}else{
			echo "<script>alert('{$rs['msg']}')</script>";
		}
    }
	public function saveimg_kind(){
		
		$files=$_FILES;
        //oss上传 
		$bucketName = C('oss_bucket');
		$ossClient = new \Org\OSS\OssClient(C('oss_access_id'), C('oss_access_key'), C('oss_endpoint'), false);
		$web=C('oss_web_site');
		//图片  
		$fFiles=$_FILES['imgFile']; 
		$rs=ossUpPic($fFiles,'ybfxyx',$ossClient,$bucketName,$web,0);

		if($rs['code']==0){
			//图片  
			$img = $rs['url']; 
			//如返回里面有缩略图： 
			//$thumb=$rs['thumb']; 
			echo json_encode(array('error' => 0, 'url' => $img));           
		}else{
			echo "<script>alert('{$rs['msg']}')</script>";
		}
    }
	public function saveimg_lay(){
		
		$files=$_FILES;
        //oss上传 
		$bucketName = C('OSS_BUCKET'); 
		$ossClient = new \Org\OSS\OssClient(C('oss_access_id'), C('OSS_ACCESS_KEY'), C('OSS_ENDPOINT'), false);
		$web=C('OSS_WEB_SITE'); 
		//图片  
		$fFiles=$_FILES['file']; 
		$rs=ossUpPic($fFiles,'ekcms',$ossClient,$bucketName,$web,0);  
		if($rs['code']==1){ 
			$ajax['code'] =0;      
			$ajax['msg'] ='上传成功';      
			$ajax['data']['src'] =$rs['url'];
			$ajax['data']['title'] ='';
		}else{
			$ajax['code'] =1;      
			$ajax['msg'] =$rs['msg']; 
		}
		$this->ajaxReturn($ajax);
    }
    
    // 入口验证函数
    public function mb()
    {
        $mb = new IndexController();
        $mb->mb();
    }
}
