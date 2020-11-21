<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}
class Api_Need extends WeModuleWxapp
{

    // 获取首页信息
    public function type(){
        global $_GPC, $_W;
        $type =pdo_fetchall("select * from ".tablename('ox_reclaim_type')." where `uniacid`={$_W['uniacid']}   order by sort DESC ");
        foreach ($type as $k => $v){
            $type[$k]['img'] = tomedia($v['img']);
        }
        $address = pdo_get('ox_reclaim_address',[   "uniacid" => $_W['uniacid'], "uid"=> $_GPC['uid']],'','',['id desc,default desc']);
        $result = [
            'type' => $type,
            'address' =>$address,
        ];
        return $this->result(0, '', $result);
    }
    // 分类价格列表
    public function priceList($type_id){
        global $_GPC, $_W;
        return pdo_getall('ox_reclaim_type_price',['uniacid' => $_W['uniacid'],'type_id'=> $type_id]);
    }
    // 分类价格说明
    public function typeDetail(){
        global $_GPC, $_W;
        $detail = pdo_getcolumn('ox_reclaim_type',['uniacid' => $_W['uniacid'],'id'=> $_GPC['id']],'content');
        $detail = htmlspecialchars_decode($detail);
        $priceList = pdo_getall('ox_reclaim_type_price',['uniacid' => $_W['uniacid'],'type_id'=> $_GPC['id']]);
        $result = [
            'html' => $detail,
            'priceList' => $priceList
        ];
        return $this->result(0, '', $result);
    }

    // 验证区域开通
    public function service(){
        global $_GPC, $_W;
        $info = pdo_get('ox_reclaim_city',['uniacid' => $_W['uniacid'],'city_name'=> $_GPC['city_name'],'status'=> 1]);
        $result = [
            'info' => $info,
            'status' => $info? true : false
        ];
        return $this->result(0, '', $result);
    }

    // 申请开通该区域
    public function addService(){
        global $_GPC, $_W;
        $info = pdo_get('ox_reclaim_city',['uniacid' => $_W['uniacid'],'city_name'=> $_GPC['city_name']]);
        if(!$info){
            pdo_insert('ox_reclaim_city',['uniacid' => $_W['uniacid'],'city_name'=> $_GPC['city_name'],'province'=> $_GPC['province'],'create_time'=>$_SERVER['REQUEST_TIME']]);
        }
        return $this->result(0, '', '');
    }

    // 回收订单
    public function createOrder(){
        global $_GPC, $_W;
        $base = new Basis();
        $base->add_form_id($_GPC['uid'],$_GPC['formid']);
        $params = [
            "formid" => $_GPC['formid'],
            "uid"=> $_GPC['uid'],
            "uniacid" => $_W['uniacid'],
            "type_name"=> $_GPC['type_name'],
            "o_sn" => order_sn(),
            "address"=> $_GPC['address'],
            "address_detail"=> $_GPC['address_detail'],
            "name"=> $_GPC['name'],
            "phone"=> $_GPC['phone'],
            "go_time"=> $_GPC['phone'],
            "remark"=> $_GPC['remark'],
            "cycle"=> $_GPC['cycle'] ?: 0,
            "go_time"=> strtotime($_GPC['time']),
            "status" => 0,
            "longitude"=> $_GPC['longitude'],
            "latitude"=> $_GPC['latitude'],
            "province"=> $_GPC['province'],
            "city"=> $_GPC['city'],
            "district"=> $_GPC['district'],
            "create_time" => $_SERVER['REQUEST_TIME']
        ];
        pdo_insert('ox_reclaim_order',$params);
        $order_id = pdo_insertid();

        if($_GPC['imgs']){
            $imgs = json_decode(htmlspecialchars_decode($_GPC['imgs']),1);
            $data = [
                'order_id' => $order_id,
                'uniacid'=> $_W['uniacid'],
                'type' => 1,
                'create_time' => $_SERVER['REQUEST_TIME']
            ];
            foreach ($imgs as $k => $v){
                $data['img'] = $v['short'];
                pdo_insert('ox_reclaim_image',$data);
            }

        }
        Message::Instance()->uniformSend([
            'type' => 1,
            'uid' => $params['uid'],
            'keyword' => [
                $params['o_sn'],
                $params['type_name'],
                $params['name'],
                $params['phone'],
            ]
        ]);
        return $this->result(0, '', '');
    }



}