<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('ymmf_sun_system',array('uniacid'=>$_W['uniacid']));
// print_r($item);die;
    if(checksubmit('submit')){
            $data['pt_name']=$_GPC['pt_name'];
            $data['tel']=$_GPC['tel'];
          
            $data['details']=html_entity_decode($_GPC['details']);
            $data['uniacid']=$_W['uniacid'];       
            $data['cityname']=$_GPC['cityname'];
            $data['link_name']=$_GPC['link_name'];
            $data['link_logo']=$_GPC['link_logo'];
            $data['fontcolor']=$_GPC['fontcolor'];
            $data['js_font']=$_GPC['js_font'];
            $data['js_logo']=$_GPC['js_logo'];
            $data['js_tel']=$_GPC['js_tel'];
            $data['user_background'] = $_GPC['user_background'];
            if($_GPC['color']){
                $data['color']=$_GPC['color'];
            }else{
                $data['color']="#ED414A";
            }

            $data['appionmoney']=$_GPC['appionmoney'];

            if($_GPC['id']==''){                
                $res=pdo_insert('ymmf_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('settings',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('ymmf_sun_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('settings',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/settings');