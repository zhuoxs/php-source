<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
	$info = pdo_get('yzkm_sun_post',array('uniacid' => $_W['uniacid'],'id'=>$_GPC['id']));
	$list = pdo_getall('yzkm_sun_post',array('uniacid' => $_W['uniacid']));
	// p($list);die;
		if(checksubmit('submit')){
			$data['post_img']=$_GPC['post_img'];//图片
			$data['post_name']=$_GPC['post_name'];//行业名称
			$data['type']=$_GPC['type'];//是否是激活状态
			$data['uniacid']=$_W['uniacid'];//版本

			if (empty($list)) {
					$res=pdo_insert('yzkm_sun_post',$data);
					if($res){
						message('添加成功',$this->createWebUrl('posttype',array()),'success');
					}else{
						message('添加失败','','error');
					}					
			}else{
					if($_GPC['id']==''){//判断是编辑还是添加
					foreach($list as $k=>$value) {
						
						if ($_GPC['post_name']!=$value['post_name']) {//判断是否已存在该行业类型
							// p($value['post_name']);
							$res=pdo_insert('yzkm_sun_post',$data);
							if($res){
								message('添加成功',$this->createWebUrl('posttype',array()),'success');
							}else{
								message('添加失败','','error');
							}				
						}else{
							message('该圈子分类已存在无需重复添加','','success');				
						}
					}
					}else{
						$data['type']=$_GPC['type'];
						$res = pdo_update('yzkm_sun_post',$data, array('id' => $_GPC['id'],'uniacid' => $_W['uniacid']));//这个id￥gpc里不存在
						if($res){
							message('编辑成功',$this->createWebUrl('posttype',array()),'success');
						}else{
							message('编辑失败','','error');
						}
					}
			}
		}
include $this->template('web/postadd');