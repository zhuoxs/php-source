<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('ymmf_sun_hairers',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
	// 获取分店数据
    $branch = pdo_getall('ymmf_sun_branch',array('uniacid'=>$_W['uniacid']));
    // 门店和技师关联数据
    $buildhair = pdo_get('ymmf_sun_buildhair',array('uniacid'=>$_W['uniacid'],'hair_id'=>$_GPC['id']));
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
			$data['appoint'] = $_GPC['appoint'];
			$data['appmoney'] = $_GPC['appmoney'];
			$data['background'] = $_GPC['background'];
			$data['account'] = $_GPC['account'];
			$data['password'] = $_GPC['password'];
            $data['mobile'] = $_GPC['mobile'];
			$data['yylogo'] = $_GPC['yylogo'];
            $data['addtime'] = time();
//			p($data);die;
			if($_GPC['id']==''){
			    $re = pdo_get('ymmf_sun_hairers',array('uniacid'=>$_W['uniacid'],'account'=>$_GPC['account']));
			    if($re){
			        message('该账号已存在！');
                }else{
                    $res=pdo_insert('ymmf_sun_hairers',$data);
                    $hair_id = pdo_insertid();
                    pdo_insert('ymmf_sun_buildhair',array('uniacid'=>$_W['uniacid'],'hair_id'=>$hair_id,'build_id'=>$_GPC['build_id']));
                    if($res){
                        message('添加成功',$this->createWebUrl('building',array()),'success');
                    }else{
                        message('添加失败','','error');
                    }
                }
			}else{
                $b = pdo_getall('ymmf_sun_hairers',array('uniacid'=>$_W['uniacid']));
                $c = [];
                foreach ($b as $k=>$v){
                    if($v['id']!=$_GPC['id']){
                        if($_GPC['account']==$v['account']){
                            $c[] = $v;
                        }
                    }
                }
                if(empty($c)){
                    $res = pdo_update('ymmf_sun_hairers', $data, array('id' => $_GPC['id']));
                    pdo_update('ymmf_sun_buildhair', array('build_id'=>$_GPC['build_id']), array('hair_id' => $_GPC['id']));
                }else{
                    message('该账号已存在！');
                }
				if($res){
					message('编辑成功',$this->createWebUrl('building',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addfaxing');