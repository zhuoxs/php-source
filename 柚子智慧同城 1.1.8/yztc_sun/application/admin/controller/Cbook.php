<?php
namespace app\admin\controller;


use app\model\Activity;
use app\model\Goodsattr;
use app\model\Goodsattrgroup;
use app\model\Goodsattrsetting;
use app\model\Store;
use app\model\Goods;
use app\model\Distributionset;
use think\Db;

class Cbook extends Base
{
    public function get_list(){
       // $model = $this->model;
        $model=new Goods();
        //条件
        $query = function ($query){
            if($_SESSION['admin']['store_id']>0){
                $query->where('store_id',$_SESSION['admin']['store_id']);
            }
            $query->where('goods_type',2);
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
            $cat_id = input('get.cat_id');
            if ($cat_id){
                $query->where('cat_id',"$cat_id");
            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->with(['attrgroups','store'])->where($query)->order('id desc')->select();


        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function see(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');

        //        获取规格设置
        $attrsetting_model = new Goodsattrsetting();
        $attrsetting_list = $attrsetting_model->where('goods_id',$id)->select();

//        获取规格分组信息
        $attrgroup_model = new Goodsattrgroup();
        $attrgroup_list = $attrgroup_model->with('attrs')->where('goods_id',$id)->select();
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
        $model=new Goods();
        $info = $model->get($id,['category','platform_category']);
        $info['pics'] = json_decode($info['pics']);
        $this->view->info = $info;
        return view();
    }
    //仅限会员购买
    public function batchonlyvip(){
        $ids = input("post.ids");
        $model=new Goods();
        $ret = $model->where('id','in',$ids)->update(['only_vip'=>1]);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'设置失败',
            );
        }
    }

    //取消仅限会员购买
    public function batchunonlyvip(){
        $ids = input("post.ids");
        $model=new Goods();
        $ret = $model->where('id','in',$ids)->update(['only_vip'=>0]);
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


    //会员免单
    public function batchwelfare(){
        $ids = input("post.ids");
        $model=new Goods();
        $ret = $model->where('id','in',$ids)->update(['is_welfare'=>1]);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'设置失败',
            );
        }
    }
//    取消会员免单
    public function batchunwelfare(){
        $ids = input("post.ids");
        $model=new Goods();
        $ret = $model->where('id','in',$ids)->update(['is_welfare'=>0]);
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
//    新增页
    public function add(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;

        $this->view->attrgroup_list = [];
        $this->view->attrsetting_list = [];

        $info = new Goods();
        $info['details'] = '';
        $info['use_attr'] = 0;
        $info['is_welfare']=0;
        $info['only_vip']=0;
        $info['sales_num_virtual']=0;
        $info['end_time']=time();
        $info['expire_time']=time();
        $info['is_activity']=0;
        $info['distribution_open']=0;
        $info['commissiontype']=0;
        $info['is_support_refund']=0;
        $this->view->info = $info;
        $this->view->distributionset=Distributionset::get_curr();
        return view('edit');
    }
//    编辑页
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');

        //        获取规格设置
        $attrsetting_model = new Goodsattrsetting();
        $attrsetting_list = $attrsetting_model->where('goods_id',$id)->select();

//        获取规格分组信息
        $attrgroup_model = new Goodsattrgroup();
        $attrgroup_list = $attrgroup_model->with('attrs')->where('goods_id',$id)->select();
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
        $model=new Goods();
        $info = $model->get($id,['category','platform_category']);
        $info['pics'] = json_decode($info['pics']);
        $this->view->info = $info;
        $this->view->distributionset=Distributionset::get_curr();
        return view('edit');
    }
//    复制编辑页
    public function copy(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');

        //        获取规格设置
        $attrsetting_model = new Goodsattrsetting();
        $attrsetting_list = $attrsetting_model->where('goods_id',$id)->select();

//        获取规格分组信息
        $attrgroup_model = new Goodsattrgroup();
        $attrgroup_list = $attrgroup_model->with('attrs')->where('goods_id',$id)->select();
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

        $model=new Goods();
        $info = $model->get($id,['category','platform_category']);
        $info['pics'] = json_decode($info['pics']);
        unset($info->id);
        $this->view->info = $info;
        return view('edit');
    }
    //    数据保存（新增、编辑）
    public function save(){
       // $info = $this->model;
        $info= new Goods();

        $id = input('post.id');
        if ($id) {
            $info = $info->get($id, 'category');
        }

        $data = input('post.');
        $data['goods_type']=2;
//        补充商户id信息
        if (!$data['store_id']){
            $data['store_id'] = $_SESSION['admin']['store_id'];
        }
        if($data['end_time']){
            $data['end_time']=strtotime($data['end_time']);
        }
        if($data['expire_time']){
            $data['expire_time']=strtotime($data['expire_time']);
        }
//        维护商户商品数量
        if (!$id && $data['store_id']){
            $info->check_version();
            $store = Store::get($data['store_id']);
            $store->goods_count = $store->goods_count +1;
            $store->save();
        }
//        判断是否需要重新审核
        if ($data['store_id']){
            if($id){
                $config = \app\model\Config::get(['key'=>'goods_update_check']);
            }else{
                $config = \app\model\Config::get(['key'=>'goods_insert_check']);
            }
            $be_check = $config['value']?:0;
            $session_store_id=$_SESSION['admin']['store_id'];
            if($session_store_id==0){
                $data['check_status'] = 2;
            }else{
                if ($be_check){
                    $data['check_status'] = 1;
                    $data['fail_reason'] = '';
                }else{
                    $data['check_status'] = 2;
                }
            }
        }
        $data['pics'] = json_encode($data['pics']);
        $ret = $info->allowField(true)->save($data);

        if(!$id){
            $id=Db::name('goods')->getLastInsID();
        }
        //加入总活动表
        $activity=[
            'type'=>1,
            'cat_id'=>$data['cat_id'],
            'goods_id'=>$id,
            'name'=>$data['name'],
            'store_id'=>$data['store_id'],
            'end_time'=>$data['end_time'],
            'original_price'=>$data['original_price'],
            'sale_price'=>$data['price'],
            'vip_price'=>$data['vip_price'],
            'pic'=>$data['pic'],
            'check_status'=>$data['check_status'],
            'is_activity'=>$data['is_activity'],
        ];
        (new Activity())->addActivityByGoods($activity);

        if($ret){
            if($info->use_attr){
//            修改分组信息的 goods_id
                $attrs_data = $data['attrs_data'];
                $attrs_data = json_decode($attrs_data);

                $attrgroup_model = new Goodsattrgroup();
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

                $attrsetting_model = new Goodsattrsetting();
                $attrsetting_model->where('goods_id',$info->id)->delete();

                $num = 0;
                foreach ($attrsettings as $attrsetting) {
                    $attrsetting = (array)$attrsetting;
                    $num += $attrsetting['stock'];
                    $attrsetting_model = new Goodsattrsetting();
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
    //    审核商品列表页
    public function index2()
    {
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view();
    }
    public function get_list2(){
        //$model = $this->model;
        $model=new Goods();

        //条件
        $query = function ($query){
            $query->where('store_id',['<>',0]);
            $query->where('check_status',1);
            //关键字搜索
            $key = input('get.key');
            if ($key){
                $query->where('name','like',"%$key%");
            }
        };

        //排序、分页
        $model->fill_order_limit();

        $list = $model->with('store')->where($query)->select();

        return [
            'code'=>0,
            'count'=>$model->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
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
            //$model = $this->model;
            $model=new Goods();
        }
        $ret = $model->where('id','in',$ids)->update(['check_status'=>2]);

        //修改总活动审核信息
        if(is_array($ids)){
            foreach($ids as $item){
                $goods=Goods::get($item);
                if($goods['is_activity']==1){
                    (new Activity())->addActivityByGoods(['type'=>1,'goods_id'=>$item,'check_status'=>2,'is_activity'=>1]);
                }

            }
        }else{
            $goods=Goods::get($ids);
            if($goods['is_activity']==1) {
                (new Activity())->addActivityByGoods(['type' => 1, 'goods_id' => $ids, 'check_status' => 2,'is_activity'=>1]);
            }
        }

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
            //$model = $this->model;
            $model=new Goods();
        }
        $ret = $model->where('id','in',$ids)->where('check_status',1)->update(['check_status'=>3,'fail_reason'=>$fail_reason]);
        //修改总活动审核信息
        if(is_array($ids)){
            foreach($ids as $item){
                $goods=Goods::get($item);
                if($goods['is_activity']==1){
                    (new Activity())->addActivityByGoods(['type'=>1,'goods_id'=>$item,'check_status'=>3,'is_activity'=>1]);
                }
            }
        }else{
            $goods=Goods::get($ids);
            if($goods['is_activity']==1) {
                (new Activity())->addActivityByGoods(['type' => 1, 'goods_id' => $ids, 'check_status' =>3,'is_activity'=>1]);
            }
        }

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

//    删除
    public function delete($is_del=0){
        $ids = input('post.ids');
        $model = new Goods();
        if(pdo_fieldexists('yztc_sun_goods', 'is_del')) {
            $ret = $model->where('id','in',$ids)->update(['is_del'=>1]);
        }else if(pdo_fieldexists('yztc_sun_goods', 'is_del')&&$is_del==1){
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

    //    启用
    public function batchenable(){
        $ids = input("post.ids");
        $model = new Goods();
        $ret = $model->where('id','in',$ids)->update(['state'=>1]);
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
        $model = new Goods();
        $ret = $model->where('id','in',$ids)->update(['state'=>0]);
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
    //推荐
    public function batchrecommend(){
        $ids = input("post.ids");
        $model = new Goods();
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
        $model = new Goods();
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
}
