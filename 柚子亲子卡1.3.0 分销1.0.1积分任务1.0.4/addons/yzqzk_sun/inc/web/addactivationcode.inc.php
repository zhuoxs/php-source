<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//$info=pdo_get('yzqzk_sun_activationcode',array('id'=>$_GPC['id']));
//作用：产生随机字符串，不长于32位
function createNoncestr($length = 32) {
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}
function only($instr) {
    $instr = md5($instr, true);
    $dict = '0123456789ABCDEFGHIJKLMNOPQRSTUV';
    $outstr = '';
    for ($i = 0; $i < 8; $i++) {
        $ord = ord($instr[$i]);
        $outstr .= $dict[( $ord ^ ord($instr[$i + 8]) ) - $ord & 0x1F];
    }
    return $outstr;
}

if(checksubmit('submit')){
    if($_GPC['num']<1||$_GPC['num']>100){
        message('请填写正确格式数量','','error');
    }
    if($_GPC['days_num']<1){
        message('请填写正确天数','','error');
    }
    $success=0;
    for($i=0;$i<$_GPC['num'];$i++){
        $data=array();
        $data['uniacid']=$_W['uniacid'];
        if($_GPC['type']==2){
           // $data['code']=date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
            $data['code']=only(time().createNoncestr(6));
        }else{
            $data['code']=date("YmdHis") .rand(11111, 99999).createNoncestr(6);
        }
        $data['num']=$_GPC['days_num'];
        $data['add_time']=time();
        $res=pdo_insert('yzqzk_sun_activationcode', $data);
        if($res){
            $success++;
        }
    }
    if($success==$_GPC['num']){
        message('添加成功',$this->createWebUrl('activationcode',array()),'success');
    }else{
        $fail=$_GPC['num']-$success;
        $msg="成功添加$success 条,失败$fail 条";
        message($msg,'','error');
    }



    
}
include $this->template('web/addactivationcode');