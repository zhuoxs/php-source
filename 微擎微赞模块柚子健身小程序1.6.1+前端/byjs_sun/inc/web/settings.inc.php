<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('byjs_sun_system',array('uniacid'=>$_W['uniacid']));
// print_r($item);die;
    if(checksubmit('submit')){
            $data['pt_name']=$_GPC['pt_name'];
            $data['tel']=$_GPC['tel'];
            $data['address']=$_GPC['address'];
            $data['details']=html_entity_decode($_GPC['details']);
            $data['uniacid']=$_W['uniacid'];
            $data['total_num']=$_GPC['total_num'];
            $data['link_name']=$_GPC['link_name'];
            $data['link_logo']=$_GPC['link_logo'];
            $data['fontcolor']=$_GPC['fontcolor'];
      		$data['yy_money']=$_GPC['yy_money'];
            if($_GPC['color']){
                $data['color']=$_GPC['color'];
            }else{
                $data['color']="#000000";
            }
            if($_GPC['sign']){
                $data['sign']=$_GPC['sign'];
            }else{
                $data['sign']="本店招牌";
            }
            if($_GPC['id']==''){                
                $res=pdo_insert('byjs_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('settings',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('byjs_sun_system', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
                if($res){
                    message('编辑成功',$this->createWebUrl('settings',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/settings');