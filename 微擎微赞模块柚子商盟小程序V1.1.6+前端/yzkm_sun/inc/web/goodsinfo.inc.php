<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();

$where =" WHERE  a.uniacid=".$_W['uniacid'];
$info=pdo_get('yzkm_sun_goods',array('gid'=>$_GPC['gid'],'uniacid'=>$_W['uniacid']));
$sql = "SELECT a.*,b.tname FROM".tablename('yzkm_sun_goods')."a left join ".tablename('yzkm_sun_selectedtype')."b on a.cid=b.tid ".$where;
$list= pdo_fetchall($sql);

// 选择规格
$where1 =" WHERE  uniacid=".$_W['uniacid'];
$sql1 = "SELECT * FROM".tablename('yzkm_sun_specifications').$where1;
$list1= pdo_fetchall($sql1);   

// 选择门店
$where2 =" WHERE  uniacid=".$_W['uniacid'];
$sql2 = "SELECT * FROM".tablename('yzkm_sun_store').$where2;
$list2= pdo_fetchall($sql2);//商家门店选择



// 查找编辑前的行业类别
// 根据gid查找商家id并根据商家的行业id查找对应的行业列表的行业名称
  $where3 =" WHERE  a.uniacid=".$_W['uniacid']  .  " and "   .  "a.gid=".$_GPC['gid'];
 $sql3 ="select b.store_name from " . tablename("yzkm_sun_goods")."a ". "left join".tablename("yzkm_sun_store")."b on a.sid=b.id ".$where3;          
  $list3=pdo_fetchall($sql3);

// 查找编辑前的行业规格
// 根据gid查找商家id并根据商家的行业id查找对应的规格
  $where4 =" WHERE  a.uniacid=".$_W['uniacid']  .  " and "   .  "a.gid=".$_GPC['gid'];
 $sql4 ="select b.gg_name from " . tablename("yzkm_sun_goods")."a ". "left join".tablename("yzkm_sun_specifications")."b on b.id=a.specifications_id".$where4;          
  $list4=pdo_fetchall($sql4);  

// p($list3);
// p($sql4);
// p($list4);die;




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
            if($_GPC['gname']==null){
                // if($_GPC['gname']==null) {
                    message('请您写完整商品名称', '', 'error');
                // }
            }elseif(empty($_GPC['store_id'])){  
				message('商家门店不能为空','','error');
			}elseif($_GPC['freight']==null){
				message('商品运费不能为空','','error');
			}elseif($_GPC['shopprice']==null){
				message('商品售价不能为空','','error');
			}elseif($_GPC['shopprice']<0.01){
				message('商品售价要大于0.01','','error');
			}elseif($_GPC['freight']>$_GPC['shopprice']){  
                message('运费价格不能高于售价','','error');die;
            }elseif($_GPC['survey']==null){
                message('请您写完整商品简介','','error');

            }elseif($_GPC['content']==null){
				message('详情不能为空','','error');
			}elseif($_GPC['pic']==null){
                message('请您写上传图片','','error');die;
            }elseif($_GPC['specifications_id']==''){  
                message('商品规格不能为空','','error');die;
            }




 
			
            $data['uniacid']=$_W['uniacid'];
			$data['gname']=$_GPC['gname'];
	       	$data['content']=html_entity_decode($_GPC['content']);
	       	// p($data['content']);
			$data['sid']=$_GPC['store_id'];
			$data['marketprice']=$_GPC['goods_cost'];
			$data['shopprice']=$_GPC['shopprice'];
			$data['freight']=$_GPC['freight'];//运费
			$data['salesvolume']=$_GPC['salesvolume'];//销量
			$data['inventory'] = $_GPC['inventory'];//库存
			$data['status']=1;
			$data['cid']=$_GPC['storetype_id'];
			$data['specifications_id']=$_GPC['specifications_id'];
			// p($data['cid']);
			// p($_GPC);
			// p($_GPC['tid']);
			// die;
            $data['selftime']=date('Y-m-d H:i:s', time());
            $data['probably']=$_GPC['survey'];
            $data['pic'] = $_GPC['pic'];
            $data['banner']=implode(",",$_GPC['banner']);
            // $data['banner'] = $_GPC['banner'];
            
            // p($data);die;
            
			// if(empty($_GPC['id'])){
   //              $res = pdo_insert('yzkm_sun_goods', $data,array('uniacid'=>$_W['uniacid']));

   //              if($res){
   //                  message('添加成功',$this->createWebUrl('goods',array()),'success');
   //              }else{
   //                  message('添加失败','','error');
   //              }
   //          }else{

                $res = pdo_update('yzkm_sun_goods', $data, array('gid' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
				if($res){
					message('修改成功',$this->createWebUrl('goods',array()),'success');
				}else{
					message('修改失败','','error');
				}                
            // }

		}
include $this->template('web/goodsinfo');