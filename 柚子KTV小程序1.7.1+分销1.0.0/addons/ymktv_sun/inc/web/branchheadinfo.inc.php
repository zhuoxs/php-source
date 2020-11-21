<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('ymktv_sun_branchhead',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
	// 分店数据
    $build = pdo_getall('ymktv_sun_building',array('uniacid'=>$_W['uniacid']));
		if(checksubmit('submit')){
			$data['bh_name']=$_GPC['bh_name'];
            $data['account']=$_GPC['account'];
            $data['password']=$_GPC['password'];
            $data['mobile']=$_GPC['mobile'];
			$data['uniacid']=$_W['uniacid'];
			$data['b_id'] = $_GPC['b_id'];
			$data['addtime'] = time();


            $admin = pdo_get('ymktv_sun_business_account',array('uniacid'=>$_W['uniacid'],'account'=>$_GPC['account']));
            $servies = pdo_get('ymktv_sun_servies',array('uniacid'=>$_W['uniacid'],'login'=>$_GPC['account']));
            $branchhead = pdo_get('ymktv_sun_branchhead',array('uniacid'=>$_W['uniacid'],'account'=>$_GPC['account']));
			if($_GPC['id']==''){
			    if($admin || $servies || $branchhead){
			        message('该账号已存在！');
                }else{
                    $res=pdo_insert('ymktv_sun_branchhead',$data);
                }
				if($res){
					message('添加成功',$this->createWebUrl('branchhead',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
                $branch = pdo_getall('ymktv_sun_branchhead',array('uniacid'=>$_W['uniacid'],'account'=>$_GPC['account'],'id !='=>$_GPC['id']));
                if($branch){
                    message('该账号已存在！');
                }else{
                    if($admin || $servies){
                        message('该账号已存在！');
                    }else{
                        $res = pdo_update('ymktv_sun_branchhead', $data, array('id' => $_GPC['id']));
                    }
                }

				if($res){
					message('编辑成功',$this->createWebUrl('branchhead',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/branchheadinfo');