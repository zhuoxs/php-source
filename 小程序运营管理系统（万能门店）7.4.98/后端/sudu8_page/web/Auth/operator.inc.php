<?php

$_W = self::$_W;

$act = isset(self::$_GPC['act']) ? self::$_GPC['act'] : '';



if($act == ''){


    $sql = "SELECT uid FROM ".tablename('sudu8_page_muser')." WHERE `uniacid` = ".self::$_W['uniacid'];

    $uid = pdo_fetchall($sql);

    $sql = "SELECT uid FROM ".tablename('users_permission')." WHERE `uniacid` = ".self::$_W['uniacid']." AND `type` = 'sudu8_page'";

    $perminion = pdo_fetchall($sql);

    $uids = [];

    if($perminion){

        foreach ($perminion as $k => $v){

            $uids[] = $v['uid'];

        }

    }

    if($uids){

        foreach ($uid as $k => $v){

            $uids[] = $v['uid'];

        }



        $sql = "SELECT * FROM ".tablename('users')." WHERE uid IN (".implode(',',$uids).")";

        $user = pdo_fetchall($sql);

    }

    return include self::template('web/Auth/operator');

}
if($act == 'setauth'){
    $modulelist = uni_modules();  //获取插件信息
    $plist = [];
    foreach($modulelist as $k => $v){
        if(strstr($k , "sudu8_page_") != NULL){
          $plist[$v['name']]['url'] = './index.php?c=home&amp;a=welcome&amp;do=ext&amp;m='.$v['name'].'&amp;version_id=4';
          $plist[$v['name']]['icon'] = $v['logo'];
          $plist[$v['name']]['title'] = $v['title'];
        }
    }
    $catelists = pdo_fetchall("SELECT id,cate_name,pid FROM ".tablename('sudu8_page_mcategory')." WHERE stat = 1 ORDER BY sort DESC");
    $list = \Core\vender\Factory::array_to_trees($catelists,0);
    $uid = self::$_GPC['userid'];
    /*获取用户的默认权限*/
    $auth = pdo_get("sudu8_page_mauth",array('userid' => $uid,'uniacid' => self::$_W['uniacid']));
    if(!empty($auth['parent'])) $auth['parent'] = explode(',',$auth['parent']);
    if(!empty($auth['child'])) $auth['child'] = explode(',',$auth['child']);
    if(!empty($auth['mini'])) $auth['mini'] = explode(',',$auth['mini']);
    return include self::template('web/Auth/setauthuser');
}

if($act == 'savesetauth'){
    $data = $_POST;
    if(count($data['parent']) > 0){
        $data['parent'] = implode(',',$data['parent']);
    }

    if(count($data['child']) > 0){
        $data['child'] = implode(',',$data['child']);
    }

    if(count($data['mini']) > 0){
        $data['mini'] = implode(',',$data['mini']);
    }
 
    $data['userid'] = isset($data['uid'])?$data['uid']:0;
    unset($data['uid']);
    if($data['userid'] == 0){
        return $this->returnResult(0,'参数错误');
    }

    $idata = pdo_get("sudu8_page_mauth",array('userid' => $data['userid']));
    if($idata && $idata['userid'] == $data['userid']){
        $uid = $data['userid'];unset($data['userid']);
        pdo_update("sudu8_page_mauth",$data,array('userid' => $uid,'uniacid' => self::$_W['uniacid']));
        cache_clean();
        $sql = "SELECT * FROM ".tablename('sudu8_page_muser')." WHERE `uid` = ".$data['userid']." AND `uniacid` = ".self::$_W['uniacid'];
        if(!pdo_fetch($sql)){
            pdo_insert("sudu8_page_muser",['uid' => $uid,'uniacid' => self::$_W['uniacid']]);
        }
        return $this->returnResult(1,'更新成功');
    }else{
        $data['uniacid'] = self::$_W['uniacid'];
        $result = pdo_insert("sudu8_page_mauth",$data);
        cache_clean();
        $sql = "SELECT * FROM ".tablename('sudu8_page_muser')." WHERE `uid` = ".$data['userid']." AND `uniacid` = ".self::$_W['uniacid'];
        if(!pdo_fetch($sql)){
            pdo_insert("sudu8_page_muser",['uid' => $data['userid'],'uniacid' => self::$_W['uniacid']]);
        }
        return $this->returnResult($result?1:0,$result?'操作成功':'操作失败');
    }

}