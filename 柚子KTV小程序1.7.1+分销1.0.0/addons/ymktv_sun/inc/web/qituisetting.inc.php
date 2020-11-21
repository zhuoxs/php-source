<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$template = "web/setting/qituisetting";

$item = pdo_get('ymktv_sun_sms',array('uniacid'=>$_W['uniacid']));
if($item["qitui"]){
    $qitui = unserialize($item["qitui"]);
}
if(checksubmit('submit')){
    $indata=$_GPC['indata'];
    $data["qitui"] = serialize($indata);

    if($_GPC['id']==''){
        $data['uniacid']=trim($_W['uniacid']);
        $res=pdo_insert('ymktv_sun_sms',$data);
        if($res){
            message('添加成功',$this->createWebUrl('qituisetting',$this->urlarray),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('ymktv_sun_sms', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('qituisetting',$this->urlarray),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}
include $this->template($template);