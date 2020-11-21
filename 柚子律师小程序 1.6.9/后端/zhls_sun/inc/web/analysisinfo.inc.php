<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//

//
$info=pdo_get('zhls_sun_category',array('cid'=>$_GPC['cid']));

if(checksubmit('submit')){
//    p($_GPC);die;
            $data['uniacid']=$_W['uniacid'];
            $data['cname']=$_GPC['cname'];
//            p($data);die;
			if(empty($_GPC['cid'])){

                $res = pdo_insert('zhls_sun_category', $data);
            }else{

                $res = pdo_update('zhls_sun_category', $data, array('cid' => $_GPC['cid']));
            }
				if($res){
					message('编辑成功',$this->createWebUrl('analysis',array()),'success');
				}else{
					message('编辑失败','','error');
				}
		}
include $this->template('web/analysisinfo');