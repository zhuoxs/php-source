<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}
class Api_Shop extends WeModuleWxapp
{
    // 获取首页信息
    public function index(){
        global $_GPC, $_W;

        //查询商品
        $params = [
            "uniacid" => $_W['uniacid'],
            "state <>" => 2,
            'del_time'=>0
        ];
        $pageSize = 10;
        $pageCur = $_GPC['page'] ?: 1;
        $list = pdo_getall('ox_reclaim_goods',$params,'','',['state asc','sort desc'],[$pageCur,$pageSize]);
        foreach ($list as &$v){
            $v['img'] = tomedia($v['img']);
        }
        unset($v);

        //查询商城设置
        $shop_info = pdo_get('ox_reclaim_shop_info',['uniacid'=>$_W['uniacid']]);
        $shop_info['pic'] = tomedia($shop_info['pic']);

        //查询商城设置
        $user_info = pdo_get('ox_reclaim_member',['uniacid'=>$_W['uniacid'],'uid'=>$_GPC['uid']]);

        $result = [
           'list' => $list,
            'shop'=>$shop_info,
            'user'=>$user_info,
        ];
        return $this->result(0, '', $result);
    }

    /*
     * 商品详情
     */
    public function details(){
        global $_GPC, $_W;

        $id = $_GPC['id'];
        //查询商品
        $params = [
            "uniacid" => $_W['uniacid'],
            "state <>" => 2,
            "id" => $_GPC['id'],
            'del_time'=>0
        ];
        $goods_info = pdo_get('ox_reclaim_goods',$params);
        if(empty($goods_info)){
            $goods_info = false;
        }
        $goods_info['details'] =  htmlspecialchars_decode( $goods_info['details']);
        $goods_info['details'] = str_replace('style=""','',$goods_info['details']);

        $imgs = pdo_getall('ox_reclaim_image',['uniacid'=>$_W['uniacid'], 'order_id'=>$id,'type'=>2]);
        foreach ($imgs as &$v){
            $v['img'] = tomedia($v['img']);
        }
        $result = [
            'info' => $goods_info,
            'img'=>$imgs
        ];
        return $this->result(0, '', $result);
    }

    /*
     * 下单页
     */
    public function xiadan(){
        global $_GPC, $_W;

        $id = $_GPC['id'];
        $params = [
            "uniacid" => $_W['uniacid'],
            "state <>" => 2,
            "id" => $_GPC['id'],
            'del_time'=>0
        ];
        $goods_info = pdo_get('ox_reclaim_goods',$params);
        $goods_info['img'] = tomedia($goods_info['img']);

        $address = pdo_get('ox_reclaim_address',[   "uniacid" => $_W['uniacid'], "uid"=> $_GPC['uid']],'','',['id desc,default desc']);

        $user_info = pdo_get('ox_reclaim_member',['uniacid'=>$_W['uniacid'],'uid'=>$_GPC['uid']]);

        $result = [
            'info' => $goods_info,
            'address'=>$address,
            'user'=>$user_info
        ];
        return $this->result(0, '', $result);
    }

