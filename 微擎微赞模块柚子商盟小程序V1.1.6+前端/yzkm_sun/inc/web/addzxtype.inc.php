<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('yzkm_sun_selectedtype',array('uniacid' => $_W['uniacid'],'tid'=>$_GPC['tid']));

		if(checksubmit('submit')){
            if($_GPC['tname']==null) {
                message('请您写文章类名名称', '', 'error');
            }
			$data['tname']=$_GPC['tname'];
			$data['time']=date('Y-m-d H:i:s');
			$data['sort']=0;
			$data['uniacid']=$_W['uniacid'];

			if($_GPC['id']==''){				
				$res=pdo_insert('yzkm_sun_selectedtype',$data,array('uniacid'=>$_W['uniacid']));
				if($res){
					message('添加成功',$this->createWebUrl('zxtype',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('yzkm_sun_selectedtype', $data, array('tid' => $_GPC['tid'],'uniacid'=>$_W['uniacid']));
				if($res){
					message('编辑成功',$this->createWebUrl('zxtype',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addzxtype');