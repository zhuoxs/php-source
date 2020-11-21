<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if ($op=="display") {

    $userid = intval(($_GPC['userid']));
    $user = pdo_get($this->table_user, array('id'=>$userid,'uniacid'=>$_W['uniacid']));
    if (empty($user)) {
        $this->result(1, '用户信息不存在！');
    }

    $headpic = tomedia($user['headpic']);

    $ulevelarr = array(1=>"正式党员", 2=>"预备党员", 3=>"发展对象", 4=>"入党积极分子");
    $this->result(0, '', array(
        'user'    => $user,
        'ulevel'  => $ulevelarr[$user['ulevel']],
        'headpic' => $headpic
        ));


}elseif ($op=="postinfo") {

    $mobile = trim($_GPC['mobile']);
    $userid = intval(($_GPC['userid']));
    $haveuser = pdo_fetch("SELECT * FROM".tablename($this->table_user)." WHERE id<>:id AND mobile=:mobile AND uniacid=:uniacid AND recycle=0 LIMIT 1 ", array(':id'=>$userid,':mobile'=>$mobile,':uniacid'=>$_W['uniacid']));
    if (!empty($haveuser)) {
        $this->result(1, '该手机号已存在！');
    }
    $data = array(
        'mobile'    => $mobile,
        'birthday'  => trim($_GPC['birthday']),
        'sex'       => intval($_GPC['sex']),
        'origin'    => trim($_GPC['origin']),
        'nation'    => trim($_GPC['nation']),
        'education' => trim($_GPC['education']),
        );
    $partyday = trim($_GPC['partyday']);
    if (!empty($partyday)) {
        $data['partyday'] = $partyday;
    }
    pdo_update($this->table_user, $data, array('id'=>$userid));
    $this->result(0, '', array());


}elseif ($op=="postheadpic") {

    $headpic = trim($_GPC['headpic']);
    if (empty($headpic)) {
        $this->result(1, '图片未上传成功，请重试！');
    }
    $userid = intval(($_GPC['userid']));
    pdo_update($this->table_user, array('headpic'=>$headpic), array('id'=>$userid));
    $this->result(0, '', array());
    
}
?>