    /*
     * 兑换
     */
    public function duihuan(){
        global $_GPC, $_W;

        $id = $_GPC['id'];
        $params = [
            "uniacid" => $_W['uniacid'],
            "state <>" => 2,
            "id" => $_GPC['id'],
            'del_time'=>0
        ];
        $goods_info = pdo_get('ox_reclaim_goods',$params);

        $user_info = pdo_get('ox_reclaim_member',['uniacid'=>$_W['uniacid'],'uid'=>$_GPC['uid']]);

        if(empty($goods_info)){
            return $this->result(-1, '商品不存在或已下架', $result);
        }

        if(empty($user_info)){
            return $this->result(-1, '会员信息错误', $result);
        }

        if($user_info['integral']<$goods_info['integral']){
            return $this->result(-1, '积分不足', $result);
        }
        if($user_info['money']<$goods_info['price']){
            return $this->result(-1, '余额不足', $result);
        }

        //验证是否开启限购
        $shop_info = pdo_get('ox_reclaim_shop_info',['uniacid'=>$_W['uniacid']]);
        if($shop_info['open']!=1){
            return $this->result(-1, '积分商城已关闭', $result);
        }
        if($shop_info['xiangou']>0){
            //查询该商品兑换次数
            $good_num = pdo_fetchcolumn("select count(*) from ".tablename('ox_reclaim_shop_order')."  where `uniacid`= {$_W['uniacid']} and uid={$_GPC['uid']} and goods_id={$id} ");
            if($good_num>=$shop_info['xiangou']){
                return $this->result(-1, '同一商品只可兑换'.$shop_info['xiangou']."次", $result);
            }
        }


        pdo()->begin();

        $data = array(
            'uniacid'=>$_W['uniacid'],
            'uid'=>$user_info['uid'],
            'o_sn'=>order_sn(),
            'address'=>$_GPC['address'],
            'name'=>$_GPC['address_name'],
            'phone'=>$_GPC['address_phone'],
            'status'=>1,
            'create_time'=>time(),
            'goods_id'=>$goods_info['id'],
            'integral'=>$goods_info['integral'],
            'price'=>$goods_info['price'],
            'title'=>$goods_info['title'],
            'img'=>$goods_info['img'],
        );
        $res = pdo_insert('ox_reclaim_shop_order',$data);
        if(!$res){
            pdo()->rollback();
            return $this->result(-1, '订单生成失败', $parame);
        }
        $order_id = pdo_insertid();

        $res = pdo_update('ox_reclaim_goods',array('num -=' => 1),$params);
        if(!$res){
            pdo()->rollback();
            return $this->result(-1, '更新库存失败', $parame);
        }

        $ceshi = new Basis();
        $money = (-1)*$goods_info['price'];    //变动可用资金
        $uid = $user_info['uid'];       //用户uid
        $parame = array(
            'from_uid'=>$user_info['uid'],  //来源用户-可不填写
            'type'=>5, //类型 0接单 1完工 2提现 3提现驳回 5兑换商品
            'from_id'=>$order_id,   //来源id 订单id或提现表id(非小程序form_id)
            'from_table'=>'ox_reclaim_shop_order', //来源表名，不带ims_
            'desc'=>'兑换商品',
            'integral'=>(-1)*$goods_info['integral']
        );
        $result = $ceshi->money_change($money,$uid,$parame,1);
        if(!$result['code']){
            pdo()->rollback();
            return $this->result(-1, $result['msg'], $parame);
        }else{
            pdo()->commit();
            return $this->result(0, '', $parame);
        }

    }
    /*
     * 订单列表
     */
    public function orderList(){
        global $_GPC, $_W;
        $params = [
            "uniacid" => $_W['uniacid'],
            "uid"=> $_GPC['uid'],
        ];
        $params['status'] = $_GPC['status'] ?: 1;
        $pageSize = 10;
        $pageCur = $_GPC['page'] ?: 1;
        $list = pdo_getall('ox_reclaim_shop_order',$params,'','',['id desc'],[$pageCur,$pageSize]);

        foreach ($list as $k => $v){
            $list[$k]['create_time'] = date('Y-m-d H:i',$v['create_time']);
            $list[$k]['fahuo_time'] = date('Y-m-d H:i',$v['fahuo_time']);
            $list[$k]['end_time'] = date('Y-m-d H:i',$v['end_time']);
            $list[$k]['img'] = tomedia($v['img']);
        }
        return $this->result(0, '', $list);
    }

    /*
     * 订单完成
     */
    public function cancel(){
        global $_GPC, $_W;

        $id = $_GPC['id'];
        $params = [
            "uniacid" => $_W['uniacid'],
            "status" => 2,
            "id" => $_GPC['id'],
            'uid'=>$_GPC['uid']
        ];
        $data['status'] = 3;
        $data['end_time'] = time();
        $res = pdo_update('ox_reclaim_shop_order',$data,$params);
        if($res){
            return $this->result(0, '成功', $params);
        }else{
            return $this->result(-1, '操作失败', $params);
        }
    }


}