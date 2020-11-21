<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}
class Api_Order extends WeModuleWxapp
{
    // 订单列表
    public function orderList(){
        global $_GPC, $_W;
        $params = [
            "uniacid" => $_W['uniacid'],
            "uid"=> $_GPC['uid'],
            "cycle" => 0
        ];
        $params['status'] = $_GPC['status'] ?: 0;
        $pageSize = 6;
        $pageCur = $_GPC['page'] ?: 1;
        $list = pdo_getall('ox_reclaim_order',$params,'','',['id desc'],[$pageCur,$pageSize]);

        foreach ($list as $k => $v){
            $list[$k]['create_time'] = date('Y-m-d H:i',$v['create_time']);
            if(!empty($v['admin_uid'])){
                $member = pdo_get('ox_reclaim_member',array('uid'=>$v['admin_uid']));
                $list[$k]['admin_name'] = $member['name']==''? $member['nickname'] : $member['name'];
            }else{
                $list[$k]['admin_name'] = '未接单';
            }

        }
        return $this->result(0, '', $list);
    }
    /**
     * 订单详情
     */
    public function orderDetail(){
        global $_GPC, $_W;
        $detail = pdo_get('ox_reclaim_order',[ "uniacid" => $_W['uniacid'],'id'=>$_GPC['order_id'],'uid'=>$_GPC['uid']]);
        $imgs = pdo_getall('ox_reclaim_image',['order_id'=>$_GPC['order_id'],'type'=>1],['id','img']);
        $detail['create_time'] = date('Y-m-d H:i',$detail['create_time']);
        $detail['go_time'] = date('Y-m-d H:i',$detail['go_time']);
        foreach ($imgs as $k => $v){
            $imgs[$k]['img'] = tomedia($v['img']);
        }
        $member = pdo_get('ox_reclaim_member',array('uid'=>$detail['admin_uid']));
        $detail['admin_name'] = $member['name']==''? $member['nickname'] : $member['name'];
        $detail['admin_phone'] = $member['phone'];
        $result = [
            'detail' => $detail,
            'imgs' => $imgs,
            'prevImgs' => array_column($imgs,'img'),
        ];
        return $this->result(0, '', $result);
    }

    /**
     * 取消订单
     */
    public  function cancel(){
        global $_GPC, $_W;
        $base = new Basis();
        $base->add_form_id($_GPC['uid'],$_GPC['formid']);
        $params = [
            "uniacid" => $_W['uniacid'],
            "uid"=> $_GPC['uid'],
            "id" => $_GPC['orderid']
        ];
        pdo_update('ox_reclaim_order',['status' => 2],$params);
        return  $this->orderList();
    }
    /**
     * 删除订单
     */
    public function deleteOrder(){
        global $_GPC, $_W;
        $base = new Basis();
        $base->add_form_id($_GPC['uid'],$_GPC['formid']);

        $params = [
            "uniacid" => $_W['uniacid'],
            "uid"=> $_GPC['uid'],
            "id" => $_GPC['orderid']
        ];
        pdo_delete('ox_reclaim_order',$params);
        return  $this->orderList();
    }

    /**
     * 定期回收列表
     */
    public function cycleOrder(){
        global $_GPC, $_W;
        $pageSize = 4;
        $pageCur = ($_GPC['page'] - 1) * $pageSize;
        $sql = "SELECT * ,((({$_SERVER['REQUEST_TIME']} - last_time)/86400)-cycle) AS days FROM ".tablename('ox_reclaim_order')." WHERE uniacid = {$_W['uniacid']} AND uid = {$_GPC['uid']} AND cycle > 0 ORDER BY days DESC LIMIT {$pageCur},{$pageSize}";
        $list = pdo_fetchall($sql);
        foreach ($list as $k => $v){
            $list[$k]['create_time'] = date('Y-m-d H:i',$v['create_time']);
            $list[$k]['cycle_num'] = $v['days'] > 1000 ? 0 : ceil($v['days']);
        }
        return $this->result(0, '', $list);
    }

    /**
     * 删除订单
     */
    public function deleteCycle(){
        global $_GPC, $_W;
        $base = new Basis();
        $base->add_form_id($_GPC['uid'],$_GPC['formid']);

        $params = [
            "uniacid" => $_W['uniacid'],
            "uid"=> $_GPC['uid'],
            "id" => $_GPC['orderid']
        ];
        pdo_delete('ox_reclaim_order',$params);
        $_GPC['page'] = 1;
        return  $this->cycleOrder();
    }
    /**
     * 定期回收管理
     */
    public function manageCycle(){
        global $_GPC, $_W;
        $pageSize = 4;
        $pageCur = ($_GPC['page'] - 1) * $pageSize;

        $sql = "SELECT * ,((({$_SERVER['REQUEST_TIME']} - last_time)/86400)-cycle) AS days FROM ".tablename('ox_reclaim_order')." WHERE uniacid = {$_W['uniacid']}  AND cycle > 0 AND status!=2 ORDER BY days DESC LIMIT {$pageCur},{$pageSize}";
        $list = pdo_fetchall($sql);
        foreach ($list as $k => $v){
            $list[$k]['create_time'] = date('Y-m-d H:i',$v['create_time']);
            $list[$k]['cycle_num'] =  $v['days'] > 1000 ? 0 : ceil($v['days']);
        }
        return $this->result(0, '', $list);
    }

    /**
     * 定期回收记录
     */
    public function cycleList(){
        global $_GPC, $_W;
        $list = pdo_getall('ox_reclaim_cycle',['order_id' =>$_GPC['order_id'],"uniacid" => $_W['uniacid'] ],'','',['id desc']);
        foreach ($list as $k => $v){
            $list[$k]['create_time'] = date('m-d',$v['create_time']);
        }
        return $this->result(0, '', $list);
    }
}