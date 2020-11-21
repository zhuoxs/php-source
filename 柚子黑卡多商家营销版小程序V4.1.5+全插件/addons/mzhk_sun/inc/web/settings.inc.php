<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$item=pdo_get('mzhk_sun_system',array('uniacid'=>$_W['uniacid']));
$scoretaskplugin=0;
if(pdo_tableexists("mzhk_sun_plugin_scoretask_system")){
    $scoretaskplugin=1;
}
// print_r($item);die;
if(checksubmit('submit')){
    $data['pt_name']=$_GPC['pt_name'];
    $data['tel']=$_GPC['tel'];

    $data['details']=html_entity_decode($_GPC['details']);
    $data['uniacid']=$_W['uniacid'];       
    $data['address']=$_GPC['address'];
    $data['link_logo']=$_GPC['link_logo'];
    $data['link_name']=$_GPC['link_name'];
    $data['mail']=$_GPC['mail'];
    $data['pic']=$_GPC['pic'];
    //$data['fontcolor']=$_GPC['fontcolor'];

    $data['tech_title']=$_GPC['tech_title'];
    $data['tech_phone']=$_GPC['tech_phone'];
    $data['tech_img']=$_GPC['tech_img'];
	$data['goodspicbg']=$_GPC['goodspicbg'];
    $data['is_show_tech']=$_GPC['is_show_tech'];
	$data['is_show_tel']=$_GPC['is_show_tel'];

    $data['showcheck']=$_GPC['showcheck'];
	$data['ispnumber']=$_GPC['ispnumber'];
    $data['version']=$_GPC['version'];
    $data['wxappletscode']=$_GPC['wxappletscode'];
    $data['loginimg']=$_GPC['loginimg'];
	if($scoretaskplugin==1){
		$data['money_rate'] = $_GPC['money_rate'];
		$data['score_rate'] = $_GPC['score_rate'];
	}

    /*if($_GPC['color']){
        $data['color']=$_GPC['color'];
    }else{
        $data['color']="#ED414A";
    }*/

    if($_GPC['id']==''){ 
        $res=pdo_insert('mzhk_sun_system',$data);
        if($res){
            message('添加成功',$this->createWebUrl('settings',array()),'success');
        }else{
            message('添加失败','','error');
        }
    }else{
        $res = pdo_update('mzhk_sun_system', $data, array('id' => $_GPC['id']));
        if($res){
            message('编辑成功',$this->createWebUrl('settings',array()),'success');
        }else{
            message('编辑失败','','error');
        }
    }
}


include $this->template('web/settings');