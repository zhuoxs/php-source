<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();


//
$info=pdo_get('yzhd_sun_goods',array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
$servies = pdo_getall('yzhd_sun_servies',array('uniacid'=>$_W['uniacid']));
$category = pdo_getall('yzhd_sun_category',array('uniacid'=>$_W['uniacid']));
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
 // p($_GPC);die;
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
            $data['sid'] = $_GPC['sid'];
            $cate = pdo_get('yzhd_sun_category',array('uniacid'=>$_W['uniacid'],'cid'=>$_GPC['cid']));
            $data['cname'] = $cate['cname'];

			if(empty($_GPC['id'])){
                $res = pdo_insert('yzhd_sun_goods', $data,array('uniacid'=>$_W['uniacid']));

                if($res){
                    message('添加成功',$this->createWebUrl('goods',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{

                $res = pdo_update('yzhd_sun_goods', $data, array('gid' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
            }
				if($res){
					message('修改成功',$this->createWebUrl('goods',array()),'success');
				}else{
					message('修改失败','','error');
				}
		}
include $this->template('web/goodsinfo');