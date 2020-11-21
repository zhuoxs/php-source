<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/2
 * Time: 15:52
 */
namespace app\admin\controller;


use app\model\Panic;
use app\model\Panicattr;
use app\model\Panicattrgroup;
use app\model\Panicattrsetting;
use app\model\Panicladder;
use app\model\Distributionset;
use think\cache\driver\Redis;
use think\Db;

class Cpanic extends Base
{
    public function get_list()
    {
        $model = $this->model;

        //条件
        $query = function ($query) {
            if ($_SESSION['admin']['store_id'] > 0) {
                $query->where('store_id', $_SESSION['admin']['store_id']);
            }
            //关键字搜索
            $key = input('get.key');
            if ($key) {
                $query->where('name', 'like', "%$key%");
            }
            $cat_id = input('get.cat_id');
            if ($cat_id) {
                $query->where('cat_id', "$cat_id");
            }
            $store_id=input('get.store_id');
            if ($store_id) {
                $query->where('store_id', "$store_id");
            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->with('store')->where($query)->select();
        foreach ($list as $key =>$value){
            $list[$key]['store_name']=$value['store']['name'];
        }
        return [
            'code' => 0,
            'count' => $model->where($query)->count(),
            'data' => $list,
            'msg' => '',
        ];
    }
    //新增页
    public function add(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info['map_key']=$this->getMapkey();
        $this->view->info=$info;
        $this->view->distributionset=Distributionset::get_curr();
        $modelName=input('modelName');
        if($modelName){
            $page='add'.$modelName;
            return view($page);
        }else{
            return view('edit');
        }
    }
    //TODO::编辑
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');

        //        获取规格设置
        $attrsetting_model = new Panicattrsetting();
        $attrsetting_list = $attrsetting_model->where('goods_id',$id)->select();

//        获取规格分组信息
        $attrgroup_model = new Panicattrgroup();
        $attrgroup_list = $attrgroup_model->with('attrs')->where('goods_id',$id)->select();
//        var_dump($attrgroup_list);exit();
        foreach ($attrgroup_list as &$item) {
            $attrs = [];
            foreach ($item['attrs'] as $attr) {
//                处理规格设置
                foreach ($attrsetting_list as &$attrsetting) {
                    if(strpos($attrsetting['key'],",{$attr['name']},") !== false){
                        $attrsetting[$item['name']] = $attr['name'];
                    }
                }

                $attrs[] = $attr['name'];
            }
        }
        $this->view->attrgroup_list = $attrgroup_list;


        $this->view->attrsetting_list = $attrsetting_list;
        $model=new Panic();
        $info =Panic::get($id);
        $info['pics'] = json_decode($info['pics']);
        if($info['start_time']){
            $info['start_time']=date('Y-m-d H:i:s',$info['start_time']);
        }
        if($info['end_time']){
            $info['end_time']=date('Y-m-d H:i:s',$info['end_time']);
        }

        if($info['expire_time']){
            $info['expire_time']=date('Y-m-d H:i:s',$info['expire_time']);
        }
        $this->view->distributionset=Distributionset::get_curr();
        $this->view->info =$info;
        return view('edit');
    }
    public function saves(){
        global $_W;
        $info = $this->model;
        $id = input('post.id');
        if ($id) {
            $info = $info->get($id);
        }

        $data = input('post.');
//        补充商户id信息
        if (!$data['store_id']){
            $data['store_id'] = $_SESSION['admin']['store_id'];
        }
        $data['check_status']=2;
        if(!$id){
            $info->check_version();
        }

//        if($data['store_id']>0){
//            $conf_add=\app\model\Config::get_value('pin_add_check');
//            $conf_update=\app\model\Config::get_value('pin_update_check');
//            if(($conf_add['pin_add_check']==1)&&(!$id)){
//                $data['check_status']=1;
//            }elseif (($conf_update['pin_update_check']==1)&&($id)){
//                $data['check_status']=1;
//            }else{
//                $data['check_status']=2;
//            }
//        }
        $data['start_time']=strtotime(input('post.start_time'));
        $data['end_time']=strtotime(input('post.end_time'));
        $data['expire_time']=strtotime(input('post.expire_time'));
        $data['pics'] = json_encode($data['pics']);

        if($id>0){
            if($info['is_activity']==1){
                $act['name']=$data['name'];
                $act['cat_id']=$data['cat_id'];
                $act['store_id']=$data['store_id'];
                $act['start_time']=$data['start_time'];
                $act['end_time']=$data['end_time'];
                $act['original_price']=$data['original_price'];
                $act['sale_price']=$data['panic_price'];
                $act['vip_price']=$data['vip_price'];
                $act['pic']=$data['pic'];
                $act['check_status']=$data['check_status'];
                $act['state']=$data['state'];
                \app\model\Activity::update($act,['type'=>2,'goods_id'=>$id]);
            }

        }
        $ret = $info->allowField(true)->save($data);
        if($id){
            $islad=Panicladder::get(['goods_id'=>$id]);
            if($islad){
                $lad=new Panicladder();
                $lad->where(['goods_id'=>$id])->delete();
            }
        }
        if(input('is_ladder')==1){
            $ladder=json_decode(input('post.ladder_info'),true);
            $ladder_list=array();
            foreach ($ladder as $lkey=>$lval){
                $ldata = [];
                $ldata['panic_num'] = $lval['panic_num'];
                $ldata['panic_price'] = $lval['panic_price'];
                $ldata['vip_price'] = $lval['vip_price'];
                $ldata['goods_id'] = $info->id;
                $ldata['uniacid']=$_W['uniacid'];
                $ldata['create_time']=time();
                $ladder_list[] = $ldata;
            }
            Db::name('panicladder')->insertAll($ladder_list);
        }
        if($ret){

            if(input('post.use_attr')==1){
//            修改分组信息的 goods_id
                $attrs_data = $data['attrs_data'];
                $attrs_data = json_decode($attrs_data);
                $attrgroup_model = new Panicattrgroup();
                $group_list = [];
                foreach ($attrs_data as $key => $attr_group) {
                    if (!$attr_group){
                        continue;
                    }
                    $group_data = [];
                    $group_data['id'] = $key;
                    $group_data['goods_id'] = $info->id;
                    $group_list[] = $group_data;
                }
                $attrgroup_model->saveAll($group_list);

//              保存规格设置
                $attrsettings = $data['attr'];
                $attrsettings = json_decode($attrsettings);

                $attrsetting_model = new Panicattrsetting();
                $attrsetting_model->where('goods_id',$info->id)->delete();

                $num = 0;
                foreach ($attrsettings as $attrsetting) {
                    $attrsetting = (array)$attrsetting;
                    $num += $attrsetting['stock'];
                    $attrsetting_model = new Panicattrsetting();
                    $attrsetting = (array)$attrsetting;
                    $attrsetting['goods_id'] = $info->id;

//                name
                    $names = [];
                    foreach ($attrs_data as $key => $attr_group) {
                        if (!$attr_group){
                            continue;
                        }
                        $attr_group = (array)$attr_group;
                        $names[] = $attrsetting[$attr_group['name']];
                    }
                    $attrsetting['key'] = ','.implode(',',$names).',';
                    $attrsetting['attr_ids'] = $attrsetting['ids']? ','.implode(',',$attrsetting['ids']).',':$attrsetting['attr_ids'];
                    $attrsetting_model->allowField(true)->save($attrsetting);
                }
                $info->stock = $num;
                $info->save();

            }

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
    //TODO::添加分组名称
    public function savegroupname(){
        $info=new Panicattrgroup();
//        $data=input('post.');
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
    public function deletepanicattrgroup(){
        $info=new Panicattrgroup();
        $ids = input("post.ids");
        $ret =$info->where('id','in',$ids)->delete();
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'删除失败',
            );
        }
    }

    public function savegroupvalue(){
        $info=new Panicattr();
//        $data=input('post.');
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
    public function deletepanicattr(){
        $info=new Panicattr();
        $ids = input("post.ids");
        $ret =$info->where('id','in',$ids)->delete();
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'删除失败',
            );
        }
    }
    //TODO:：添加活动列表
    public function btnBatchAddActivity(){
        $ids=input('post.ids');
        $info=new Panic();
        $ret =$info->where('id','in',$ids)->update(['is_activity'=>1]);
        $idslist=explode(',',$ids);
        foreach ($idslist as $value){
            $model=new \app\model\Activity();
            $panicinfo=Panic::get($value);
            $data['type']=2;
            $data['name']=$panicinfo['name'];
            $data['cat_id']=$panicinfo['cat_id'];
            $data['goods_id']=$value;
            $data['store_id']=$panicinfo['store_id'];
            $data['start_time']=$panicinfo['start_time'];
            $data['end_time']=$panicinfo['end_time'];
            $data['original_price']=$panicinfo['original_price'];
            $data['sale_price']=$panicinfo['panic_price'];
            $data['vip_price']=$panicinfo['vip_price'];
            $data['pic']=$panicinfo['pic'];
            $data['check_status']=$panicinfo['check_status'];
            $data['state']=$panicinfo['state'];
            $model->allowField(true)->save($data);
        }
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'添加失败',
            );
        }
    }
    //删除添加到活动列表
    public function btnBatchDelActivity(){
        $ids = input("post.ids");
        $model=new \app\model\Activity();
        $idslist=explode(',',$ids);
        foreach ($idslist as $value){
            $model->where(['goods_id'=>$value,'type'=>2])->delete();
        }
        $panic=new Panic();
        $ret =$panic->where('id','in',$ids)->update(['is_activity'=>0]);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'关闭失败',
            );
        }
    }
}