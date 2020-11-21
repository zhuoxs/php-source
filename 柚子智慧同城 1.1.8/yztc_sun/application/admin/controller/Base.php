<?php
namespace app\admin\controller;

use app\model\Info;
use app\model\Shopadmin;
use app\model\Store;
use app\model\Storecategory;
use app\model\System;
use app\model\Infocategory;
use think\Controller;
use think\Db;

class Base extends Controller
{
    public $model_name = '';
    public $model = null;//默认模型，如：Cad 的默认模型为 Ad
    public function __construct()
    {
        parent::__construct();
        global $_W;
        //设置默认模型名称
        $name = get_class($this);
        $name = str_replace('app\admin\controller\C','',$name);
        $this->model_name=$name;
        $name = 'app\\model\\'.ucfirst($name);
        if (class_exists($name)){
            $this->model = new $name();
        }
        $system=Db::name('system')->where(array('uniacid'=>$_W['uniacid']))->find();
        if(!$system){
            $config=getSystemConfig()['system'];
            if(StrCode($config['version'],'DECODE')=='free'){
                $this->compareVersion(array('free_num'=>1));
            }else if(StrCode($config['version'],'DECODE')=='advanced'){
            }else{
                $this->error(getErrorConfig('genuine'));
            }
        }
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
    public function get_base_list(){
        $modelName=input('modelName');
        $name = 'app\\model\\'.$modelName;
        $model =new $name;
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
    public function compareVersion($data){
        $num=Db::name('system')->count();
        if($num>=$data['free_num']){
           $this->error(getErrorConfig('free_num'));
        }
    }

//    获取列表页数据
    public function get_list(){
        $modelName=input('modelName');
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        //条件
        $query = function ($query){
            //关键字搜索
            $key = input('get.key');
            if(pdo_fieldexists('yztc_sun_'.strtolower($this->model_name), 'is_del')){
                $query->where('is_del',0);
            }
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
        $info['map_key']=$this->getMapkey();
        $this->view->info=$info;
        $modelName=input('modelName');
        if($modelName){
            $page='add'.$modelName;
            return view($page);
        }else{
            return view('edit');
        }
    }
//    编辑页
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $modelName=ucwords(strtolower(input('modelName'))); ;
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        $id = input('get.id');
        $info = $model->get($id);
        if(isset($info['pics'])){
            $info['pics']=json_decode($info['pics'],true);
        }
        $info['map_key']=$this->getMapkey();
        $this->view->info = $info;
//        var_dump($modelName);exit;
        if($modelName){
            $page='add'.strtolower($modelName);
//            var_dump($page);exit;
            return view($page);
        }else{
            return view('edit');
        }
    }
    //    查看
    public function see(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');
        $modelName=ucwords(strtolower(input('modelName')));
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        $info = $model->get($id);
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
        $ret = $info->allowField(true)->save(input('post.'));
        if($ret){
            return array(
                'code'=>0,
                'data'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }
//    删除
    public function delete($is_del=0){
        $ids = input('post.ids');
        $modelName=ucwords(strtolower(input('modelName')));
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }

        $type=input('post.type',0);
        if($type>0){
            $idslist=explode(',',$ids);
            foreach ($idslist as $value){
                $info=$model->where('id',$value)->find();
                if($info['is_activity']==1){
                    $act=new \app\model\Activity();
                    $act->where(['goods_id'=>$value,'type'=>$type])->delete();
                }
            }
        }
        if(pdo_fieldexists('yztc_sun_'.strtolower($modelName), 'is_del')) {
            $ret = $model->where('id','in',$ids)->update(['is_del'=>1]);
        }else if(pdo_fieldexists('yztc_sun_'.strtolower($this->model_name), 'is_del')&&$is_del==1){
            $ret = $model->where('id','in',$ids)->update(['is_del'=>1]);
        }else{
            $ret = $model->destroy($ids);
        }

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
        $modelName=ucwords(strtolower(input('modelName')));
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        $ret = $model->where('id','in',$ids)->update(['show_index'=>1]);
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
        $modelName=ucwords(strtolower(input('modelName')));
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        $ret = $model->where('id','in',$ids)->update(['show_index'=>0]);
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
        $type=input('post.type',0);
        $modelName=ucwords(strtolower(input('modelName')));
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        $ret = $model->where('id','in',$ids)->update(['state'=>1]);
        if($type>0){
        /*    $idslist=explode(',',$ids);
            foreach ($idslist as $value){
                $info=$model->where('id',$value)->find();
                if($info['is_activity']==1){
                    $act=new \app\model\Activity();
                    $act->where(['goods_id'=>$value,'type'=>$type])->update(['state'=>1]);
                }
            }*/
        }
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
        $type=input('post.type',0);
        $modelName=ucwords(strtolower(input('modelName')));
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        $ret = $model->where('id','in',$ids)->update(['state'=>0]);
        if($type>0){
          /*  $idslist=explode(',',$ids);
            foreach ($idslist as $value){
                $info=$model->where('id',$value)->find();
                if($info['is_activity']==1){
                    $act=new \app\model\Activity();
                    $act->where(['goods_id'=>$value,'type'=>$type])->update(['state'=>0]);
                }
            }*/
        }
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
        $modelName=ucwords(strtolower(input('modelName')));
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        $ret = $model->where('id','in',$ids)->update(['is_recommend'=>1]);
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
        $modelName=ucwords(strtolower(input('modelName')));
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        $ret = $model->where('id','in',$ids)->update(['is_recommend'=>0]);
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
//推荐
    public function batchrecommend(){
        $ids = input("post.ids");
        $modelName=ucwords(strtolower(input('modelName')));
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        $ret = $model->where('id','in',$ids)->update(['is_recommend'=>1]);
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
    public function batchunrecommend(){
        $ids = input("post.ids");
        $modelName=ucwords(strtolower(input('modelName')));
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        $ret = $model->where('id','in',$ids)->update(['is_recommend'=>0]);
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
        $modelName=ucwords(strtolower(input('modelName')));
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        $ret = $model->where('id','in',$ids)->update(['store_show'=>1]);
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
        $modelName=ucwords(strtolower(input('modelName')));
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        $ret = $model->where('id','in',$ids)->update(['store_show'=>0]);
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
//        var_dump($ids);exit;
        $modelName=ucwords(strtolower(input('modelName')));
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        $ret = $model->where('id','in',$ids)->update(['check_status'=>2]);
        if($ret){
            if($modelName=='Shop'){
                $ids=explode(',',$ids);

                if(is_array($ids)){
                    foreach ($ids as $val){
                        $info=$model->mfind(['id'=>$val]);
//                        var_dump($info);exit;
                        $sadmin=new Shopadmin();
                        $sadmin->allowField(true)->save(['user_id'=>$info['user_id'],'sid'=>$val,'auth'=>1]);
//                        Shopadmin::create();
                    }
                }else{
                    $info=$model->mfind(['id'=>$ids]);
                    Shopadmin::create(['user_id'=>$info['user_id'],'sid'=>$ids,'auth'=>1]);
                }

            }
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
        $modelName=ucwords(strtolower(input('modelName')));
        if($modelName){
            $name = 'app\\model\\'.$modelName;
            $model =new $name;
        }else{
            $model = $this->model;
        }
        $ret = $model->where('id','in',$ids)->where('check_status',1)->update(['check_status'=>3,'fail_reason'=>$fail_reason]);
        if($ret){
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
       $url=getWxAppUrl();
       return $url;
    }
    //获取地图KEY
    public function getMapkey(){
        $key=System::get_curr()['map_key'];
        return $key;
    }
    //获取分类信息链接
    public function getInfoAppUrl(){
        $infocategory=(new Infocategory())->where(['type'=>1,'parent_id'=>0,'state'=>1])->select();
        $shop_url=array();
        foreach($infocategory as $k=>$val){
            $shop_url[$k]['name']=$val['name'];
            $shop_url[$k]['value']='/pages/circle/circle?cat_id='.$val['id'];
        }
        return $shop_url;
    }
    //获取商户信息链接
    public function getStoreAppUrl(){
        $store=(new Storecategory())->where(['state'=>1])->select();
        $store_url=array();
        foreach($store as $k=>$val){
            $store_url[$k]['name']=$val['name'];
            $store_url[$k]['value']='/pages/merchants/merchants?cat_id='.$val['id'];
        }
        return $store_url;
    }
}
