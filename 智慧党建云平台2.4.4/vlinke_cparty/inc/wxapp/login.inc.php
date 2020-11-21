<?php
global $_W,$_GPC;
$op = $_GPC['op']?$_GPC['op']:'display';

if (empty($_W['openid'])) {
    $this->result(41009, '请先登录');
}

if ($op=="display") {
	$param = pdo_get($this->table_param,array('uniacid'=>$_W['uniacid']));
    if (empty($param)) {
        $this->result(1, '请先配置基本信息！');
    }
    $param['wxappshareimageurl'] = tomedia($param['wxappshareimageurl']);
    $param['loginpic'] = tomedia($param['loginpic']);
    $this->result(0, '', array(
    	'param'=>$param
    	));

}elseif ($op == 'getcode') {
    $mobile = trim($_GPC['mobile']);
    load()->model('cloud');
    $code = random(4, true);
    $_SESSION["mobilecode".$mobile] = $code;
    $content = '您的短信验证码为:'.$code.' 您正在使用'.$_W['account']['name'].'相关功能, 需要你进行身份确认';
    $result = cloud_sms_send($mobile, $content);
    if (is_error($result)) {
    	$this->result(1, '短信验证码发送失败，错误：'.$result['message']);
    } else {
        $this->result(0, '', array());
    }

}elseif ($op=="post") {
	$param = pdo_get($this->table_param,array('uniacid'=>$_W['uniacid']));
    if (empty($param)) {
        $this->result(1, '请先配置基本信息！');
    }

    $realname = trim($_GPC['realname']);
    $par = array('uniacid'=>$_W['uniacid'],'recycle'=>0,'realname'=>$realname);
    $mobile = trim($_GPC['mobile']);
	if ($param['loginmobile']==1) {
        $par['mobile'] = $mobile;
    }elseif ($param['loginmobile']==2) {
        if ($_SESSION["mobilecode".$mobile] != trim($_GPC['code'])) {
        	$this->result(1, '验证码不正确！');
        }
        $par['mobile'] = $mobile;
    }

    $idnumber = strtoupper(trim($_GPC['idnumber']));
    if ($param['loginidnumber']==1) {
        $idnumber = strtoupper(trim($_GPC['idnumber']));
        $par['idnumber'] = $idnumber;
    }

    if (empty($mobile) && empty($idnumber)) {
    	$this->result(1, '绑定登录时，手机号和身份证号不能同时为空！');
    }
	
	$user = pdo_get($this->table_user, $par);
	if (empty($user)) {
		$this->result(1, '该组信息对应的党员信息不存在！');
	}
	if (!empty($user['wxappopenid'])) {
		$this->result(1, "该账号已绑定过昵称为[".$user['wxappnickname']."]的个人微信号，请先解除绑定！");
	}
	$data = array(
		'wxappopenid'     => trim($_W['openid']),
        'wxappnickname'   => trim($_GPC['nickname']),
        'wxappheadimgurl' => trim($_GPC['headimgurl']),
		);
	if (empty($user['headpic'])) {
		$data['headpic'] = trim($_GPC['headimgurl']);
	}
	pdo_update($this->table_user, $data, array('id'=>$user['id']));
	$this->result(0, '', array());

}elseif ($op=="untie") {
    $userid = intval($_GPC['userid']);
    $user = pdo_get($this->table_user, array('id'=>$userid,'uniacid'=>$_W['uniacid'],'recycle'=>0));
    if (empty($user)) {
        $this->result(1, '解绑用户信息不存在，请重试！');
    }
    $data = array(
        'wxappopenid'     => "",
        'wxappnickname'   => "",
        'wxappheadimgurl' => ""
        );
    pdo_update($this->table_user, $data, array('id'=>$userid));
    $this->result(0, '', array());


}	
?>