<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('yzhd_sun_system',array('uniacid'=>$_W['uniacid']));
// print_r($item);die;
    if(checksubmit('submit')){
        if($_GPC['dapai_type']=='大牌福利'){
            $data['dapai_type'] = 0;
        }else{
            $data['dapai_type'] = 1;
        }
        if($_GPC['color']==1){
            $data['color'] = '#000000';
        }else{
            $data['color'] = '#ffffff';
        }

			$data['fontcolor'] = $_GPC['fontcolor'];
			$data['link_name'] = $_GPC['link_name'];
			$data['link_logo'] = $_GPC['link_logo'];
			$data['support_font'] = $_GPC['support_font'];
            $data['support_tel'] = $_GPC['support_tel'];
            $data['uniacid']=$_W['uniacid'];

            if($_GPC['id']==''){                
                $res=pdo_insert('yzhd_sun_system',$data,array('uniacid'=>$_W['uniacid']));
                if($res){
                    message('添加成功',$this->createWebUrl('jibenxinxi',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzhd_sun_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('jibenxinxi',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/jibenxinxi');
