<?php

if (!(defined('IN_IA')))
{
    exit('Access Denied');
}

class Api_Publish extends WeModuleWxapp
{
    //发布权限及是否有未发布完成的数据
    public function add_power(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];

        //检查是否可发布
        $info = pdo_get('ox_reathouse_info',array('uniacid'=>$uniacid));
        $res = ['uid'=>'','id'=>0];
        $user_info = pdo_get('ox_reathouse_member',array('uniacid'=>$_W['uniacid'],'uid'=>$_GPC['uid']));
        if(!$user_info['is_publish'])
        {
            $res['uid'] = 'no';
            return $this->result(0, '', $res);
        }

        $house_info = pdo_get('ox_reathouse_house_info',array('uniacid'=>$uniacid,'uid'=>$_GPC['uid'],'status'=>2));
        //查询所有标签 和所有设施
        $sheshi = pdo_getall('ox_reathouse_facility',array('uniacid'=>$uniacid));
        if(empty($sheshi)){
            $sheshi_add = new sheshi();
            $sheshi_add->add();
            $sheshi = pdo_getall('ox_reathouse_facility',array('uniacid'=>$uniacid));
        }
        foreach ($sheshi as &$value){
            $value['icon'] = tomedia($value['icon']);
            $value['xzicon'] = 0;
        }
        $tag = pdo_getall('ox_reathouse_tag',array('uniacid'=>$uniacid));
        foreach ($tag as &$tag_value){
            $tag_value['xuanzhong'] = 0;
        }
        if(empty($house_info)){
            //没有未完成的数据
            $res['other']['sheshi'] = $sheshi;
            $res['other']['tag'] = $tag;
            return $this->result(0, '',$res );
        }else{
            // 返回未完成数据的全部数据
            $house_info['other']['sheshi'] = $sheshi;
            $house_info['other']['tag'] = $tag;
            //返回图片
            $img_arr = pdo_getall('ox_reathouse_img',array('house_id'=>$house_info['id'],'uniacid'=>$uniacid));
            $house_info['imgs'] = array();
            foreach ($img_arr as $img_value){
                $house_info['imgs'][] = array(
                    'all'=>tomedia($img_value['url']),
                    'short'=>$img_value['url']
                );
            }
            //返回设施列表
            $house_info['sheshi'] = explode(',',$house_info['facility_id']);
            foreach ($house_info['other']['sheshi'] as &$valueicon){
                if(in_array($valueicon['id'],$house_info['sheshi'])){
                    $valueicon['xzicon'] = 1;
                }
            }

            return $this->result(0, '', $house_info);
        }
    }

    // 获取小程序基本信息
    public function add_one(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        //检查是否可发布
        $info = pdo_get('ox_reathouse_info',array('uniacid'=>$uniacid));

        $user_info = pdo_get('ox_reathouse_member',array('uniacid'=>$_W['uniacid'],'uid'=>$_GPC['uid']));
        if(!$user_info['is_publish'])
        {
            return $this->result(200, '您没有权限发布', $user_info);
        }
        //数据整理
        $data = array(
            'type_id'=>$_GPC['type_id'],
            'name'=>$_GPC['name'],
            'floor1'=>$_GPC['floor1']-3,
            'floor2'=>$_GPC['floor2']+1,
            'oriented_id'=>$_GPC['oriented_id'],
            'house_type_shi'=>$_GPC['house_type_shi'],
            'house_type_ting'=>$_GPC['house_type_ting'],
            'house_type_wei'=>$_GPC['house_type_wei'],
            'area'=>$_GPC['area'],
            'renovation'=>$_GPC['renovation'],
            'price'=>$_GPC['price'],
            'yafu_ya'=>$_GPC['yafu_ya'],
            'yafu_fu'=>$_GPC['yafu_fu']+1,
            'uid'=>$_GPC['uid'],
            'update_time'=>time(),
        );
        if(!empty($_GPC['id'])){
            $res = pdo_update('ox_reathouse_house_info',$data,array('id'=>$_GPC['id'],'uniacid'=>$uniacid));
            $houser_id = $_GPC['id'];
        }else{
            //删除该用户所有未完成的发布
            pdo_delete('ox_reathouse_house_info',array('uniacid'=>$uniacid,'uid'=>$_GPC['uid'],'status'=>2));

            $data['uniacid'] = $uniacid;
            $data['create_time'] = time();
            $res = pdo_insert('ox_reathouse_house_info',$data);
            $houser_id = pdo_insertid();
        }
        if($res){
            return $this->result(0, '', array('id'=>$houser_id));
        }else{
            return $this->result(200, '添加失败', $data);
        }

    }
    /*
     * 提交第二屏内容
     */
    public function add_two(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = $_GPC['id'];
        //检查是否可发布
        $info = pdo_get('ox_reathouse_info',array('uniacid'=>$uniacid));
        $user_info = pdo_get('ox_reathouse_member',array('uniacid'=>$_W['uniacid'],'uid'=>$_GPC['uid']));
        if(!$user_info['is_publish'])
        {
            return $this->result(200, '您没有权限发布', $user_info);
        }
        //检查该条数据是否可修改
        $house_info = pdo_get('ox_reathouse_house_info',array('id'=>$id,'uniacid'=>$uniacid,'uid'=>$_GPC['uid']));
        if(empty($house_info)){
            return $this->result(200, '数据异常', $_GPC);
        }
        //图片处理--删除原有所有图片
        pdo_delete('ox_reathouse_img',array('uniacid'=>$uniacid,'house_id'=>$id));
        //处理图片格式 并添加
        $img_arr = json_decode(htmlspecialchars_decode($_GPC['imgs']),1);
        $data = array(
            'uniacid'=>$uniacid,
            'house_id'=>$id,
            'sort'=>1,
            'create_time'=>time()
        );
        $img_id = '';
        foreach ($img_arr as $value){
            $data['url'] = $value['short'];
            pdo_insert('ox_reathouse_img',$data);
            if($img_id==''){
                $img_id = pdo_insertid();
            }
        }
        //修改
        $udata['facility_id'] = $_GPC['esheshi'];
        $udata['update_time'] = time();
        $udata['img_id'] = $img_id;
        $res = pdo_update('ox_reathouse_house_info',$udata,array('id'=>$id,'uniacid'=>$uniacid));

        if($res){
            return $this->result(0, '', $_GPC['imgs']);
        }else{
            return $this->result(200, '添加失败', $_GPC);
        }
    }
    public function add_three(){
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $id = $_GPC['id'];
        //检查是否可发布
        $info = pdo_get('ox_reathouse_info',array('uniacid'=>$uniacid));
        $user_info = pdo_get('ox_reathouse_member',array('uniacid'=>$_W['uniacid'],'uid'=>$_GPC['uid']));
        if(!$user_info['is_publish'])
        {
            return $this->result(200, '您没有权限发布', $user_info);
        }
        //检查该条数据是否可修改
        $house_info = pdo_get('ox_reathouse_house_info',array('id'=>$id,'uniacid'=>$uniacid,'uid'=>$_GPC['uid']));
        if(empty($house_info)){
            return $this->result(200, '数据异常', $_GPC);
        }

        //修改
        $udata['tag_id'] = $_GPC['tagcheck'];
        $udata['address'] = $_GPC['address'];
        $udata['mapx'] = $_GPC['mapx'];
        $udata['mapy'] = $_GPC['mapy'];
        $udata['desc'] = $_GPC['desc'];

        $udata['update_time'] = time();
        $udata['status'] = 1;
        $res = pdo_update('ox_reathouse_house_info',$udata,array('id'=>$id,'uniacid'=>$uniacid));

        if($res){
            return $this->result(0, '', $_GPC);
        }else{
            return $this->result(200, '添加失败', $_GPC);
        }
    }
    public function ceshi(){
        global $_GPC, $_W;
        $data = array(
            array(
              'icon'=>$_W['siteroot'].'addons/ox_reathouse/icon/bingxiang.png',
              'name'=>'冰箱',
              'uniacid'=>$_W['uniacid'],
              'create_time'=>time()
            ),
            array(
                'icon'=>$_W['siteroot'].'addons/ox_reathouse/icon/chuang.png',
                'name'=>'床',
                'uniacid'=>$_W['uniacid'],
                'create_time'=>time()
            ),
            array(
                'icon'=>$_W['siteroot'].'addons/ox_reathouse/icon/diancilu.png',
                'name'=>'电磁炉',
                'uniacid'=>$_W['uniacid'],
                'create_time'=>time()
            ),
            array(
                'icon'=>$_W['siteroot'].'addons/ox_reathouse/icon/tv.png',
                'name'=>'电视',
                'uniacid'=>$_W['uniacid'],
                'create_time'=>time()
            ),
            array(
                'icon'=>$_W['siteroot'].'addons/ox_reathouse/icon/kongtiao.png',
                'name'=>'空调',
                'uniacid'=>$_W['uniacid'],
                'create_time'=>time()
            ),
            array(
                'icon'=>$_W['siteroot'].'addons/ox_reathouse/icon/kuandai.png',
                'name'=>'宽带',
                'uniacid'=>$_W['uniacid'],
                'create_time'=>time()
            ),
            array(
                'icon'=>$_W['siteroot'].'addons/ox_reathouse/icon/nuanqi.png',
                'name'=>'暖气',
                'uniacid'=>$_W['uniacid'],
                'create_time'=>time()
            ),
            array(
                'icon'=>$_W['siteroot'].'addons/ox_reathouse/icon/ranqizao.png',
                'name'=>'燃气灶',
                'uniacid'=>$_W['uniacid'],
                'create_time'=>time()
            ),
            array(
                'icon'=>$_W['siteroot'].'addons/ox_reathouse/icon/reshuiqi.png',
                'name'=>'热水器',
                'uniacid'=>$_W['uniacid'],
                'create_time'=>time()
            ),
            array(
                'icon'=>$_W['siteroot'].'addons/ox_reathouse/icon/shafa.png',
                'name'=>'沙发',
                'uniacid'=>$_W['uniacid'],
                'create_time'=>time()
            ),
            array(
                'icon'=>$_W['siteroot'].'addons/ox_reathouse/icon/shuzhuo.png',
                'name'=>'书桌',
                'uniacid'=>$_W['uniacid'],
                'create_time'=>time()
            ),
            array(
                'icon'=>$_W['siteroot'].'addons/ox_reathouse/icon/weibolu.png',
                'name'=>'微波炉',
                'uniacid'=>$_W['uniacid'],
                'create_time'=>time()
            ),
            array(
                'icon'=>$_W['siteroot'].'addons/ox_reathouse/icon/xiyiji.png',
                'name'=>'洗衣机',
                'uniacid'=>$_W['uniacid'],
                'create_time'=>time()
            ),
            array(
                'icon'=>$_W['siteroot'].'addons/ox_reathouse/icon/yangtai.png',
                'name'=>'阳台',
                'uniacid'=>$_W['uniacid'],
                'create_time'=>time()
            ),
            array(
                'icon'=>$_W['siteroot'].'addons/ox_reathouse/icon/yigui.png',
                'name'=>'衣柜',
                'uniacid'=>$_W['uniacid'],
                'create_time'=>time()
            ),
            array(
                'icon'=>$_W['siteroot'].'addons/ox_reathouse/icon/youyanji.png',
                'name'=>'油烟机',
                'uniacid'=>$_W['uniacid'],
                'create_time'=>time()
            ),
        );
        $facility = pdo_get('ox_reathouse_facility',['uniacid'=>$_W['uniacid']]);
        if(empty($facility)){
            foreach ($data as $v){
                $res = pdo_insert('ox_reathouse_facility',$v);
            }
        }
        die($res);
    }


}