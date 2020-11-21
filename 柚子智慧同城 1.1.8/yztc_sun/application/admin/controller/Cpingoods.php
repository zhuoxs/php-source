<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29
 * Time: 14:53
 */
namespace app\admin\controller;

use app\model\Commonorder;
use app\model\Pingoods;
use app\model\Pingoodsattr;
use app\model\Pingoodsattrgroup;
use app\model\Pingoodsattrsetting;
use app\model\Pinladder;
use app\model\Pinorder;
use app\model\Pinrefund;
use app\model\Shop;
use app\model\Store;
use app\model\Distributionset;
use think\Db;

class Cpingoods extends Base
{
    public function get_goods_list(){
        global $_W;
        $model =new Pingoods();
        //排序、分页
        $model->fill_order_limit();
        $where['uniacid']=$_W['uniacid'];
        $where['is_del']=0;
        if ($_SESSION['admin']['store_id'] > 0) {
            $where['store_id']=$_SESSION['admin']['store_id'];
        }
        //关键字搜索
        $key = input('get.key');
        if ($key){
            $where['name']=['like',"%$key%"];
        }
        $cat_id = input('get.cat_id');
        if ($cat_id){
            $where['cat_id']=$cat_id;
        }
        $store_id = input('get.store_id');
        if ($store_id){
            $where['store_id']=$store_id;
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
        if (!$data['store_id']){
            $data['store_id'] = $_SESSION['admin']['store_id'];
        }
        $data['check_status']=2;
        if(!$id){
            $info->check_version();
        }
        if($data['store_id']>0){
            $conf_add=\app\model\Config::get_value('pin_add_check');
            $conf_update=\app\model\Config::get_value('pin_update_check');
            if(($conf_add['pin_add_check']==1)&&(!$id)){
                $data['check_status']=1;
            }elseif (($conf_update['pin_update_check']==1)&&($id)){
                $data['check_status']=1;
            }else{
                $data['check_status']=2;
            }
        }
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
                $act['sale_price']=$data['pin_price'];
                $act['vip_price']=$data['vip_price'];
                $act['pic']=$data['pic'];
                $act['check_status']=$data['check_status'];
                $act['state']=$data['state'];
                \app\model\Activity::update($act,['type'=>4,'goods_id'=>$id]);
            }

        }

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
            if(!$id&&(input('is_ladder')==1)){
                $ladder=json_decode(input('post.ladder_info'),true);
                $ladder_list=array();
                foreach ($ladder as $lkey=>$lval){
                    $ldata = [];
                    $ldata['groupnum'] = $lval['groupnum'];
                    $ldata['groupmoney'] = $lval['groupmoney'];
                    $ldata['vip_groupmoney'] = $lval['vip_groupmoney'];
                    $ldata['goods_id'] = $info->id;
                    $ldata['uniacid']=$_W['uniacid'];
                    $ldata['create_time']=time();
                    $ladder_list[] = $ldata;
                }
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
//        $where['check_status']=2;
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

        $this->view->info = $info;
        return view();
    }
    public function saveset(){
        $info = new \app\model\Config();

        $data = input('post.');

        $list = [];

//        $list[] = \app\model\Config::full_id('pin_add_check',$data['pin_add_check']);
//        $list[] = \app\model\Config::full_id('pin_update_check',$data['pin_update_check']);
        $list[] = \app\model\Config::full_id('pin_rules',$data['pin_rules']);

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
        $where['check_status']=2;
        if($_SESSION['admin']['store_id']>0){
          $where['store_id']=$_SESSION['admin']['store_id'];
        }
        $list = $model->where($where)->select();
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
//        $where['is_del']=0;
//        $where['goods_id']=input('get.id');
        if ($_SESSION['admin']['store_id'] > 0) {
            $where['store_id']=$_SESSION['admin']['store_id'];
        }
        //关键字搜索
        $key = input('get.key');
        if ($key){
            $where['order_no']=['like',"%$key%"];
        }
        $goods_id = input('get.goods_id');
        if ($goods_id){
            $where['goods_id']=$goods_id;
        }
        $type=input('get.type');
        switch ($type){
            case 1 :
                $where['order_status']=10;
                $where['after_sale']=0;
                break;
            case 2 :
                $where['order_status']=20;
                $where['after_sale']=0;
                break;
            case 4 :
                $where['order_status']=25;
                $where['after_sale']=0;
                break;
            case 5 :
                $where['order_status']=40;
                $where['after_sale']=0;
                break ;
            case 6:
                $where['order_status']=60;
                break;
            case 7 :
                $where['after_sale']=['gt',0];
                break;
        }
        $order['id']='desc';
//        var_dump($where);exit;
        $list = $model->where($where)->order($order)->select();
        foreach ($list as $key =>$value){
//            $list[$key]['dh_time']=date('Y-m-d H:i:s',$value['dh_time']);
            $goods=new Pingoods();
            $list[$key]['gname']=$goods->mfind(['id'=>$value['goods_id']],'name')['name'];
            $list[$key]['storename']=Store::get($value['store_id'])['name'];
            if ($value['attr_list']){
                $list[$key]['attr_list'] = substr($value['attr_list'],1,-1);
            }
            $list[$key]['is_del']=$value['is_del']==0?'':'已删除';

        }
        return [
            'code'=>0,
            'count'=>$model->where($where)->count(),
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
            $info['username'] =\app\model\User::get(['id'=>$info['user_id']])['nickname'];
            $info['gname'] = Pingoods::get(['id'=>$info['goods_id']])['name'];
            $info['attr_list'] = substr($info['attr_list'],1,-1);
            $info['pay_status'] =$info['is_pay']?'已支付':'未支付';
            $info['pay_time'] = $info['pay_time']?date('Y-m-d H:i:s',$info['pay_time']):'';
            $info['write_off_time'] = $info['write_off_time']?date('Y-m-d H:i:s',$info['write_off_time']):'';
            $info['refund_time'] = $info['refund_time']?date('Y-m-d H:i:s',$info['refund_time']):'';
            $info['group_time'] = $info['group_time']?date('Y-m-d H:i:s',$info['group_time']):'';
            $info['address']=$info['province'].$info['city'].$info['area'].$info['address'];
            $info['mdaddress']=Store::get(['id'=>$info['store_id']])['name'];
            $this->view->info=$info;

        }
        return view('see');
    }
    //TODO:：添加活动列表
    public function btnBatchAddActivity(){
        $ids=input('post.ids');
        $info=new Pingoods();
        $ret =$info->where('id','in',$ids)->update(['is_activity'=>1]);
        $idslist=explode(',',$ids);
        foreach ($idslist as $value){
            $model=new \app\model\Activity();
            $panicinfo=Pingoods::get($value);
            $data['type']=4;
            $data['name']=$panicinfo['name'];
            $data['cat_id']=$panicinfo['cat_id'];
            $data['goods_id']=$value;
            $data['store_id']=$panicinfo['store_id'];
            $data['start_time']=$panicinfo['start_time'];
            $data['end_time']=$panicinfo['end_time'];
            $data['original_price']=$panicinfo['original_price'];
            $data['sale_price']=$panicinfo['pin_price'];
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
            $model->where(['goods_id'=>$value,'type'=>4])->delete();
        }
        $panic=new Pingoods();
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

    //TODO::退款
    public function agreeRefund(){
        $oid=input('post.id');
        $orderinfo=Pinorder::get($oid);
        $refundinfo=Pinrefund::get(['order_id'=>$oid]);
        $ref=new Pinrefund();
        if($refundinfo['refund_status']==1){
            if($orderinfo['pay_type']==2){
                if($refundinfo['refund_price']>0){
                    $ref->refundBalance($orderinfo);
                    return array('code'=>0, 'msg'=>'退款成功',);
                }else{
                    //免费直接退款成功
                    $ref->refundSuccess($oid);
                    return array('code'=>0, 'msg'=>'退款成功',);
                }
            }else{
                if($refundinfo['refund_price']>0){
                    //退款至微信
                    $ref->refundWechat($orderinfo);
                }else{
                    //免费直接退款成功
                    $ref->refundSuccess($oid);
                    return array('code'=>0, 'msg'=>'退款成功',);
                }
            }

        }else{
            return array('code'=>1, 'msg'=>'当前订单无法退款',);
        }
    }
    //TODO::拒绝退款
    public function refuseRefund(){
        $oid=input('post.id');
        $fail_reason=input('post.fail_reason');
//        var_dump($oid,$fail_reason);exit;
        $ord=new Pinorder();
        $ret=$ord->allowField(true)->save(['refund_status'=>4,'refund_time'=>time(),'fail_reason'=>$fail_reason,'after_sale'=>0],['id' => $oid]);
        //修改退款订单
        Pinrefund::update(['refund_status'=>4,'refund_time'=>time(),'fail_reason'=>$fail_reason],['order_id'=>$oid]);
        //修改公共订单 50申请售后 51 已退款 52 退款失败 53 拒绝退款
        $comord=new Commonorder();
        $comord->editCommonOrderStatus(2,$oid,53);
        if($ret){
            return array(
                'code'=>0,
            );
        }else{
            return array(
                'code'=>1,
                'msg'=>'操作失败',
            );
        }
    }
}