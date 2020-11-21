<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('zhls_sun_lawyer',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
    $lawtype = pdo_getall('zhls_sun_lawtype',array('uniacid'=>$_W['uniacid'],'state'=>1));

	//获取腾讯地图key
$developkey=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']),array('qqkey'));
$key = $developkey['qqkey'];

		if(checksubmit('submit')){
		    if($_GPC['star']>5){
		        message('星级不能大于5！');
		        return;
            }
            if($_GPC['cate']==0){
                message('请选择律师类型！');
                return;
            }
            if(!$_GPC['lawyer_login']){
                message('请输入律师账号！');
                return;
            }
            if(!$_GPC['lawyer_password']){
                message('请输入密码！');
                return;
            }

			$data['logo']=$_GPC['img'];
			$data['num']=$_GPC['num'];
			$data['lawyers']=$_GPC['lawyers'];
			$data['state']=$_GPC['state'];
			$data['cate']=$_GPC['cate'];
            $data['star']=$_GPC['star'];
			$data['comment']=$_GPC['comment'];
            $data['life']=$_GPC['life'];
            $data['praise']=$_GPC['praise'];
			$data['uniacid']=$_W['uniacid'];
			$data['appoint'] = $_GPC['appoint'];
			$data['appmoney'] = $_GPC['appmoney'];
            $data['lawyer_ji'] = $_GPC['lawyer_ji'];
			$data['background'] = $_GPC['background'];
            $data['lawyer_login'] = $_GPC['lawyer_login'];
            $data['lawyer_password'] = $_GPC['lawyer_password'];
            $data['mobile'] = $_GPC['mobile'];
            $data['lawyer_details'] = htmlspecialchars_decode($_GPC['lawyer_details']);
            $data['province_id'] = $_GPC['province_id'];
            $data['city_id'] = $_GPC['city_id'];
            $data['county_id'] = $_GPC['county_id'];
            $data['lat'] = $_GPC['lat'];
            $data['lng'] = $_GPC['lng'];
            $data['address'] = $_GPC['address'];
//			if(!$data['appmoney']){
//			    message('请填写咨询金额!');
//            }
//			p($data);die;
			if($_GPC['id']==''){
                $result = pdo_get('zhls_sun_lawyer',array('uniacid'=>$_W['uniacid'],'lawyer_login'=>$_GPC['lawyer_login']));
                if($result){
                    message('该账号已存在！');
                    return;
                }
				$res=pdo_insert('zhls_sun_lawyer',$data);
				if($res){
					message('添加成功',$this->createWebUrl('faxingshi',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('zhls_sun_lawyer', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('faxingshi',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addfaxing');