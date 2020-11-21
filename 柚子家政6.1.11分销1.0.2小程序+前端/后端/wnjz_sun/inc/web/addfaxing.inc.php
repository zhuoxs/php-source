<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('wnjz_sun_hairers',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
		if(checksubmit('submit')){
		    if($_GPC['star']>5){
		        message('星级不能大于5！');
		        return;
            }
			$data['logo']=$_GPC['img'];
			$data['num']=$_GPC['num'];
			$data['hair_name']=$_GPC['hair_name'];
			$data['state']=$_GPC['state'];
			$data['cate']=$_GPC['cate'];
            $data['star']=$_GPC['star'];
            $data['life']=$_GPC['life'];
            $data['praise']=$_GPC['praise'];
			$data['uniacid']=$_W['uniacid'];
//			p($data);die;
			if($_GPC['id']==''){				
				$res=pdo_insert('wnjz_sun_hairers',$data);
				if($res){
					message('添加成功',$this->createWebUrl('faxingshi',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('wnjz_sun_hairers', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('faxingshi',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addfaxing');