<?php

if (!(defined('IN_IA')))
{
    exit('Access Denied');
}

class Api_Home extends WeModuleWxapp
{
    /**
     * 服务分类12321
     */
    public function index(){
        global $_GPC, $_W;
        // 服务列表
        $list = pdo_getall('ox_master_type',['uniacid'=>$_W['uniacid'],'class_level'=> 0,'parent_id' => 0],['id','name','show_num'],'',['sort desc']);
        if($list){
            foreach ($list as $k => $v){
                $serviceList = pdo_getall('ox_master_type',['uniacid'=>$_W['uniacid'],'class_level'=> 1,'parent_id' => $v['id']],['id','name','img'],'',['sort desc'],[$v['show_num']]);
                if($serviceList ){
                    foreach ($serviceList as $a => $b){
                        $serviceList[$a]['img'] =   tomedia($b['img']);
                    }
                }
                $list[$k]['service'] = $serviceList;
            }
        }
        // 轮播
        $banner = pdo_getall('ox_master_banner',['uniacid'=>$_W['uniacid']],'','',['sort asc'],'4');
        if($banner){
            foreach ($banner as $k => $v){
                $banner[$k]['img'] = tomedia($v['img']);
            }
        }
        // 导航
        $nav = pdo_getall('ox_master_type',['uniacid'=>$_W['uniacid'],'class_level'=> 1,'parent_id' => 0],['id','name','img'],'',['sort desc']);
        if($nav ){
            foreach ($nav as $a => $b){
                $nav[$a]['img'] =   tomedia($b['img']);
            }
        }
        // 小程序信息
        $detail = pdo_get('ox_master',['uniacid'=>$_W['uniacid']]);

        $result = [
            'list' => $list,
            'nav' => $nav,
            'banner'=> $banner,
            'info' => $detail,
            'key' => $detail['qq_map_key'] ?: 'HEQBZ-R6TWR-3YHWF-WJACM-ZH6LE-3SFB6',
        ];
        return $this->result(0, '', $result);
    }
    // 获取单项服务列表
    public function typeList(){
        global $_GPC, $_W;
        // 服务列表
        $detail = pdo_get('ox_master_type',['id' => $_GPC['type'],'uniacid'=>$_W['uniacid']]);
        $list = pdo_getall('ox_master_type',['uniacid'=>$_W['uniacid'],'class_level'=> 1,'parent_id' => $_GPC['type']],['id','name','img'],'',['sort desc']);
        if($list){
            foreach ($list as $k => $v){
                $list[$k]['img'] =tomedia($v['img']);
            }
        }
        if($detail){
            $detail['img'] = tomedia($detail['img']);
        }
        $result = [
            'list' => $list,
            'detail' => $detail
        ];
        return $this->result(0, '', $result);
    }
    //获取维修类型  123
    public function repairtype()
    {
        global $_GPC, $_W;
        $uniacid=$_W['uniacid'];
        $retype = pdo_fetchall('SELECT * FROM ' .tablename('ox_master_type').' WHERE uniacid='.$uniacid.' and class_level = 1 ORDER BY sort desc');
        return $this->result(0, '', array('retypeinfo'=>$retype));
    }

    // 获取小程序基本信息
    public function getInfo(){
        global $_GPC, $_W;
        $detail = pdo_get('ox_master',['uniacid'=>$_W['uniacid']]);
        $store = pdo_get('ox_master_store',['uniacid'=>$_W['uniacid'],'uid' => $_GPC['uid']]);
        $result = [
            'info' => $detail,
            'store'=> $store
        ];
        return $this->result(0, '', $result);
    }

     //热门搜索标签
    public function hotTag(){
        global $_GPC, $_W;
        $data = array();
        $hot = array();
        $list = pdo_getall('ox_master_type',['uniacid'=>$_W['uniacid']],['name'],'',['sort desc']);
        $hot = pdo_getall('ox_master_type',['uniacid'=>$_W['uniacid']],['name'],'',['sort desc'],7);
        if(!empty($list))foreach( $list as $k=>$v ){
            $data[$k] = $v['name'];
        }
        if(!empty($hot))foreach( $hot as $k=>$v ){
            $hot[$k] = $v['name'];
        }

        $page['list'] = $data;
        $page['hot'] = $hot;

        return $this->result(0,'',$page);

    }

    //获取用户手机号
    public function userphone()
    {
        global $_GPC, $_W;
        $account_api = WeAccount::create();
        $encrypt_data = $_GPC['encryptedData'];
        $iv = $_GPC['iv'];

        if (empty($_SESSION['session_key']) || empty($encrypt_data) || empty($iv)) {
            $account_api->result(1, '请先登录');
        }
        $phone = $account_api->pkcs7Encode($encrypt_data, $iv);
        if($phone && $phone['phoneNumber']){
            return $this->result(0, '',$phone['phoneNumber']);
        }
        return $this->result(500, '手机号码获取失败！请手动输入',$phone);
    }

}