<?php
namespace app\admin\controller;

use app\model\Customize;

class Csystem extends Base
{
    public function smallapp(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = $this->model->get_curr();
        $this->view->info = $info;
        return view('smallapp');
    }
    public function team(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = $this->model->get_curr();
        $this->view->info = $info;
        return view('team');
    }
    public function platform(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = $this->model->get_curr();
        $this->view->info = $info;
        return view('platform');
    }
    public function appstyle(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = $this->model->get_curr();
        $this->view->info = $info;
        return view('appstyle');
    }
    public function down(){
        $url = input('post.url');
        if ($url){
            $name = input('post.name')?:(time().".mp4");

            ob_start();
            header( "Content-type:  application/octet-stream ");
            header( "Accept-Ranges:  bytes ");
            header( "Content-Disposition:  attachment;  filename= ".$name);
            header( "Accept-Length: " .readfile($url));
            exit;
        }

        return view('down');
    }
    public function upload(){
        global $_W;
        $file = $_FILES['file'];
//        验证文件格式
        if($file['type']!='application/octet-stream'){
            throw new \ZhyException('文件类型只能为pem格式');
        }
//        验证文件大小
        if($file['size']>2*1024*1024) {
            throw new \ZhyException('上传文件过大，不得超过2M');
        }

        //判断是否上传成功
        if(!is_uploaded_file($file['tmp_name'])) {
            throw new \ZhyException('上传失败');
        }

        //把文件转存到你希望的目录（不要使用copy函数）
        $uploaded_file=$file['tmp_name'];
        //我们给每个用户动态的创建一个文件夹
        $user_path=IA_ROOT."/addons/yztc_sun/cert/";

        //判断该用户文件夹是否已经有这个文件夹
        if(!file_exists($user_path)) {
            mkdir($user_path);
        }
        $file_true_name=$file['name'];
        $file_true_name = rtrim($file_true_name,'.pem');
        $file_true_name = $file_true_name . '_' . $_W['uniacid'] . '.pem';
        $move_to_file=$user_path.$file_true_name;
        //echo "$uploaded_file   $move_to_file";
        if(!move_uploaded_file($uploaded_file,iconv("utf-8","gb2312",$move_to_file))) {
            throw new \ZhyException('上传失败');
        }
        $data = [];
        $data['src'] = $file_true_name;
        success_json($data);
    }
    public function save(){
        $info = $this->model;
        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }
        $ret = $info->allowField(true)->save(input('post.'));
        if($ret){
            return array(
                'code'=>0,
                'data'=>$info->id,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }
    /**
     * 菜单图标自定义列表
    */
    public function menuicon(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view('menuicon');
    }
    /**
     * 新增、编辑
     */
    public function addmenuicon(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $cus=new Customize();
        $id=input('get.id');
        if($id){
            $info =$cus->getMenu($id);
            $this->view->info = $info;
        }
        $this->view->linkurl =getWxAppUrl();
        return view('addmenuicon');
    }
    public function savemenuicon(){
        global $_W;
        $info=new Customize();
        $id = input('post.id');
        if ($id){
            $info = $info->getMenu($id);
        }
        $data = input('post.');
        $data['uniacid'] = $_W['uniacid'];
        $ret = $info->allowField(true)->save($data);
        if($ret){
            return array(
                'code'=>0,
                'data'=>$info->id,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }
    public function get_menuicon_list(){
        global $_W;
        $model =new Customize();

        //排序、分页
        $model->fill_order_limit();
        //条件
//        $query = function ($query){
//            //关键字搜索
////            $key = input('get.key');
////            if ($key){
////                $query->where('name','like',"%$key%")->whereOr('control','like',"%$key%")->whereOr('action','like',"%$key%");
////            }
//            $query->where('type',2);
//
//        };

        $where['type']=2;
        $where['uniacid']=$_W['uniacid'];
        $list = $model->where($where)->select();
        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    /**
     * 删除
    */
    public function deletem(){
        $ids = input('post.ids');
        $cus=new Customize();
        $ret = $cus->destroy($ids);
        if($ret){
            return array(
                'code'=>0,
                'data'=>$ret,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'删除失败',
            );
        }
    }
    public function updateapp()
    {
        if(function_exists("generate_update_app")){
            return generate_update_app();
        }else{
            return "系统更新模块加载失败!";
        }
    }


}
