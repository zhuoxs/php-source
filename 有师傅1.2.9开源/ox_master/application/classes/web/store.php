<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class Web_Store extends Web_Base {
    /**
     * 师傅列表
     */
    public function storeList()
    {
        global $_GPC, $_W;
        $params = [
            "uniacid" => $_W['uniacid'],
            'status' => 1
        ];
        $pageSize = $_GPC['limit'] ?: 20;
        $pageCur = $_GPC['page'] ?: 1;
        $query = '';
        if($_GPC['key']){
            $query .= " and (name like '%{$_GPC['key']}%' or phone like '%{$_GPC['key']}%') ";
        }
        if($_GPC['date']) {
            $begin = $_GPC['date'][0] / 1000;
            $end = $_GPC['date'][1] / 1000;
            $query .= " and create_time >{$begin} and create_time < {$end} ";
        }
        if(!empty($_GPC['type_name'])){
            $query .= " and type_name like '%{$_GPC['type_name']}%' ";
        }
        $list=pdo_fetchall("select * from ".tablename('ox_master_store')."  where `uniacid`= {$_W['uniacid']} and status='1' {$query} order by id desc LIMIT " . ($pageCur - 1) * $pageSize . ",{$pageSize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_master_store')."  where `uniacid`= {$_W['uniacid']} and status='1' {$query}  ");

        $total = intval($total);
        foreach ($list as $k => $v){
            $imgs = pdo_getall('ox_master_image',['store_id'=>$v['id']],['id','img_patch']);
            foreach ($imgs as $z => $y){
                $imgs[$z]['img_patch'] = tomedia($y['img_patch']);
            }
            $list[$k]['imgs'] = $imgs;
        }
        $type = pdo_getall('ox_master_type',array('uniacid'=>$_W['uniacid'],'class_level'=>1));
        foreach ($type as $type_value){
            $type_name[] = array(
                'value'=>$type_value['name'],
                'label'=>$type_value['name'],
            );
        }

        $result = [
            'list' => $list,
            'total' => $total,
            'type_name'=>$type_name
        ];
        return $this->result('0','sufcc',$result);

    }
    /**
     * 指派列表
     */
    public function shifuList(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $order_id = $_GPC['order_id'];
        $shifu_ids = array();
        $query1=" ";
        $query = " and uid not in (";
        $shifu_ids = pdo_fetchall("select reapir_uid from " .tablename('ox_master_bidding'). " where uniacid='{$uniacid}' and order_id='{$order_id}'");
        if (!empty($shifu_ids))
        {
            foreach ($shifu_ids as $k=>$v){
                $query.= " ".$v['reapir_uid'].",";
            }
            $query1 =rtrim($query, ",");
            $query1.=")";
        }
        $order_info = pdo_get('ox_master_order',array('uniacid'=>$uniacid,'id'=>$order_id));

        $list = pdo_fetchall("select * from " .tablename('ox_master_store'). " where uniacid='{$uniacid}' and status=1 and isoff=1 and type_name like '%".$order_info['type_name']."%' ".$query1);
        $qitime = time()-604800;
        foreach ($list as &$value){
            $value['tel_num'] = pdo_fetchcolumn("select count(*) from ".tablename('ox_master_formid')."  where `uniacid`= {$_W['uniacid']} and `status`=0 and  `create_time`>{$qitime} and uid={$value['uid']}");
            $value['price'] = '';
        }
        return $this->result('0','sufcc',$list);
    }

    /**
     * 审核列表
     */
    public function shenheList()
    {
        global $_GPC, $_W;
        $params = [
            "uniacid" => $_W['uniacid'],
            'status' => 0
        ];
        $pageSize = $_GPC['limit'] ?: 20;
        $pageCur = $_GPC['page'] ?: 1;
        $query = '';
        if($_GPC['key']){
            $query .= " and (name like '%{$_GPC['key']}%' or phone like '%{$_GPC['key']}%') ";
        }
        if($_GPC['date']) {
            $begin = $_GPC['date'][0] / 1000;
            $end = $_GPC['date'][1] / 1000;
            $query .= " and create_time >{$begin} and create_time < {$end} ";
        }
        $list=pdo_fetchall("select * from ".tablename('ox_master_store')."  where `uniacid`= {$_W['uniacid']} and status='0' {$query} order by id desc LIMIT " . ($pageCur - 1) * $pageSize . ",{$pageSize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_master_store')."  where `uniacid`= {$_W['uniacid']} and status='0' {$query}  ");
        $total = intval($total);
        foreach ($list as $k => $v){
            $imgs = pdo_getall('ox_master_image',['store_id'=>$v['id']],['id','img_patch']);
            foreach ($imgs as $z => $y){
                $imgs[$z]['img_patch'] = tomedia($y['img_patch']);
            }
            $list[$k]['imgs'] = $imgs;
        }

        $result = [
            'list' => $list,
            'total' => $total
        ];
        return $this->result('0','sufcc',$result);

    }

    /**
     * 审核
     */
    public function shenhe()
    {
        global $_GPC, $_W;
        $params = [
            'status' => 1
        ];
        $result = pdo_update('ox_master_store',$params,['id'=> $_GPC['id'],"uniacid" => $_W['uniacid']]);

        $detail = pdo_get('ox_master_store',['id'=> $_GPC['id'],"uniacid" => $_W['uniacid']]);
        $date = date('Y-m-d H:i',$_SERVER['REQUEST_TIME']);
        $data = [
            'uid' => $detail['uid'],
            'mes_id' => 1,
            'page' => '/pages/index/index',
            'keyword' => [$detail['name'],$detail['phone'],'入驻成功',$date]
        ];
        $result = Message::Instance()->send($data);

        return $this->result('0','操作成功',$result);

    }
    /**
     * 审核驳回
     */
    public function shenheDel()
    {
        global $_GPC, $_W;
        $params = [
            'status' => 2,
            'reject'=> $_GPC['value']
        ];
        $result = pdo_update('ox_master_store',$params,['id'=> $_GPC['id'],"uniacid" => $_W['uniacid']]);

        $detail = pdo_get('ox_master_store',['id'=> $_GPC['id'],"uniacid" => $_W['uniacid']]);
        $date = date('Y-m-d H:i',$_SERVER['REQUEST_TIME']);
        $data = [
            'uid' => $detail['uid'],
            'mes_id' => 1,
            'page' => '/pages/index/index',
            'keyword' => [$detail['name'],$detail['phone'],'入驻申请驳回',$date]
        ];
        Message::Instance()->send($data);

        if($result){
            return $this->result('0','操作成功',$result);
        }else{
            return $this->result('-1','操作失败',$result);
        }
    }


    /*
    * 修改师傅
    */
    public function storeEdit()
    {
        global $_W,$_GPC;
        $id=$_GPC['id'];
        $data=[
            'type_name' => $_GPC['type_name'],
            'name' => $_GPC['name'],
            'phone' => $_GPC['phone'],
            'address' => $_GPC['address'],
        ];
     
        $res=pdo_update('ox_master_store',$data,array('id'=>$id));
        return $this->result('0','修改成功',$_GPC);
    }
    /**
     * 删除师傅
     */
    public function storeDelete()
    {
        global $_GPC, $_W;
        $params = [
            'status' => 2,
            'black'=>time()
        ];
        $result = pdo_update('ox_master_store',$params,['id'=> $_GPC['id'],"uniacid" => $_W['uniacid']]);
        if($result){
            return $this->result('0','操作成功',$result);
        }else{
            return $this->result('-1','操作失败',$result);
        }

    }
    /**
     * 黑名单列表
     */
    public function storeBlackList()
    {
        global $_GPC, $_W;
        $params = [
            "uniacid" => $_W['uniacid'],
            'status' => 1
        ];
        $pageSize = $_GPC['limit'] ?: 20;
        $pageCur = $_GPC['page'] ?: 1;
        $query = '';
        if($_GPC['key']){
            $query .= " and (name like '%{$_GPC['key']}%' or phone like '%{$_GPC['key']}%') ";
        }
        if($_GPC['date']) {
            $begin = $_GPC['date'][0] / 1000;
            $end = $_GPC['date'][1] / 1000;
            $query .= " and create_time >{$begin} and create_time < {$end} ";
        }
        $list=pdo_fetchall("select * from ".tablename('ox_master_store')."  where `uniacid`= {$_W['uniacid']} and status='2' and black>0 {$query} order by id desc LIMIT " . ($pageCur - 1) * $pageSize . ",{$pageSize}");
        $total = pdo_fetchcolumn("select count(*) from ".tablename('ox_master_store')."  where `uniacid`= {$_W['uniacid']} and status='2' and black>0 {$query}  ");

        $total = intval($total);
        foreach ($list as $k => $v){
            $imgs = pdo_getall('ox_master_image',['store_id'=>$v['id']],['id','img_patch']);
            foreach ($imgs as $z => $y){
                $imgs[$z]['img_patch'] = tomedia($y['img_patch']);
            }
            $list[$k]['imgs'] = $imgs;
        }

        $result = [
            'list' => $list,
            'total' => $total
        ];
        return $this->result('0','sufcc',$result);

    }
    /**
     * 删除师傅
     */
    public function storeRecovery()
    {
        global $_GPC, $_W;
        $params = [
            'status' => 1,
            'black'=>0
        ];
        $result = pdo_update('ox_master_store',$params,['id'=> $_GPC['id'],"uniacid" => $_W['uniacid']]);
        if($result){
            return $this->result('0','操作成功',$result);
        }else{
            return $this->result('-1','操作失败',$result);
        }
    }
    /*
     * 修改师傅备注
     */
    public function editbeizhu(){
        global $_GPC, $_W;
        $where = [
            'uniacid' => $_W['uniacid'],
            'uid'=>$_GPC['uid']
        ];
        pdo_update('ox_master_store',['remark'=>$_GPC['remark']],$where);
        return $this->result('0','操作成功',$where);
    }

}

