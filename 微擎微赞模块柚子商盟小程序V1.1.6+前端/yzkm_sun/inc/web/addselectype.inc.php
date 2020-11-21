<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('yzkm_sun_selectedtype',array('uniacid' => $_W['uniacid']));
	// $info = pdo_fetchall('yzkm_sun_selectedtype',array('uniacid' => $_W['uniacid'],'tid'=>$_GPC['id']));
	// p($_GPC['id']);die;
		if(checksubmit('submit')){
			$data['tname']=$_GPC['tname'];
			$data['img']=$_GPC['img'];
			$data['uniacid']=$_W['uniacid'];
				if ($_GPC['tname']!='') {
					if ($data['tname']!=$info['tname']) {
						$res=pdo_insert('yzkm_sun_selectedtype',$data);
							if($res){
								message('添加成功',$this->createWebUrl('addselectype',array()),'success');
							}else{
								
							}			
					}else{
							message('该行业已存在','','error');
					}

				}else{
					message('输入框不能为空',$this->createWebUrl('addselectype',array()),'error');
				}

		}
include $this->template('web/addselectype');