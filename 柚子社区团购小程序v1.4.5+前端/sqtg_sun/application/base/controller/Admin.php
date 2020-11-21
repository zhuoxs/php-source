<?php
namespace app\base\controller;

use think\Controller;
use think\Db;

class Admin extends Controller
{
    public $model_name = '';
    public $model = null;//默认模型，如：Cad 的默认模型为 Ad
    public function __construct()
    {
        parent::__construct();
        //设置默认模型名称
        $name = get_class($this);
        $name = str_replace('app\admin\controller\C','',$name);
        $name = 'app\\model\\'.ucfirst($name);

        if (class_exists($name)){
            $this->model = new $name();
        }
        //个例解除注释
        //header("Content-Security-Policy: upgrade-insecure-requests");
    }

//    列表页
    public function index()
    {
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view();
    }
//    获取列表页数据
    public function get_list(){
        $model = $this->model;

        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->where($query)->select();

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
//    新增页
    public function add(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
//        $this->view->info = $this->model;
        $modelName=input('modelName');
        if($modelName){
            $page='add'.$modelName;
            return view($page);
        }else{
            return view('edit');
        }
        return view('edit');
    }
//    编辑页
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');
        $info = $this->model->get($id);
        $this->view->info = $info;
        return view('edit');
    }
    //    查看
    public function see(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');
        $info = $this->model->get($id);
        unset($info->id);
        $this->view->info = $info;
        return view();
    }
//    复制编辑页
    public function copy(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');
        $info = $this->model->get($id);
        unset($info->id);
        $this->view->info = $info;
        return view('edit');
    }
//    数据保存（新增、编辑）
    public function save(){
        $modelName=input('modelName');
        if(isset($modelName)){

            $name = 'app\\model\\'.$modelName;
            $info =new $name;
        }else{
            $info = $this->model;
        }
        $id = input('post.id');
        if ($id){
            $info = $info->get($id);
        }
        $data=input('post.');
        if(isset($data['pics'])&&is_array($data['pics'])){
            $data['pics'] = json_encode($data['pics']);
        }
        $ret = $info->allowField(true)->save($data);
        if($ret){
            return array(
                'code'=>0,
                'data'=>$info->id
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }
//    删除
    public function delete(){
        $ids = input('post.ids');
        $ret = $this->model->destroy($ids);
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
//    获取列表信息，用于前端 select2 请求
    public function select(){
        $model = $this->model;
        $model->field("id,name as text");
        $list = $model->select();
        return $list;
    }

//    检查是否登录
    public function check_login(){
        $admin = $_SESSION['admin'];
        if (isset($admin['name']) && $admin['name']){
            return $admin;
        }
        header('location:'.adminurl('login'));
        exit;
    }

    //    弹窗选择
    public function choose(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view('choose');
    }
    //显示首页
    public function showindexenable(){
        $ids = input("post.ids");
        $ret = $this->model->where('id','in',$ids)->update(['show_index'=>1]);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'启用失败',
            );
        }
    }

    //不显示首页
    public function showindexdisable(){
        $ids = input("post.ids");
        $ret = $this->model->where('id','in',$ids)->update(['show_index'=>0]);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'启用失败',
            );
        }
    }

//    启用
    public function batchenable(){
        $ids = input("post.ids");
        $ret = $this->model->where('id','in',$ids)->update(['state'=>1]);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'启用失败',
            );
        }
    }
//    禁用
    public function batchunenable(){
        $ids = input("post.ids");
        $ret = $this->model->where('id','in',$ids)->update(['state'=>0]);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'禁用失败',
            );
        }
    }

//    推荐
    public function batchhot(){
        $ids = input("post.ids");
        $ret = $this->model->where('id','in',$ids)->update(['is_hot'=>1]);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'推荐失败',
            );
        }
    }
//    取消推荐
    public function batchunhot(){
        $ids = input("post.ids");
        $ret = $this->model->where('id','in',$ids)->update(['is_hot'=>0]);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'取消失败',
            );
        }
    }
    //    商户中显示
    public function batchstoreshow(){
        $ids = input("post.ids");
        $ret = $this->model->where('id','in',$ids)->update(['store_show'=>1]);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'显示失败',
            );
        }
    }
//    商户中隐藏
    public function batchunstoreshow(){
        $ids = input("post.ids");
        $ret = $this->model->where('id','in',$ids)->update(['store_show'=>0]);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'隐藏失败',
            );
        }
    }

//    审核通过
    public function batchchecked(){
        $ids = input("post.ids");
        $list = $this->model->where('id','in',$ids)->where('check_state',1)->select();
        $success_num = 0;
        foreach ($list as $item) {
            $item->check_state = 2;
            $item->check_time = time();
            $ret = $item->save();
            if ($ret){
                $success_num++;
            }
        }
        if($success_num){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'审核失败',
            );
        }
    }
//    打回
    public function batchcheckedfail(){
        $ids = input("post.ids");
        $fail_reason = input("post.fail_reason");

        $list = $this->model->where('id','in',$ids)->where('check_state',1)->select();
        $success_num = 0;
        foreach ($list as $item) {
            $item->check_state = 3;
            $item->check_time = time();
            $item->fail_reason = $fail_reason;
            $ret = $item->save();
            if ($ret){
                $success_num++;
            }
        }
        if($success_num){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'打回失败',
            );
        }

    }

    //获取小程序内部链接
    public function getWxAppUrl(){
       $pluginkey=Db::name('pluginkey')->field('name,value')->select();
       $url=getWxAppUrl();
       if($pluginkey){
           foreach ($pluginkey as $val){
               if(!empty($val['value'])) {
                   $url[] = $val;
               }
           }
       }
       return $url;
    }
    //    导出 csv
    public function toCSV($filename, $tileArray=array(), $dataArray=array()){
        ini_set('memory_limit','512M');
        ini_set('max_execution_time',0);
        ob_end_clean();
        ob_start();
        header("Content-Type: text/csv");
        header("Content-Disposition:filename=".$filename);
        $fp=fopen('php://output','w');
        fwrite($fp, chr(0xEF).chr(0xBB).chr(0xBF));//转码 防止乱码(比如微信昵称(乱七八糟的))
        fputcsv($fp,$tileArray);
        $index = 0;
        foreach ($dataArray as $item) {
            // if($index==5000){
            //     $index=0;
            //     ob_flush();
            //     flush();
            // }
            $index++;
            fputcsv($fp,$item);
        }

        ob_flush();
        flush();
        ob_end_clean();
    }
    public function updateByField(){
        $id = input('request.id',0);
        $field = input('request.field','');
        $value = input('request.value','');

        $model = $this->model->where('id',$id)->find();
        $model->{$field} = $value;
        $ret = $model->save();

        if ($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                '修改失败',
            );
        }
    }
}
