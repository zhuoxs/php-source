<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();


//
$info=pdo_get('wnjz_sun_goods',array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
$servies = pdo_getall('wnjz_sun_servies',array('uniacid'=>$_W['uniacid']));
$category = pdo_getall('wnjz_sun_category',array('uniacid'=>$_W['uniacid']));

// 分店数据
$build = pdo_getall('wnjz_sun_branch',array('uniacid'=>$_W['uniacid']));
$cid = array();
foreach ($category as $k=>$v){
    if($v['pid']==0){
        $cid[] = $v['cid'];
    }
}

if($info['build_id']){
    $build_id = explode(',',$info['build_id']);
    if($info['sid']){
        $sid = explode(',',$info['sid']);
        $sids = [];
        foreach ($build_id as $k=>$v){
            foreach ($sid as $kk=>$vv){
                if($k==$kk){
                    $sids[$v]=$vv;
                }
            }
        }
    }
}


$cids = array();
foreach ($category as $k=>$v){
    foreach ($cid as $kk=>$vv){
        if($vv==$v['pid']){
            $cids[$vv][] = $v['cid'];
        }
    }
}
foreach ($cids as $k=>$v){
    if(!empty($cids[$k])){
        foreach ($category as $kk=>$vv){
            if($vv['cid']==$k){
                unset($category[$kk]);
            }
        }
    }
}

if($info['zs_imgs']){
			if(strpos($info['zs_imgs'],',')){
			$zs_imgs= explode(',',$info['zs_imgs']);
		}else{
			$zs_imgs=array(
				0=>$info['zs_imgs']
				);
		}
		}
if($info['lb_imgs']){
			if(strpos($info['lb_imgs'],',')){
			$lb_imgs= explode(',',$info['lb_imgs']);
		}else{
			$lb_imgs=array(
				0=>$info['lb_imgs']
				);
		}
		}

if(checksubmit('submit')){
            if($_GPC['goods_name']==null){
                if($_GPC['goods_name']==null) {
                    message('请您写完整家务名称', '', 'error');
                }
            }elseif($_GPC['goods_cost']==null){
				message('请您写完整家务价格','','error');
			}
            elseif($_GPC['goods_price']==null){
                message('请您写完整家务价格','','error');
            }elseif($_GPC['survey']==null){
                message('请您写完整家务详情','','error');

            }elseif($_GPC['pic']==null){
                message('请您写上传图片','','error');die;
            }
			elseif($_GPC['content']==null){
				message('详情不能为空','','error');
			}

            $data['uniacid']=$_W['uniacid'];
			$data['gname']=$_GPC['goods_name'];
	       $data['content']=html_entity_decode($_GPC['content']);
			$data['marketprice']=$_GPC['goods_cost'];
			$data['shopprice']=$_GPC['goods_price'];
			$data['status']=1;
			$data['cid']=$_GPC['cid'];
            $data['selftime']=date('Y-m-d H:i:s', time());
            $data['probably']=$_GPC['survey'];
            $data['pic'] = $_GPC['pic'];
            $data['sid'] = implode(',',$_GPC['sid']);
            $data['build_id'] = implode(',',$_GPC['build_id']);
            $data['lb_imgs'] = implode(',',$_GPC['lb_imgs']);
            $cate = pdo_get('wnjz_sun_category',array('uniacid'=>$_W['uniacid'],'cid'=>$_GPC['cid']));
            $data['cname'] = $cate['cname'];
            $data['index'] = $_GPC['index'];
			$data['canrefund'] = $_GPC['canrefund'];
            $data['startbuy'] = $_GPC['startbuy'];
            $data['endbuy'] = $_GPC['endbuy'];
			if(empty($_GPC['id'])){
                $res = pdo_insert('wnjz_sun_goods', $data,array('uniacid'=>$_W['uniacid']));

                if($res){
                    message('添加成功',$this->createWebUrl('goods',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{

                $res = pdo_update('wnjz_sun_goods', $data, array('gid' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
            }
				if($res){
					message('修改成功',$this->createWebUrl('goods',array()),'success');
				}else{
					message('修改失败','','error');
				}
		}
include $this->template('web/goodsinfo');