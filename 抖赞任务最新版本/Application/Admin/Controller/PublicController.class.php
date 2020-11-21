<?php
namespace Admin\Controller;

use Org\Net\UploadFile;
use Think\Controller;

class PublicController extends Controller{
    public function login()
    {
        if(IS_POST){
            // 做一个简单的登录 组合where数组条件
            $map=I('post.');
            $map['password']=md5($map['password']);
            $data=M('Users')->where($map)->find();
            if (empty($data)) {
                $this->error('账号或密码错误');
            }else{
                $_SESSION['user']=array(
                    'id'=>$data['id'],
                    'username'=>$data['username'],
                    'avatar'=>$data['avatar']
                );
                $this->redirect('Admin/Index/index');
                //$this->success('登录成功、前往管理后台',U('Admin/Index/index'));
            }
        }else{
            $data=check_login() ? $_SESSION['user']['username'].'已登录' : '未登录';
            $assign=array(
                'data'=>$data
            );
            $this->assign($assign);
            $this->display();
        }
    }

    /**
     * 退出
     */
    public function logout(){
        session('user',null);
        $this->redirect('Admin/Public/login');
    }



    //文件上传
    public function swfupload() {
        //保存路径，不包含Uploads
        $path = rtrim(isset($_REQUEST['path']) ? trim($_REQUEST['path']) : '/other', '/');
        $path = implode('/', explode('_', $path) ).'/';
        $this->assign('path', $path);
        $this->assign('thumb_width', $_REQUEST['thumb_width']);
        $this->assign('thumb_height', $_REQUEST['thumb_height']);
        //上传文件类型
        $file_type = explode(',', C('UPLOAD_FILES_TYPE'));
        foreach( $file_type as $v ) $file_types .= '*.'.$v.';';
        $this->assign('file_types', rtrim( $file_types, ',' ));

        $this->display();
    }

    /**
    +----------------------------------------------------------
     * jquery 文件上传
    +----------------------------------------------------------
     * POST URL： __URL__/Upload/field/images/path/Folder1_Folder2
    +----------------------------------------------------------
     * 说明： field 表单字段参数为images
     *       path  路径 Folder1_Folder2 拆分为多级目录 Folder1/Folder2
    +----------------------------------------------------------*/
    public function Upload(){
        $path = './Upload/'.$_POST['path'];
        if (!file_exists($path)){
            mkdirs($path);
        }
        $upload = new UploadFile();
        $upload->maxSize  = C('UPLOAD_FILES_MAXSIZE');
        $upload->allowExts  = explode(',', C('UPLOAD_FILES_TYPE'));
        $upload->savePath =  $path;
        $upload->saveRule = 'uniqid';
        $isThumb = isset($_POST['thumb_width']) && isset($_POST['thumb_height']) ? true : false;
        $upload->thumb = $isThumb;
        $upload->thumbMaxWidth = $_POST['thumb_width'];
        $upload->thumbMaxHeight = $_POST['thumb_height'];
        $upload->uploadReplace = false;
        $upload->thumbPrefix = 'm_';
        //删除原图
        $upload->thumbRemoveOrigin  = false;
        if (!$upload->upload()) {
            //捕获上传异常
            //$this->error($upload->getErrorMsg());
            return false;
        } else {
            $info = $upload->getUploadFileInfo ();
            foreach( $info[0] as $key=>$val ){
                $list[$key] = trim($val);
            }
            $this->ajaxReturn($list);
        }

    }
}
