<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
if(checksubmit('submit')){
    $data['gg_name']=$_GPC['gg_name'];
    $data['gg_class'] = $_GPC['gg_class'];
    $data['uniacid'] = $_W['uniacid'];

		if ($data['gg_name']==''||$data['gg_class']=='') {
				message('请完善输入框','','error');
		}else{
	        $res = pdo_insert('yzkm_sun_specifications', $data,array('uniacid'=>$_W['uniacid']));
	        if($res){
	            message('添加成功',$this->createWebUrl('goods',array()),'success');
	        }else{
	            message('添加失败','','error');
	        }
		}

		}
include $this->template('web/goodguige');