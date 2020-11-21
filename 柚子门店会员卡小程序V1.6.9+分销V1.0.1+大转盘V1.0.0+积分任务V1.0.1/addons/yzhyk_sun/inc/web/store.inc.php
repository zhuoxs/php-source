<?php
global $_GPC, $_W;
$_GPC['op'] = $_GPC['op'] ?: "display";
$uniacid = $_SESSION['admin']['uniacid'];
//    根据 op 执行不同操作
switch($_GPC['op']){
//    数据查询
    case "query":
        $where = [];
        $where[] = 'isdel != 1';
        if($_GPC['key']){
            $where[] ="(name LIKE '%{$_GPC['key']}%' or code LIKE '%{$_GPC['key']}%')";
        }
        $this->query2($where);
        break;
//    获取门店
    case "select":
        $sql = "select id,name as text,CONCAT(code,name) as keywords from ".tablename('yzhyk_sun_store')." where isdel != 1 and uniacid = $uniacid";
        if($_SESSION['admin']['store_id']){
            $sql .= " and id = ".$_SESSION['admin']['store_id'];
        }
        $list = pdo_fetchall($sql,$data);
        echo json_encode($list);
        break;
//    保存-新增、修改
    case "save":
        $data['name'] = $_GPC['name'];
        $data['code'] = $_GPC['code'];
        $data['address'] = $_GPC['address'];
        $data['tel'] = $_GPC['tel'];
        $data['pic'] = $_GPC['pic'];
        $data['province_id'] = $_GPC['province_id'];
        $data['city_id'] = $_GPC['city_id'];
        $data['county_id'] = $_GPC['county_id'];
        $data['longitude'] = $_GPC['longitude'];
        $data['latitude'] = $_GPC['latitude'];
        $data['feie_user'] = $_GPC['feie_user'];
        $data['feie_ukey'] = $_GPC['feie_ukey'];
        $data['feie_sn'] = $_GPC['feie_sn'];
        $data['dingtalk_token'] = $_GPC['dingtalk_token'];
        $data['dispatch_detail'] = $_GPC['dispatch_detail'];
        $data['user_id'] = $_GPC['user_id'];
        $data['user_name'] = $_GPC['user_name'];
        $data['openid'] = $_GPC['openid'];

        $this->save($data);
        break;
    case "changecurrstore":
        $store_id = $_GPC['store_id'];
        $_SESSION['admin']['store_id'] = $store_id;
        break;
//    调用公共的方法
    default:
        $fun_name = $_GPC['op'];
        if(method_exists($this,$fun_name)){
            $this->{$fun_name}();
        }else{
            $this->display();
        }

}
