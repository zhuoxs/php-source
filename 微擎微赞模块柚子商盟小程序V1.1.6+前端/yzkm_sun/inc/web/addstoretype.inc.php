<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('yzkm_sun_selectedtype',array('uniacid' => $_W['uniacid'],'tid'=>$_GPC['tid']));
	$list = pdo_getall('yzkm_sun_selectedtype',array('uniacid' => $_W['uniacid']));
	// p($list);die;
		if(checksubmit('submit')){
			$data['img']=$_GPC['img'];//图片
			$data['sort']=$_GPC['sort'];//排序
			$data['tname']=$_GPC['tname'];//行业名称
			$data['type']=$_GPC['type'];//是否是激活状态
			$data['uniacid']=$_W['uniacid'];//版本

			if (empty($list)) {
					$res=pdo_insert('yzkm_sun_selectedtype',$data);
					if($res){
						message('添加成功',$this->createWebUrl('storetype',array()),'success');
					}else{
						message('添加失败','','error');
					}					
			}else{
					if($_GPC['tid']==''){//判断是编辑还是添加
					foreach($list as $k=>$value) {
						
						if ($_GPC['tname']!=$value['tname']) {//判断是否已存在该行业类型
							// p($value['tname']);
							$res=pdo_insert('yzkm_sun_selectedtype',$data);
							if($res){
								message('添加成功',$this->createWebUrl('storetype',array()),'success');
							}else{
								message('添加失败','','error');
							}				
						}else{
							message('该行业已存在无需重复添加','','success');				
						}
					}
					}else{
						$data['type']=$_GPC['type'];
						$res = pdo_update('yzkm_sun_selectedtype',$data, array('tid' => $_GPC['tid'],'uniacid' => $_W['uniacid']));//这个tid￥gpc里不存在
						if($res){
							message('编辑成功',$this->createWebUrl('storetype',array()),'success');
						}else{
							message('编辑失败','','error');
						}
					}
			}
		}
include $this->template('web/addstoretype');