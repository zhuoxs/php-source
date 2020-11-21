<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//

//
$info=pdo_get('zhls_sun_legalknow',array('id'=>$_GPC['id']));

if($info['imgs']){
    $imgs = $info['imgs'];
}

if(checksubmit('submit')){
//    p($_GPC);die;
            $data['uniacid']=$_W['uniacid'];
            $data['content']=htmlspecialchars_decode($_GPC['content']);
            $data['imgs'] = $_GPC['imgs'];
            $data['law_name']=$_GPC['law_name'];
            $data['selftime']=time();
//            p($data);die;
			if(empty($_GPC['id'])){

                $res = pdo_insert('zhls_sun_legalknow', $data);
            }else{

                $res = pdo_update('zhls_sun_legalknow', $data, array('id' => $_GPC['id']));
            }
				if($res){
					message('编辑成功',$this->createWebUrl('legalknow',array()),'success');
				}else{
					message('编辑失败','','error');
				}
		}
include $this->template('web/legalknowinfo');