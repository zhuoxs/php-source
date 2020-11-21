<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzzc_sun_goods',array('id'=>$_GPC['id'],'uniacid'=>$_W['uniacid']));
if($info['subscribe_duration']){
	$info['subscribe_duration'] = explode(',',$info['subscribe_duration']);
	// $spec = pdo_getall('yzzc_sun_specprice',array('uniacid'=>$_W['uniacid'],'gid'=>$_GPC['id']),'','');
    $spec=pdo_fetchall('select * from '.tablename('yzzc_sun_specprice')." where uniacid =".$_W['uniacid']." and gid = ".$_GPC['id']." order by spec asc");

}

$nowshop=pdo_get('yzzc_sun_branch',array('id'=>$info['sid']),array('id','name'));
$cartype=pdo_getall('yzzc_sun_cartype',array('uniacid'=>$_W['uniacid']));
$shop=pdo_getall('yzzc_sun_branch',array('uniacid'=>$_W['uniacid']),array('id','name'));
$nowcartype=pdo_get('yzzc_sun_cartype',array('id'=>$info['cartype']),array('id','name'));

if(checksubmit('submit')){
//	 p($_GPC);die;
	if($_GPC['name']==null){
		message('请您车辆名称', '', 'error');
	}elseif($_GPC['carnum']==null){
        message('请您填写车牌号码','','error');
    }elseif($_GPC['carnum']==null){
		message('请您写完整汽车租金','','error');
	}elseif($_GPC['pic']==null){
		message('请您写上传图片','','error');die;
	}elseif($_GPC['sid']==null){
        message('请您先添加门店','','error');die;
    }
	$data['uniacid']=$_W['uniacid'];
	$data['sid']=$_GPC['sid'];
	$data['name']=$_GPC['name'];
	$data['carnum']=$_GPC['carnum'];
	$data['colour']=$_GPC['colour'];
	$data['structure']=$_GPC['structure'];
	$data['grarbox']=$_GPC['grarbox'];
	$data['displacement']=$_GPC['displacement'];
	$data['num'] = $_GPC['num'];
//	$data['moneytype'] = $_GPC['moneytype'];
	$data['money'] = $_GPC['money'];
	$data['act_money'] = $_GPC['act_money'];
	$data['cartype'] = $_GPC['cartype'];
	$data['content'] = $_GPC['content'];
	$data['fee'] = $_GPC['fee'];
	$data['service_fee'] = $_GPC['service_fee'];
	$data['zx_service_fee'] = $_GPC['zx_service_fee'];
	$data['hot'] = $_GPC['hot'];
	$data['rec'] = $_GPC['rec'];
	$data['pic'] = $_GPC['pic'];
	$data['createtime'] = date('Y-m-d H:i:s', time());
	if($_GPC['subscribe_duration']){
        $data['subscribe_duration'] = implode(',',$_GPC['subscribe_duration']);
    }
	if(empty($_GPC['id'])){
		$res = pdo_insert('yzzc_sun_goods', $data,array('uniacid'=>$_W['uniacid']));
		$gid = pdo_insertid();
		if($res){
			if($data['subscribe_duration']){
				$newData = [];
	            foreach ($_GPC['price'] as $k=>$v){
	                foreach ($_GPC['subscribe_duration'] as $kk=>$vv){
	                    if($k==$kk){
	                        $newData = [
	                            'gid'=>$gid,
	                            'price'=>$v,
	                            'spec'=>$vv,
	                            'uniacid'=>$_W['uniacid']
	                        ];
	                        if($newData['price']){
	                            pdo_insert('yzzc_sun_specprice',$newData);
								// message('添加成功',$this->createWebUrl('goods',array()),'success');
	                        }else{
	                            message('请输入对应活动价格！');
	                        }

	                    }
	                }
	            }
			}
			
		}
		
	}else{

		$res = pdo_update('yzzc_sun_goods', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
		if($res){
			if($data['subscribe_duration']){
				pdo_delete('yzzc_sun_specprice',array('uniacid'=>$_W['uniacid'],'gid'=>$_GPC['id']));
				$newData = [];
	            foreach ($_GPC['price'] as $k=>$v){
	                foreach ($_GPC['subscribe_duration'] as $kk=>$vv){
	                    if($k==$kk){
	                        $newData = [
	                            'gid'=>$_GPC['id'],
	                            'price'=>$v,
	                            'spec'=>$vv,
	                            'uniacid'=>$_W['uniacid']
	                        ];
	                        if($newData['price']){
	                            pdo_insert('yzzc_sun_specprice',$newData);
	                        }else{
	                            message('请输入对应活动价格！');
	                        }

	                    }
	                }
	            }
			}
		}
	}
	if($res){
		message('成功',$this->createWebUrl('goods',array()),'success');
	}else{
		message('失败','','error');
	}
}
include $this->template('web/goodsinfo');