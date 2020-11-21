<?php

if (!(defined('IN_IA')))
{
    exit('Access Denied');
}

class Api_Master extends WeModuleWxapp
{
    /**
     * 服务分类
     */
    public function type(){
        global $_GPC, $_W;
        $list = pdo_getall('ox_master_type',['uniacid'=>$_W['uniacid'],'class_level'=>1],'','',['sort asc']);

        $typeall = $list;
        if($list){
            $list = array_column($list,'name');
        }
        $detail = pdo_get('ox_master_store',['uniacid'=>$_W['uniacid'],'uid'=>$_GPC['uid']]);
        $price = pdo_getcolumn('ox_master',["uniacid" => $_W['uniacid']],'price');
        $tip = pdo_getcolumn('ox_master',["uniacid" => $_W['uniacid']],'tip');

        $type_id = '';
        if(!empty($detail)){
            $type_id = explode(',',$detail['type_id']);
            //返回图片
            $img_arr = pdo_getall('ox_master_image',array('store_id'=>$detail['id'],'uniacid'=>$_W['uniacid']));
            $detail['imgs'] = array();
            foreach ($img_arr as $img_value){
                $detail['imgs'][] = array(
                    'all'=>tomedia($img_value['img_patch']),
                    'short'=>$img_value['img_patch']
                );
            }
        }

        foreach ($typeall as &$value){
            $value['img'] = tomedia($value['img']);
            if(!empty($type_id) && in_array($value['id'], $type_id)){
                $value['xuanzhong'] = 1;
            }else{
                $value['xuanzhong'] = 0;
            }
        }

        $info = pdo_get('ox_master',['uniacid'=>$_W['uniacid']]);

        if(!$detail['qq_map_key']){
            $detail['qq_map_key'] = "HEQBZ-R6TWR-3YHWF-WJACM-ZH6LE-3SFB6";
        }

        $result = [
            'typeall' => $typeall,
            'type' => $list,
            'detail' => $detail,
            'price' => $price,
            'tip' => $tip,
            'type_num' => $info['type_num'] ?: 3,
            'qq_map_key'=>$info['qq_map_key'] ?: "HEQBZ-R6TWR-3YHWF-WJACM-ZH6LE-3SFB6",
        ];
        return $this->result(0, '', $result);
    }

    /**
     * 师傅注册
     */
    public function register(){
        global $_GPC,$_W;
        $params = [
            'uid' => $_GPC['uid'],
            'uniacid' => $_W['uniacid'],
            'name' => $_GPC['name'],
            'phone' => $_GPC['phone'],
            'type_name' => $_GPC['type_name'],
            'create_time' => $_SERVER['REQUEST_TIME'],
            'is_repair' => '1'
        ];
        $detail = pdo_get('ox_master_member',['uid'=>$_GPC['uid']]);
        if($detail){
            pdo_update('ox_master_member',$params,['uid'=>$_GPC['uid']]);
            return $this->result(0, '注册成功', '');
        }
        $result = pdo_insert('ox_master_member',$params);
        if(!empty($result)){
            return $this->result(0, '注册成功', '');
        }
    }

    /**
     * 师傅详情
     */
    public function detail(){
        global $_GPC,$_W;
        $detail = pdo_get('ox_master_member',['uid'=>$_GPC['uid'],'uniacid' => $_W['uniacid']]);
        return $this->result(0, '',$detail);
    }


}