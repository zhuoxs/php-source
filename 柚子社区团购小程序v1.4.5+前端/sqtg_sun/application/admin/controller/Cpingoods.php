<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 14:53
 */
namespace app\admin\controller;

use app\base\controller\Admin;
use app\model\Pinclassify;
use app\model\Pingoods;
use app\model\Pingoodsattr;
use app\model\Pingoodsattrgroup;
use app\model\Pingoodsattrsetting;
use app\model\Pinladder;
use app\model\Pinorder;
use app\model\Pinrefund;
use app\model\Payrecord;
use app\model\Shop;
use app\model\Leader;
use app\model\User;
use app\model\Task;
use app\model\Pinheads;
use think\Db;

class Cpingoods extends Admin
{
    public function get_goods_list(){
        global $_W;
        $model =new Pingoods();
        //排序、分页
        $model->fill_order_limit();
        $where['uniacid']=$_W['uniacid'];
        $where['is_del']=0;
        if($_SESSION['admin']['store_id']>0){

            $where['store_id'] = $_SESSION['admin']['store_id']?$_SESSION['admin']['store_id']:0;
        }else{
            $store_id = input('request.store_id',-1);
            if($store_id!=-1){
                $where['store_id']=$store_id;
            }
        }
        //关键字搜索
        $key = input('get.key');
        if ($key){
            $where['name']=['like',"%$key%"];
        }
        $cat_id = input('get.cat_id');
        if ($cat_id){
            $where['cid']=$cat_id;
        }
        $order['create_time']='desc';
        $list = $model->with('store')->where($where)->order($order)->select();
        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    /**
     * 所有分类
     */
    public function allcategory(){
        $model = new Pinclassify();
        $model->field("id,name as text");
        $list = $model->where('state',1)->select();
        return $list;
    }
    /**
     * 编辑
    */
    public function edit(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id = input('get.id');

        //        获取规格设置
        $attrsetting_model = new Pingoodsattrsetting();
        $attrsetting_list = $attrsetting_model->where('goods_id',$id)->select();

//        获取规格分组信息
        $attrgroup_model = new Pingoodsattrgroup();
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
//        $model=new Pingoods();
        $info =Pingoods::get(['id'=>$id]);
        $info['pics'] = json_decode($info['pics']);
        $info['videosrc']=tomedia( $info['video']);
        $info['img_details'] = json_decode($info['img_details']);
        if($info['start_time']){
            $info['start_time']=date('Y-m-d H:i:s',$info['start_time']);
        }
        if($info['end_time']){
            $info['end_time']=date('Y-m-d H:i:s',$info['end_time']);
        }
        $this->view->info = $info;
        return view('edit');
    }
    /**
     * 删除
     */
    public function deletegoods(){
        $ids = input("post.ids");
        $ret = $this->model->where('id','in',$ids)->update(['is_del'=>1]);
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
    /**
     * 保存规格名称
    */
    public function savegroupname(){
        $info=new Pingoodsattrgroup();
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
    public function deletegoodsattrgroup(){
        $info=new Pingoodsattrgroup();
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
        $info=new Pingoodsattr();
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
    public function deletegoodsattr(){
        $info=new Pingoodsattr();
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
    /**
     * 数据保存（新增、编辑）
    */
    public function saves(){
        global $_W;
        $info = $this->model;
        $id = input('post.id');
        if ($id) {
            $info = $info->get($id);
        }

        $data = input('post.');
//        var_dump($data);exit;
//        补充商户id信息
        if (!$data['store_id']){
            $data['store_id'] = $_SESSION['admin']['store_id'];
        }
        $data['check_state']=2;
//        var_dump($data);exit;

        if($data['store_id']>0&&$_SESSION['admin']['store_id']>0){
            $conf_add=\app\model\Config::get_value('pin_add_check');
            $conf_update=\app\model\Config::get_value('pin_update_check');
            if(($conf_add['pin_add_check']==1)&&(!$id)){
                $data['check_state']=1;
            }elseif (($conf_update['pin_update_check']==1)&&($id)){
                $data['check_state']=1;
            }else{
                $data['check_state']=2;
            }
        }
        $data['start_time']=strtotime(input('post.start_time'));
        $data['end_time']=strtotime(input('post.end_time'));
        $data['pics'] = json_encode($data['pics']);
        $data['img_details'] = json_encode($data['img_details']);
        $data['videosrc']=tomedia( $data['video']);
        $ret = $info->allowField(true)->save($data);
        if($ret){

            if(input('post.use_attr')==1){
//            修改分组信息的 goods_id
                $attrs_data = $data['attrs_data'];
                $attrs_data = json_decode($attrs_data);
                $attrgroup_model = new Pingoodsattrgroup();
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

                $attrsetting_model = new Pingoodsattrsetting();
                $attrsetting_model->where('goods_id',$info->id)->delete();

                $num = 0;
                foreach ($attrsettings as $attrsetting) {
                    $attrsetting = (array)$attrsetting;
                    $num += $attrsetting['stock'];
                    $attrsetting_model = new Pingoodsattrsetting();
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
            if(input('is_ladder')==1){
                $ladder=json_decode(input('post.ladder_info'),true);
                $ladder_list=array();
                foreach ($ladder as $lkey=>$lval){
                    $ldata = [];
                    $ldata['groupnum'] = $lval['groupnum'];
                    $ldata['groupmoney'] = $lval['groupmoney'];
                    $ldata['goods_id'] = $info->id;
                    $ldata['uniacid']=$_W['uniacid'];
                    $ldata['create_time']=time();
                    $ladder_list[] = $ldata;
                }
                Db::name('pinladder')->where('goods_id',$info->id)->delete();
               Db::name('pinladder')->insertAll($ladder_list);
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
    /**
     * 商品选择页
    */
    public function goodsselect(){
        global $_W;
        $this->view->_W = $_W;
        return view('goodsselect');
    }
    public function select_goods_list(){
        global $_W;
        $model =new \app\model\Goods();
        //排序、分页
        $model->fill_order_limit();
        $where['uniacid']=$_W['uniacid'];
        $key=input('get.key');
        if($key){
            $where['name']=['like',"%$key%"];
        }
//        $where['check_state']=2;
        $where['state']=1;
        $store_id=$_SESSION['admin']['store_id']?$_SESSION['admin']['store_id']:0;
//        var_dump($store_id);exit;
        $where['store_id']=$store_id;
//        var_dump($where);exit;
        $list = $model->where($where)->select();
//        var_dump($list);exit;
        foreach ($list as $key =>$value){
            $list[$key]['pic']=$_W['attachurl'].$value['pic'];
        }
        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }

    /**
     * 拼团设置
    */
    public  function pinset(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $info = [];

        $info['pin_add_check'] = \app\model\Config::get_value('pin_add_check',0);
        $info['pin_update_check'] = \app\model\Config::get_value('pin_update_check',0);
        $info['pin_rules'] = \app\model\Config::get_value('pin_rules',0);
        $info['pin_open'] = \app\model\Config::get_value('pin_open',0);

        $this->view->info = $info;
        return view();
    }
    public function saveset(){
        $info = new \app\model\Config();

        $data = input('post.');

        $list = [];

        $list[] = \app\model\Config::full_id('pin_add_check',$data['pin_add_check']);
        $list[] = \app\model\Config::full_id('pin_update_check',$data['pin_update_check']);
        $list[] = \app\model\Config::full_id('pin_rules',$data['pin_rules']);
        $list[] = \app\model\Config::full_id('pin_open',$data['pin_open']);

        $ret = $info->allowField(true)->saveAll($list);

        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'保存失败',
            );
        }
    }
    /**
     * 所有商品
     */
    public function allgoods(){
        global $_W;
        $model = new Pingoods();
        $model->field("id,name as text");
        $where['uniacid']=$_W['uniacid'];
        $where['is_del']=0;
        $where['check_state']=2;
        $store_id= $_SESSION['admin']['store_id']?$_SESSION['admin']['store_id']:0;
        if($store_id>0){

            $where['store_id'] =$store;
        }
        $list = $model->where($where)->select();
        return $list;
    }
    /**
     * 所有用户
     */
    public function allUser(){
        global $_W;
        $model = new User();
        $model->field("id,name as text");
        $list = $model->select();
        return $list;
    }
    /**
     * 所有用户
     */
    public function allLeader(){
        global $_W;
        $model = new Leader();
        $model->field("id,name as text");
        $list = $model->select();
        return $list;
    }
    /**
     * 订单列表
     */
    public function orderlist(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view('orderlist');
    }
    public function get_order_list(){
        global $_W;
        $model =new Pinorder();
        //排序、分页
        $model->fill_order_limit();
        $where['uniacid']=$_W['uniacid'];
        $where['is_del']=[['>=',0],['<=',1]];
        if($_SESSION['admin']['store_id']>0){
            $where['store_id'] = $_SESSION['admin']['store_id'];
        }else{
            $store_id = input("request.store_id",-1);
            if($store_id!=-1){
                $where['store_id'] = $store_id;
            }
        }
//        $where['goods_id']=input('get.id');
        //关键字搜索
        $key = input('get.key');
        if ($key){
            $where['order_num']=['like',"%$key%"];
        }
        $goods_id = input('get.goods_id');
        if ($goods_id){
            $where['goods_id']=$goods_id;
        }
        $type=input('get.type');
        if($type>0){
            $where['order_status']=$type-0-1;
            // switch($where['order_status']){
            //     case 0:
            //         $where['is_del']=[['>=',0],['<=',1]];
            //         break;
            //     case 6:
            //         $where['is_del']=[['>=',0],['<=1']];
            //         break;
            //     case 7:
            //         $where['is_del']=[['>=',0],['<=',1]];
            //         break;
            // }
        }


        $user_id=input('get.user_id',0);
        if($user_id>0){
            $where['user_id']=$user_id;
        }

        $leader_id=input('get.leader_id',0);
        if($leader_id>0){
            $where['leader_id']=$leader_id;
        }
        $query = function($query){ 
            $begin_time=input('get.begin_time',0);
            if($begin_time>0){
                $query->where('create_time','>',strtotime($begin_time));
                // echo $begin_time;
            }

            $data = input('get.data');
            if($data){
                $query->where('id','in',$data);
            }

            $end_time=input('get.end_time',0);
            if($end_time>0){
                $query->where('create_time','<',strtotime($end_time));
                // echo $end_time;
            }
        };




        $order['id']='desc';
//        var_dump($where);exit;
        $list = $model->with(['userOrder','store'])->where($where)->where($query)->order($order)->select();
        // $list2= $model->where($where)->order($order)->where($query)->select();
        // echo $model->getLastSql();exit;
        foreach ($list as $key =>$value){
//            $list[$key]['dh_time']=date('Y-m-d H:i:s',$value['dh_time']);
            $list[$key]['send_time']==0?'':$list[$key]['send_time']=date('Y-m-d H:i:s',$value['send_time']);
            $list[$key]['pay_time']==null?'':$list[$key]['pay_time'] = date('Y-m-d H:i:s',$value['pay_time']);
            $goods=new Pingoods();
            $list[$key]['gname']=$goods->mfind(['id'=>$value['goods_id']],'name')['name'];
            $leader =new Leader();
            $list[$key]['leader_name']=$leader->mfind(['id'=>$value['leader_id']],'name')['name'];
        }
        return [
            'code'=>0,
            'count'=>$model->where($where)->where($query)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    /**
     * 查看订单详情
     */
    public function see(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $model =new Pinorder();
        $id=input('get.id');
        if($id){
            $info =Pinorder::get($id);
            $info['username'] = \app\model\User::get(['id'=>$info['user_id']])['name'];
            $info['gname'] = Pingoods::get(['id'=>$info['goods_id']])['name'];
//            $info['dh_time'] = date('Y-m-d H:i:s',$info['dh_time']);
            $info['pay_status'] =$info['is_pay']?'已支付':'未支付';
            $info['pay_time'] = $info['pay_time']?date('Y-m-d H:i:s',$info['pay_time']):'';
            $info['send_time'] = $info['send_time']?date('Y-m-d H:i:s',$info['send_time']):'';
            $info['use_time'] = $info['use_time']?date('Y-m-d H:i:s',$info['use_time']):'';
            $info['refund_time'] = $info['refund_time']?date('Y-m-d H:i:s',$info['refund_time']):'';
            $info['group_time'] = $info['group_time']?date('Y-m-d H:i:s',$info['group_time']):'';
            $info['address']=$info['province'].$info['city'].$info['area'].$info['address'];
            //$info['mdaddress']=Shop::get(['id'=>$info['shop_id']])['name'];
            $this->view->info=$info;

        }
        return view('see');
    }
    /**
     * 发货
     */
    public function send(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $model =new Pinorder();
        $id=input('get.id');
        if($id){
            $info =Pinorder::get($id);
            $info['username'] = \app\model\User::get(['id'=>$info['user_id']])['name'];
            $info['gname'] = Pingoods::get(['id'=>$info['goods_id']])['name'];
//            $info['create_time'] = date('Y-m-d H:i:s',$info['dh_time']);
            $info['pay_status'] =$info['is_pay']?'已支付':'未支付';
            $info['pay_time'] = $info['pay_time']?date('Y-m-d H:i:s',$info['pay_time']):'';
            $info['send_time'] = $info['send_time']?date('Y-m-d H:i:s',$info['send_time']):'';
            $info['group_time'] = $info['group_time']?date('Y-m-d H:i:s',$info['group_time']):'';

            $this->view->info=$info;

        }
        return view('send');
    }
    public function savesend(){
        $oid=input('post.id');
        if($oid){
            $order=new Pinorder();
            $orderinfo=$order->mfind(['id'=>$oid,'is_del'=>0]);
            if($orderinfo['order_status']==2){
                if($orderinfo['sincetype']==1){
                    $data['express_delivery']=input('post.express_delivery');
                    $data['express_orderformid']=input('post.express_orderformid');
                    $data['order_status']=3;
                }else{
                    $data['order_status']=3;
                    $data['use_time']=time();
                }
                $data['send_time']=time();
                $order = Pinorder::get($oid);
                $res=$order->allowField(true)->save($data);
                if($res){
                    if($orderinfo['sincetype']==2){
                        if($orderinfo['store_id']>0){
                            $order=new \app\model\Order();
                            //$order->confirmAddStoreMoney($orderinfo['store_id'],$orderinfo['order_amount'],2,$orderinfo['user_id'],$oid,$orderinfo['order_num'],$orderinfo['num']);
                        }
                    }
                    return array(
                        'code'=>0,
                    );
                }else{
                    return array(
                        'code'=>1,
                        'msg'=>'失败',
                    );
                }
            }else{
                return array(
                    'code'=>1,
                    'msg'=>'当前订单无法发货/取货',
                );
            }

        }
    }
    public function batchsend(){
        $oid=input('post.ids');
        $flag = false;
        if($oid){
            $order=new Pinorder();
            $orderinfos=$order->mlist(['id'=>['in',$oid],'is_del'=>0]);
            foreach($orderinfos as $orderinfo){
                if($orderinfo['order_status']==2){
                    if($orderinfo['sincetype']==1){
//                        $data['express_delivery']=input('post.express_delivery');
//                        $data['express_orderformid']=input('post.express_orderformid');
                        $data['order_status']=3;
                    }else{
                        $data['order_status']=3;
                        $data['use_time']=time();
                    }
                    $data['send_time']=time();
                    $order = $order->get($orderinfo['id']);
                    $res=$order->save($data);
                    file_put_contents('sql',$order->getLastSql().PHP_EOL,FILE_APPEND);
                    if($res){
                        $flag = true;
                        if($orderinfo['sincetype']==2){
                            if($orderinfo['store_id']>0){
                                $order=new \app\model\Order();
                                //$order->confirmAddStoreMoney($orderinfo['store_id'],$orderinfo['order_amount'],2,$orderinfo['user_id'],$oid,$orderinfo['order_num'],$orderinfo['num']);
                            }
                        }
                    }
                }
            }
            if($flag){
                return array(
                    "code"=>0
                );
            }
        }else{
            return array(
                "code"=>1,
                "msg"=>"未点选订单"
            );
        }
    }
    /**
     * 选择商品复制
    */
    public function copygoods(){
        $id=input('post.id',0);
        $info=\app\model\Goods::get($id);
        $data['name']=$info['name'];
        $data['pin_price']=$info['price'];
        $data['price']=$info['original_price'];
        $data['original_price']=$info['original_price'];
        $data['stock']=$info['stock'];
        $data['unit']=$info['unit'];
//        $data['weight']=$info['weight'];
        $data['details']=$info['details'];
        $data['pic']=$info['pic'];
        $data['pics']=$info['pics'];
        $data['delivery_fee']=$info['delivery_fee'];
        $data['end_time'] = strtotime($info['end_time']);
        $data['start_time'] = strtotime($info['begin_time']);
        $data['home_pic'] = $info['home_pic'];
//        $data['postagerules_id']=$info['postagerules_id'];
        $data['check_state']=1;
        $goods = new Pingoods();
        $res=$goods->allowField(true)->save($data);
//        var_dump($goods->id);exit;
        if($res){
            return array(
                'code'=>0,
                'data'=>$goods->id,
                'info'=>$info
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'失败',
            );
        }
    }
    /**
     * 商品审核
    */
    public function checks(){
        global $_W;
        $this->view->_W=$_W;
        return view('checks');
    }
    public function get_checkgoods_list(){
        global $_W;
        $model =new Pingoods();
        //排序、分页
        $model->fill_order_limit();
        $where['uniacid']=$_W['uniacid'];
        $where['is_del']=0;
        $where['store_id']=['<>',0];
        $store_id=$_SESSION['admin']['store_id'];
        if($store_id>0){
            $where['store_id']=$store_id;
        }
        //关键字搜索
        $key = input('get.key');
        if ($key){
            $where['name']=['like',"%$key%"];
        }
        $cat_id = input('get.cat_id');
        if ($cat_id){
            $where['cid']=$cat_id;
        }
        $order['create_time']='desc';
        $list = $model->where($where)->order($order)->select();
        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function checksee(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        $id=input('get.id');
        if($id){
            $info =Pingoods::get($id);
            $info['pics'] = json_decode($info['pics']);
            $info['videosrc']=tomedia( $info['video']);
            $info['img_details'] = json_decode($info['img_details']);
            if($info['start_time']){
                $info['start_time']=date('Y-m-d H:i:s',$info['start_time']);
            }
            if($info['end_time']){
                $info['end_time']=date('Y-m-d H:i:s',$info['end_time']);
            }

            $this->view->info=$info;
        }
        return view('checksee');
    }
    //强制上架
    //    启用
    public function mandatory(){
        $ids = input("post.ids");
        $state = input("post.value");
        $ret = $this->model->where('id','in',$ids)->update(['mandatory'=>$state]);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>"失败",
            );
        }
    }

    public function batchleaderreceive(){
        $ids = input("post.ids");
        $list = Pinorder::where('id',['in',$ids])
            ->where('order_status',3)
            ->select();
        $ret = 0;
        foreach($list as $pinorder){
            if($pinorder->sincetype==2){
                $pinorder->order_status = 4;
                $ret += $pinorder->save();
            }
        }
        if($ret){
            return [
                'code'=>0
            ];
        }else{
            return [
                'code'=>1,
                'msg'=>'设置团长收货失败'
            ];
        }
    }

    public function batchuserreceive(){
        $ids = input("post.ids");
        $list = Pinorder::where('id',['in',$ids])
            ->where('order_status = 4 or (order_status = 3 and sincetype = 1)')
            ->select();

        $ret = 0;
        foreach ($list as $item) {
            $item->order_status = 5;
            $reti = $item->save();
            if ($reti) $ret ++;
        }

        if ($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                '收货失败',
            );
        }

    }

    public function outCSV(){
        $getModel = function (){
            $key = input('get.key','');

            $storeQuery = function($query){
                if($_SESSION['admin']['store_id']>0){
                    $query->where('t1.store_id',$_SESSION['admin']['store_id']);
                }else{
                    $store_id = input("request.store_id",-1);
                    if($store_id!=-1){
                        $query->where('t1.store_id',$store_id);
                    }
                }
            };

            $model = Pinorder::where($storeQuery)
                ->alias('t1')
//                ->join('order t2','t2.id = t1.order_id')
                ->join('user t3','t3.id = t1.user_id')
                ->join('leader t4','t4.id = t1.leader_id')
                ->join('pingoods t5','t1.goods_id=t5.id')
                ->where('t1.is_del','>=',0)
                ->where('t1.is_del','<=',1)
//                ->where('t5.name|t1.attr_list|t1.order_num|t3.name|t4.name','like',"%$key%");
                ->where('t1.order_num','like',"%$key%");

            $state = input('get.order_status',0);
            if($state){
                $model->where('t1.order_status',$state);
            }



//            $check_state = input('get.check_state',0);
//            if($check_state){
//                $model->where('t1.check_state',$check_state);
//            }
            $type=input('get.type');
            if($type>0){
                $model->where('order_status',$type-0-1);
            }
            $user_id = input('get.user_id',0);
            if($user_id){
                $model->where('t1.user_id',$user_id);
            }

            $leader_id = input('get.leader_id',0);
            if($leader_id){
                $model->where('t1.leader_id',$leader_id);
            }

            $begin_time = input('get.begin_time','');
            if ($begin_time){
                $model->where('t1.create_time >= ' . strtotime($begin_time));
            }

            $end_time = input('get.end_time','');
            if ($end_time){
                $end_time = strtotime($end_time);
                $model->where('t1.create_time <= ' . $end_time);
            }

            $ids = input('get.ids');
            if($ids){
                $model->where('t1.id','in',$ids);
            }

            //排序
            $order = input('request.orderfield');
            if($order){
                $model->order('t1.'.$order,strtolower(input('request.ordertype')) == "desc"?"DESC":"");
            }else{
                $model->order('t1.create_time desc');
            }

            return $model;
        };

        $list = $getModel()
//            ->field('t1.order_num as order_no,t3.name,t5.name as goods_name,t4.name as leader_name,t1.order_amount as order_pay_amount,t1.order_amount,t5.delivery_fee,t5.attr_names,t1.order_status,t1.num,t2.create_time as order_time,t1.order_id')
            ->field('t1.order_num as order_no,t3.id,t3.name,t3.tel,concat(t1.province,t1.city,t1.area) as addr,t5.name as goods_name,t4.name as leader_name,t1.order_amount as order_pay_amount,t1.distribution,t1.attr_list,t1.order_status as state,t1.num,t1.create_time as order_time,t1.id as order_id')
            ->select();
//        echo Payrecord::getLastSql();exit;
        foreach ($list as &$item) {
            $item->order_time = date('Y-m-d H:i:s', $item->order_time);
            $item->order_no = '\''.$item->order_no;
            switch ($item->state){
                case 1:
                    $item->state = '待成团'; 
                    break;
                case 2:
                    $item->state = '待配送';
                    break;
                case 3:
                    $item->state = '配送中';
                    break;
                case 4:
                    $item->state = '待自提';
                    break;
                case 5:
                    $item->state = '已完成';
                    break;
                case 6:
                    $item->state = '已取消';
                    break;
                case 7:
                    $item->state = '退款失败';
                    break;
            }

            $payrecords = Payrecord::where('source_id',$item['order_id'])
                ->where("source_type = 'pinbuy' OR source_type='pinjoinbuy'")
                ->order('callback_time desc,id desc')
                ->select();

            if(count($payrecords)){
                $item['pay_no'] = "'".$payrecords[0]['no'];
            }
            unset($item['order_id']);
        }

        $this->toCSV('用户拼团订单明细表'.date('ymdhis').'.csv',['订单号','用户id','用户','电话','地址','商品名称','团长','订单支付金额','配送费','规格','状态','数量','下单时间','商户支付单号'],json_decode(json_encode($list),true));
    }

    public function batchprint(){
        $order_ids = input("post.order_ids");
        $order_ids = explode(',',$order_ids);
        $new_ids = [];
        foreach ($order_ids as $order_id) {
            if (!in_array($order_id,$new_ids)){
                $new_ids[] = $order_id;
            }
        }
        $order = new Pinorder();
        $order->adminPrint($new_ids);
        return array(
            'code'=>0,
        );
    }
    public function purchase(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view('purchase');
    }

    public function getPurchaseList(){
        $getModel = function (){
            $key = input('get.key','');

            $storeQuery = function($query){
                if($_SESSION['admin']['store_id']>0){
                    $query->where('p.store_id',$_SESSION['admin']['store_id']);
                }else{
                    $store_id = input("request.store_id",-1);
                    if($store_id!=-1){
                        $query->where('p.store_id',$store_id);
                    }
                }
            };
            $model = Pinorder::alias('p')
                ->join('pingoods g', 'p.goods_id = g.id')
                ->join('store','p.store_id = store.id','left')
                ->where($storeQuery)
                ->where('order_status', 2)
                ->where('g.check_state <> 1')
                ->where('p.is_del', 0)
                ->where('g.name|p.attr_list', 'like', "%$key%");

            $begin_time = input('get.begin_time','');
            if ($begin_time){
                $model->where('p.create_time >= ' . strtotime($begin_time));
            }

            $end_time = input('get.end_time','');
            if ($end_time){
                $end_time = strtotime($end_time);
                $model->where('p.create_time <= ' . $end_time);
            }

            return $model;
        };

        $model = $getModel();
        $list = $model->field('g.name as goods_name,p.attr_list as attr_name ,sum(num) as num ,store.name as store_name')
            ->group('g.name,p.attr_list')
            ->order('g.name,p.attr_list')
            ->select();

        return [
            'code'=>0,
            'count'=>0,
            'data'=>$list,
            'msg'=>'',
        ];
    }
    public function delivery(){
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view();
    }
    public function deliveryList(){
        $getModel = function (){
            $key = input('get.key','');

            $storeQuery = function($query){
                if($_SESSION['admin']['store_id']>0){
                    $query->where('t1.store_id',$_SESSION['admin']['store_id']);
                }else{
                    $store_id = input("request.store_id",-1);
                    if($store_id!=-1){
                        $query->where('t1.store_id',$store_id);
                    }
                }
            };

            $model = Pinorder::where($storeQuery)
                ->alias('t1')
                ->join('store','store.id = t1.store_id','left')
                ->join('user t3','t3.id = t1.user_id')
                ->join('leader t4','t4.id = t1.leader_id')
                ->join('pingoods t5','t5.id = t1.goods_id')
                ->where('t5.name|t1.attr_list|t3.name|t4.name','like',"%$key%");

            $model->whereIn('t1.order_status',[3]);

            $sincetype = input('get.delivery_type',0);
            if($sincetype){
                $model->where('t1.sincetype',$sincetype);
            }

            $leader_id = input('get.leader_id',0);
            if($leader_id){
                $model->where('t1.leader_id',$leader_id);
            }
            $begin_time = input('get.begin_time','');
            if ($begin_time){
                $model->where('t1.create_time >= ' . strtotime($begin_time));
            }

            $end_time = input('get.end_time','');
            if ($end_time){
                $end_time = strtotime($end_time);
                $model->where('t1.create_time <= ' . $end_time);
            }

            return $model;
        };

        $list = $getModel()
            ->field('t1.sincetype as delivery_type, coalesce(t1.name,t4.name) as name222, coalesce(t4.tel) as tel222, coalesce(concat(t1.province,t1.city,t1.area,t1.address),t4.address) as address222,t5.name as goods_name,t1.attr_list as attr_names,sum(num) as num ,store.name as store_name')
            ->group('delivery_type,name222,tel222,address222,goods_name,attr_names')
            ->order('delivery_type,name222,tel222,address222,goods_name,attr_names')
            ->select();
//        echo Pingoods::getLastSql();exit;
        return [
            'code'=>0,
            'count'=>0,
            'data'=>$list,
            'msg'=>'',
        ];
    }

    //配送导出
    public function outCSV6(){
        $getModel = function (){
            $key = input('get.key','');
            $storeQuery = function($query){
                if($_SESSION['admin']['store_id']>0){
                    $query->where('t1.store_id',$_SESSION['admin']['store_id']);
                }else{
                    $store_id = input("request.store_id",-1);
                    if($store_id!=-1){
                        $query->where('t1.store_id',$store_id);
                    }
                }
            };

            $model = Pinorder::where($storeQuery)
                ->alias('t1')
                ->join('user t3','t3.id = t1.user_id')
                ->join('leader t4','t4.id = t1.leader_id')
                ->join('pingoods t5','t5.id = t1.goods_id')
                ->where('t5.name|t1.attr_list|t1.order_num|t3.name|t4.name','like',"%$key%");

            $model->whereIn('t1.order_status',[3]);

            $delivery_type = input('get.delivery_type',0);
            if($delivery_type){
                $model->where('t1.sincetype',$delivery_type);
            }
            $store_id = input('get.store_id',-1);
            if($store_id!=-1){
                $model->where('t1.store_id',$store_id);
            }
            $leader_id = input('get.leader_id',0);
            if($leader_id){
                $model->where('t1.leader_id',$leader_id);
            }

            $begin_time = input('get.begin_time','');
            if ($begin_time){
                $model->where('t1.create_time >= ' . strtotime($begin_time));
            }

            $end_time = input('get.end_time','');
            if ($end_time){
                $end_time = strtotime($end_time);
                $model->where('t1.create_time <= ' . $end_time);
            }

            return $model;
        };

        $list = $getModel()
            ->field('t1.sincetype as delivery_type, coalesce(t1.name,t4.name) as name222, coalesce(t4.tel) as tel222, coalesce(concat(t1.province,t1.city,t1.area,t1.address),t4.address) as address222,t5.name as goods_name,t1.attr_list as attr_names,sum(num) as num ')
            ->group('delivery_type,name222,tel222,address222,goods_name,attr_names')
            ->order('delivery_type,name222,tel222,address222,goods_name,attr_names')
            ->select();

        foreach ($list as &$item) {
            $item->tel222 = "'".$item['tel222'];
            if ($item->delivery_type == 2){
                $item->delivery_type = '用户自提';
            }else{
                $item->delivery_type = '商家配送';
            }
        }

        $this->toCSV('拼团配送统计表'.date('ymdhis').'.csv',['配送方式','收货人','联系电话','地址','商品名称','规格','数量'],json_decode(json_encode($list),true));
    }
    //采购导出
    public function outCSV5(){
        $getModel = function (){
            $key = input('get.key','');

            $storeQuery = function($query){
                if($_SESSION['admin']['store_id']>0){
                    $query->where('t1.store_id',$_SESSION['admin']['store_id']);
                }else{
                    $store_id = input("request.store_id",-1);
                    if($store_id!=-1){
                        $query->where('t1.store_id',$store_id);
                    }
                }
            };

            $model = Pinorder::where($storeQuery)
                ->alias('t1')
                ->join('pingoods t2','t2.id = t1.goods_id')
                ->where('order_status',2)
                ->where('check_state <> 1')
                ->where('t2.name|t1.attr_list','like',"%$key%");

            $begin_time = input('get.begin_time','');
            if ($begin_time){
                $model->where('t1.create_time >= ' . strtotime($begin_time));
            }

            $end_time = input('get.end_time','');
            if ($end_time){
                $end_time = strtotime($end_time);
                $model->where('t1.create_time <= ' . $end_time);
            }

            return $model;
        };

        $list = $getModel()
            ->field('t2.name as goods_name,t1.attr_list as attr_names,sum(num) as num')
            ->group('goods_name,attr_names')
            ->order('goods_name,attr_names')
            ->select();

        $this->toCSV('拼团采购统计表'.date('ymdhis').'.csv',['商品名称','规格','数量'],json_decode(json_encode($list),true));
    }

    //    团长明细
    public function leaderorder()
    {
        global $_W,$_GPC;
        $this->view->_W = $_W;
        $this->view->_GPC = $_GPC;
        return view();
    }
    public function getLeaderOrder(){
        $getModel = function (){
            $key = input('get.key','');

            $storeQuery = function($query){
                if($_SESSION['admin']['store_id']>0){
                    $query->where('t1.store_id',$_SESSION['admin']['store_id']);
                }else{
                    $store_id = input("request.store_id",-1);
                    if($store_id!=-1){
                        $query->where('t1.store_id',$store_id);
                    }
                }
            };

            $model = Pinorder::where($storeQuery)
                ->alias('t1')
                ->join('store','store.id = t1.store_id','left')
                ->join('leader t2','t2.id = t1.leader_id','left')
                ->join('pingoods p','p.id = t1.goods_id','left')
                ->where('t2.name','like',"%$key%")
                ->where('t1.is_del',0);

            $model->whereNotIn('order_status',[0,1]);
            $state = input('get.state');
            if($state){
                $model->where('order_status',$state);
            }

            $leader_id = input('get.leader_id',0);
            if($leader_id){
                $model->where('t1.leader_id',$leader_id);
            }

            $begin_time = input('get.begin_time','');
            if ($begin_time){
                $model->where('t1.create_time >= ' . strtotime($begin_time));
            }

            $end_time = input('get.end_time','');
            if ($end_time){
                $end_time = strtotime($end_time);
                $model->where('t1.create_time <= ' . $end_time);
            }

            return $model;
        };

        $model = $getModel();

        //分页
        $page = input('request.page',1);
        $limit = input('request.limit',10);
        if($page){
            $model->limit($limit)->page($page);
        }
        //排序
        $order = input('request.orderfield');
        if($order){
            $model->order('t1.'.$order,strtolower(input('request.ordertype')) == "desc"?"DESC":"");
        }else{
            $model->order('t1.create_time desc');
        }

        $list = $model
            ->group('leader_name,t1.goods_id,goods_name,t1.attr_ids,attr_names,order_status')
            ->field('t1.id,t2.name as leader_name,t1.goods_id,p.name as goods_name,t1.attr_ids,t1.attr_list as attr_names,t1.order_status as state,sum(t1.num)as num,store.name as store_name')
            ->select();

        $count = $getModel()
//            ->group('leader_name,t1.goods_id,t1.goods_name,t1.attr_ids,t1.attr_names,t1.state')
//            ->field('t2.name as leader_name,t1.goods_id,t1.goods_name,t1.attr_ids,t1.attr_names,t1.state,sum(t1.num)as num')
            ->group('leader_name,t1.goods_id,goods_name,t1.attr_ids,attr_names,order_status')
            ->field('t2.name as leader_name,t1.goods_id,p.name as goods_name,t1.attr_ids,t1.attr_list as attr_names,t1.order_status as state,sum(t1.num)as num')
            ->count();

        return [
            'code'=>0,
            'count'=>$count,
            'data'=>$list,
            'msg'=>'',
        ];
    }

    //团长明细导出
    public function outCSV2(){
        $getModel = function (){
            $key = input('get.key','');

            $storeQuery = function($query){
                if($_SESSION['admin']['store_id']>0){
                    $query->where('t1.store_id',$_SESSION['admin']['store_id']);
                }else{
                    $store_id = input("request.store_id",-1);
                    if($store_id!=-1){
                        $query->where('t1.store_id',$store_id);
                    }
                }
            };

            $model = Pinorder::where($storeQuery)
                ->alias('t1')
                ->join('leader t2','t2.id = t1.leader_id')
                ->join('pingoods p','p.id = t1.goods_id')
                ->join('store s','s.id = t1.store_id','left')
                ->where('t2.name','like',"%$key%")
                ->where('t1.is_del',0);

            $model->whereNotIn('order_status',[0,1]);
            $state = input('get.state');
            if($state){
                $model->where('order_status',$state);
            }

            $leader_id = input('get.leader_id',0);
            if($leader_id){
                $model->where('t1.leader_id',$leader_id);
            }

            $begin_time = input('get.begin_time','');
            if ($begin_time){
                $model->where('t1.create_time >= ' . strtotime($begin_time));
            }
            $store_id= input('get.store_id',-1);
            if($store_id!=-1){
                $model->where('t1.store_id',$store_id);
            }

            $end_time = input('get.end_time','');
            if ($end_time){
                $end_time = strtotime($end_time);
                $model->where('t1.create_time <= ' . $end_time);
            }
            $data = input('get.data','');
            if ($data){
                $model->where('t1.id','in',$data);
            }

            return $model;
        };

        $model = $getModel();

        //分页
        // $page = input('request.page',1);
        // $limit = input('request.limit',10);
        // if($page){
        //     $model->limit($limit)->page($page);
        // } 
        //排序
        $order = input('request.orderfield');
        if($order){
            $model->order('t1.'.$order,strtolower(input('request.ordertype')) == "desc"?"DESC":"");
        }else{
            $model->order('t1.create_time desc');
        }

        $list = $model
            ->group('leader_name,t1.goods_id,goods_name,t1.attr_ids,attr_names,order_status')
            // ->field('t2.name as leader_name,t1.goods_id,p.name as goods_name,t1.attr_ids,t1.attr_list as attr_names,t1.order_status as state,sum(t1.num)as num')
            ->field('p.name as goods_name,t1.attr_list as attr_names,t1.order_status as state,sum(t1.num) as num,t2.name as leader_name,t2.tel as tel,t2.address,s.name as store_name')
            ->select();

        foreach ($list as &$item) {
            switch ($item->state){
                case 1:
                    $item->state = '=待成团';
                    break;
                case 2:
                    $item->state = '待配送';
                    break;
                case 3:
                    $item->state = '配送中';
                    break;
                case 4:
                    $item->state = '待自提';
                    break;
                case 5:
                    $item->state = '已完成';
                    break;
                case 6:
                    $item->state = '已取消';
                    break;
                case 7:
                    $item->state = '已退款';
                    break;
            }

            unset($item->leader_id);
            unset($item->goods_id);
            unset($item->attr_ids);
        }

        $this->toCSV('团长订单明细表'.date('ymdhis').'.csv',['商品名称','规格','状态','数量','团长','电话','地址','商家名称'],json_decode(json_encode($list),true));
    }

    //手动退款
    public function refund(){
        $ids = input('post.ids');
        $refund=new Pinrefund();
        $refund->refund($ids);
        $pinorder = Pinorder::get($ids);
        if($pinorder->order_status == 7){
            return [
                "code"=>1,
                "msg"=>"审核失败"
            ];
        }else{
            return [
                "code"=>0
            ];
        }
        
    }

    //手动实现为成团订单退款
    public function batchRefund(Pinorder $pinorder) {
        //未成团订单退款
        $taskList=[];
        $count=0;
        $success=0;
        $memo=[];
        $pinorderList = $pinorder->with('pinheads')->where(['order_status'=>1,'is_head'=>1,'is_del'=>0])->select();
        foreach($pinorderList as $item){
            if($item->header_status==3){
                $paylist=$pinorder->where(['heads_id'=>$item['heads_id'],'is_del'=>0,'is_pay'=>1])->select();
                foreach ($paylist as $key =>$value){
                    $value->is_del=1;
                    $value->save();
                    $refund=new Pinrefund();
                    $refund->refund($value->id);
                }
            }
            if($item->order_expire_time<time()){
                $item->order_expire_time = date("Y-m-d H:i:s",$item->order_expire_time);
                try{
                    $ret=$pinorder->openOverdue($item->id);
                }catch (\Exception $e){
                    $memo[] = [
                        'msg'=>$e->getMessage(),
                        'trace'=>$e->getTrace(),
                    ];
                    $ret = false;
                }
                $debug = $item;
                $count++;
                if($ret){
                    $success++;
                }
                $debug = Pinheads::get($item->heads_id);
            }
        }
       return [
           'code'=>0,
           'num'=>$success
       ];
    }

}
