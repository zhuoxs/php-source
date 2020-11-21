<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('yzcj_sun_selectedtype',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));

		if(checksubmit('submit')){
            if($_GPC['tname']==null) {
                message('请您填写类名名称', '', 'error');
            }
            if($_GPC['img']==null) {
                message('请您上传分类图标', '', 'error');
            }
			$data['tname']=$_GPC['tname'];
			$data['img']=$_GPC['img'];
			$data['time']=date('Y-m-d H:i:s');

			$data['uniacid']=$_W['uniacid'];

			if($_GPC['id']==''){				
				$res=pdo_insert('yzcj_sun_selectedtype',$data,array('uniacid'=>$_W['uniacid']));
				if($res){
					message('添加成功',$this->createWebUrl('zxtype',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('yzcj_sun_selectedtype', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
				if($res){
					message('编辑成功',$this->createWebUrl('zxtype',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addzxtype');