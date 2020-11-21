<?php
if (!(defined('IN_IA')))
{
    exit('Access Denied');
}

class Api_Address extends WeModuleWxapp
{
    /**
     * 地址列表
     */
    public function addressList(){
        global $_GPC, $_W;
        $params = [
            "uniacid" => $_W['uniacid'],
            "uid"=> $_GPC['uid'],
        ];
        $list = pdo_getall('ox_reclaim_address',$params,'','',['id desc,default desc']);
        return $this->result(0, '', $list);
    }
    /**
     * 地址详情
     */
    public function addressDetail(){
        global $_GPC, $_W;
        $params = [
            "uniacid" => $_W['uniacid'],
            "uid"=> $_GPC['uid'],
            "id"=> $_GPC['id'],
        ];
        $detail = pdo_get('ox_reclaim_address',$params);
        return $this->result(0, '', $detail);
    }

    /**
     * 创建地址
     */
    public function create(){
        global $_GPC, $_W;
        $params = [
            "uid"=> $_GPC['uid'],
            "uniacid"=> $_W['uniacid'],
            "phone"=> $_GPC['phone'],
            "name"=> $_GPC['name'],
            "address"=> $_GPC['address'],
            "address_detail"=> $_GPC['address_detail'],
            "latitude"=> $_GPC['latitude'],
            "longitude"=> $_GPC['longitude'],
            "province"=> $_GPC['province'],
            "city"=> $_GPC['city'],
            "district"=> $_GPC['district'],
            "default" => $_GPC['default'],
            "create_time" => $_SERVER['REQUEST_TIME']
        ];
        if( $_GPC['default'] == 1){
            pdo_update('ox_reclaim_address',['default'=> 0],[ "uid"=> $_GPC['uid'], "uniacid"=> $_W['uniacid']]);
        }
        if($_GPC['id']){
            pdo_update('ox_reclaim_address',$params,['id'=>$_GPC['id']]);
        }else{
            pdo_insert('ox_reclaim_address',$params);
        }
        return $this->result(0, '', '');
    }



}