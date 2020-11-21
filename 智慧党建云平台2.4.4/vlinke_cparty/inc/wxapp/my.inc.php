<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {

    if (empty($_W['openid'])) {
        $this->result(41009, '请先登录');
    }

    $param = pdo_get($this->table_param,array('uniacid'=>$_W['uniacid']));
    if (empty($param)) {
        $this->result(1, '请先配置基本信息！');
    }
    $param['wxappshareimageurl'] = tomedia($param['wxappshareimageurl']);
    $param['wxappmynav'] = iunserializer($param['wxappmynav']);
    if (!empty($param['wxappmynav'])) {
        foreach ($param['wxappmynav'] as $k => $v) {
            $param['wxappmynav'][$k]['pic'] = tomedia($v['pic']);
        }
    }

    $param['mypic'] = tomedia($param['mypic']);
    $telephone = iunserializer($param['telephone']);
    $telarr = array();
    if (!empty($telephone)) {
        foreach ($telephone as $k => $v) {
            $arr = explode("###", trim($v));
            $telarr[$k]['name'] = $arr[0];
            $telarr[$k]['phone'] = $arr[1];
        }
    }

    $user = pdo_get($this->table_user, array('wxappopenid'=>$_W['openid'],'uniacid'=>$_W['uniacid'],'recycle'=>0));
    if (empty($user)) {
        $this->result(1, '请先绑定微信号登录');
    }
    $user['headpic'] = tomedia($user['headpic']);
    $ulevelarr = array(1=>"正式党员",2=>"预备党员",3=>"发展对象",4=>"入党积极分子");
    $user['ulevelstr'] = $ulevelarr[$user['ulevel']];

    $branch = pdo_get($this->table_branch,array('id'=>$user['branchid']));
    $brancharr = pdo_fetchall("SELECT id, blevel, name FROM ".tablename($this->table_branch)." WHERE id IN ( ".$branch['scort']." ) AND uniacid=:uniacid ORDER BY field( id,".$branch['scort']." ), priority DESC ", array(':uniacid'=>$_W['uniacid']));


    $notice = pdo_fetch("SELECT * FROM ".tablename($this->table_notice)." WHERE branchid in (".$branch['scort'].") AND uniacid=:uniacid ORDER BY priority DESC, id DESC LIMIT 1 ",array(':uniacid'=>$_W['uniacid']));
    if (!empty($notice)) {
        $notice['createtime'] = date("Y-m-d", $notice['createtime']);
    }else{
        $notice = array();
    }
    

    $this->result(0, '', array(
        'param'     => $param,
        'telarr'    => $telarr,
        'user'      => $user,
        'brancharr' => $brancharr,
        'notice'    => $notice
        ));


}elseif ($op=="aboutus") {

    $param = pdo_get($this->table_param,array('uniacid'=>$_W['uniacid']));
    if (empty($param)) {
        $this->result(1, '请先配置基本信息！');
    }
    $param['wxappshareimageurl'] = tomedia($param['wxappshareimageurl']);
    $param['aboutus'] = str_replace('<img', '<img style="max-width:100%;height:auto" ', htmlspecialchars_decode($param['aboutus']));
    $telephone = iunserializer($param['telephone']);
    $telarr = array();
    if (!empty($telephone)) {
        foreach ($telephone as $k => $v) {
            $arr = explode("###", trim($v));
            $telarr[$k]['name'] = $arr[0];
            $telarr[$k]['phone'] = $arr[1];
        }
    }

    $this->result(0, '', array(
        'param'  => $param,
        'telarr' => $telarr
        ));
}
?>