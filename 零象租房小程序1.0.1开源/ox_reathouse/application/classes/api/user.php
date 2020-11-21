<?php

if (!(defined('IN_IA')))
{
    exit('Access Denied');
}

class Api_User extends WeModuleWxapp
{
    /**
     *
     */
    public function index(){
        global $_GPC, $_W;

        return $this->result(0, '', $result);
    }
    // 获取小程序基本信息
    public function getInfo(){
        global $_GPC, $_W;
        $detail = pdo_get('ox_reathouse_info',['uniacid'=>$_W['uniacid']]);

        $this->add_user($_GPC['uid']);

        $user_info = pdo_get('ox_reathouse_member',array('uniacid'=>$_W['uniacid'],'uid'=>$_GPC['uid']));
        $detail['publish'] = 0;
        if($user_info['is_publish'] ==1){
            $detail['publish'] = 1;
        }

        $result = [
            'info' => $detail
        ];
        return $this->result(0, '', $result);
    }
    public function userinfo(){
        global $_GPC;
        $this->add_user($_GPC['uid']);
        return $this->result(0, '', $_GPC['uid']);
    }

    public function add_user($uid){
        global $_W;
        $have_user = pdo_get('ox_reathouse_member',array('uniacid'=>$_W['uniacid'],'uid'=>$uid));
        if(empty($have_user)){
            $member = pdo_get('mc_members',array('uid'=>$uid));
            $fans = pdo_get('mc_mapping_fans',array('uid'=>$uid));
            if(empty($member)){
                return;
            }
            $data = array(
                'uniacid'=>$_W['uniacid'],
                'uid'=>$uid,
                'nickname'=>$member['nickname'],
                'avatar'=>$member['avatar'],
                'openid'=>$fans['openid'],
                'create_time'=>time(),
            );
            pdo_insert('ox_reathouse_member',$data);
        }
        return;
    }

    /*
     * 关于平台列表
     */
    /**
     * 小程序信息
     */
    public function about(){
        global $_GPC, $_W;
        $detail = pdo_get('ox_reathouse_info',['uniacid'=>$_W['uniacid']]);
        $list = pdo_getall('ox_reathouse_view',['uniacid'=>$_W['uniacid'],'type'=>1],['id','title'],'',['sort desc']);
        if($detail){
            if($detail['logo']){
                $detail['logo'] = tomedia($detail['logo']);
            }else{
                $detail['logo'] = tomedia('/addons/ox_reathouse/icon.jpg');
            }
        }
        $result = [
            'detail' => $detail,
            'list' => $list,
        ];
        return $this->result(0, '', $result);
    }
    /**
     * webview
     */
    public function webView(){
        global $_W, $_GPC;
        $params = [
            'uniacid' => $_W['uniacid']
        ];
        if($_GPC['type'] == 2){
            $detail = pdo_get('ox_reathouse_view',$params);
        }else{
            $params['id'] = $_GPC['id'];
            $detail = pdo_get('ox_reathouse_view',$params);
        }
        if($detail){
            $detail['content'] = htmlspecialchars_decode($detail['content']);
        }
        return $this->result(0,'',$detail);
    }
    /**
     * 反馈建议
     */
    public function suggest(){
        global $_GPC, $_W;
        $params = [
            'content' => $_GPC['suggest'],
            'uniacid'=>$_W['uniacid'],
            'create_time' => $_SERVER['REQUEST_TIME']
        ];
        $result = pdo_insert('ox_reathouse_suggest',$params);
        return $this->result(0, '', $result);
    }

}