<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$branch_id = $_GPC['branch_id'];

$info=pdo_get('yzhd_sun_goods_meal',array('id'=>$_GPC['gid']));
//print_r($info);exit;

$info['meal_content'] = unserialize($info['meal_content']);
//$servies = pdo_getall('yzhd_sun_servies',array('uniacid'=>$_W['uniacid']));
//$category = pdo_getall('yzhd_sun_category',array('uniacid'=>$_W['uniacid'], 'branch_id' => $branch_id));

$store = pdo_get('yzhd_sun_branch',array('uniacid'=>$_W['uniacid'],'stutes'=>1,'id'=>$branch_id));

if(checksubmit('submit')){
            if(!$_GPC['branch_id']) {
                message('请选择所属商家', '', 'error');
            }
            if(empty($_GPC['goods_name'])) {
				message('套餐名称不能为空', '', 'error');
			}
//			if (empty($_GPC['goods_details'])) {
//				message('套餐详情不能为空', '', 'error');
//			}
			if (empty($_GPC['pic'])) {
				message('套餐图片不能为空', '', 'error');
			}

			if (empty($_GPC['original_price'])) {
				message('套餐原价不能为空', '', 'error');
			}
  		
  			if (! is_numeric($_GPC['original_price'])) {
				message('套餐原价错误', '', 'error');
			}

			if (empty($_GPC['current_price'])) {
				message('套餐现价不能为空', '', 'error');
			}
  
  			if (! is_numeric($_GPC['current_price'])) {
				message('套餐现价错误', '', 'error');
			}

			if (empty($_GPC['fans_price'])) {
				message('套餐粉丝价不能为空', '', 'error');
			}
  
  			if (! is_numeric($_GPC['fans_price'])) {
				message('套餐粉丝价错误', '', 'error');
			}
            if (empty($_GPC['start_time'])) {
                message('开始时间错误', '', 'error');
            }
  			if (empty($_GPC['expire_time'])) {
            	message('过期时间不能为空', '', 'error');
            }
            if($_GPC['start_time']>=$_GPC['expire_time']){
                message('开始时间不得大于结束时间');
            }
			if (empty($_GPC['desc'])) message('套餐内容不能为空', '', 'error');
            $data['sp_num'] = $_GPC['sp_num'];
			$data['goods_name'] = $_GPC['goods_name'];
			$data['pic'] = $_GPC['pic'];
			$data['original_price'] = $_GPC['original_price'];
			$data['current_price'] = $_GPC['current_price'];
			$data['fans_price'] = $_GPC['fans_price'];
			$data['state'] = 1;
			$data['create_time'] = time();
            $data['uniacid']=$_W['uniacid'];
			$data['branch_id'] = $_GPC['branch_id'];
            $data['goods_num'] = $_GPC['goods_num'];
            $data['fictitious_share'] = $_GPC['fictitious_share'];
            $data['start_time'] =strtotime($_GPC['start_time']);
            $data['expire_time'] = strtotime($_GPC['expire_time']);
            $data['xg_num'] = $_GPC['xg_num'] ? $_GPC['xg_num'] : 0;
            $data['desc'] = $_GPC['desc'];
            $data['explain'] = $_GPC['explain'];
			if(empty($_GPC['id'])){
                $res = pdo_insert('yzhd_sun_goods_meal', $data);

                if($res){
                    message('添加成功',$this->createWebUrl('goods_groups',array('branch_id'=>$_GPC['branch_id'])),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{

                $res = pdo_update('yzhd_sun_goods_meal', $data, array('id' => $_GPC['id'],'branch_id'=>$_GPC['branch_id']));
            }
				if($res){
					message('修改成功',$this->createWebUrl('goods_groups',array('branch_id'=>$_GPC['branch_id'])),'success');
				}else{
					message('修改失败','','error');
				}
		}

include $this->template('web/goods_groups_info');
