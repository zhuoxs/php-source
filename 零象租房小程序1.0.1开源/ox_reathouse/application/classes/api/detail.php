<?php

if (!(defined('IN_IA')))
{
    exit('Access Denied');
}

class Api_Detail extends WeModuleWxapp
{
    public function index(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $uid = $_GPC['uid'];
        $id = $_GPC['id'];
        //详情
        $info = pdo_get('ox_reathouse_house_info',array('uniacid'=>$uniacid,'id'=>$id,'status'=>1));
        if(empty($info)){
            return $this->result(200, '数据错误', $_GPC);
        }
        //各种类型
        $type_arr = array('1'=>'整租','2'=>'合租','3'=>'民宿');
        $info['type_text'] = $type_arr[$info['type_id']];

        $chaoxiang_arr = array('0'=>'东', '1'=>'南', '2'=>'西', '3'=>'北', '4'=>'南北', '5'=>'东西', '6'=>'东南', '7'=>'东北','8'=>'西南', '9'=>'西北');
        $info['oriented_text'] = $chaoxiang_arr[$info['oriented_id']];

        $renovation_arr = array('0'=>'精装','1'=>'简装','2'=>'毛坯');
        $info['renovation_text'] = $renovation_arr[$info['renovation']];

        $info['date'] = date('Y-m-d',$info['update_time']);
        //图片
        $info['imgs'] = pdo_getall('ox_reathouse_img',array('uniacid'=>$uniacid,'house_id'=>$id));
        foreach ($info['imgs'] as &$img_value){
            $img_value['url'] = tomedia($img_value['url'] );
        }
        //标签
        $tag_arr = explode(',',$info['tag_id']);
        $info['tag_arr'] = pdo_getall('ox_reathouse_tag',array('uniacid'=>$uniacid,'id in'=>$tag_arr));

        //设施
        $facility_arr = explode(',',$info['facility_id']);
        $info['facility_arr']  = pdo_getall('ox_reathouse_facility',array('uniacid'=>$uniacid,'id in'=>$facility_arr));
        foreach ($info['facility_arr'] as &$facility_value){
            $facility_value['icon'] = tomedia($facility_value['icon']);
        }
        //获取基础设置表信息
        $pingtai = pdo_get('ox_reathouse_info',['uniacid'=>$_W['uniacid']]);
        $info['pingtai'] = $pingtai;
        //获取是否收藏
        $info['fav'] = pdo_getcolumn('ox_reathouse_fav',array('uniacid' => $uniacid,'hid' => $id, 'uid' => $uid),'id');

        return $this->result(0, '', $info);
    }

    /**
     * 添加收藏
     * @return string
     * @author cheng.liu
     * @date 2019/3/12
     */
    public function fav()
    {
        global $_GPC, $_W;

        $uniacid = $_W['uniacid'];
        $uid = $_GPC['uid'];
        $hid = $_GPC['id'];

        if(empty($uid) && empty($hid)){
            return $this->result(-1, '缺少必要参数');
        }
        //判断是否收藏过
        $exist = pdo_getcolumn('ox_reathouse_fav',array('uniacid' => $uniacid,'hid' => $hid, 'uid' => $uid),'id');
        if($exist){
            //取消收藏
            $param = array(
                'uniacid' => $uniacid,
                'uid' => $uid,
                'hid' => $hid,
            );
            $result = pdo_delete('ox_reathouse_fav', $param);
            if (!empty($result)) {
                return $this->result(0, '取消成功',array('fav'=>0));
            }else{
                return $this->result(-1, '取消失败');
            }
        }else{
            //收藏
            $param = array(
                'uniacid' => $uniacid,
                'uid' => $uid,
                'hid' => $hid,
                'create_time' => time()
            );
            $result = pdo_insert('ox_reathouse_fav', $param);
            if (!empty($result)) {
                return $this->result(0, '收藏成功',array('fav'=>1));
            }else{
                return $this->result(-1, '收藏失败');
            }
        }
    }
}