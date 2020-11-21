<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('yzcj_sun_system',array('uniacid'=>$_W['uniacid']));
// print_r($item);die;
    if(checksubmit('submit')){
        $data['pt_name']=$_GPC['pt_name'];
        $data['support_font']=$_GPC['support_font'];
        $data['support_logo']=$_GPC['support_logo'];
        $data['support_tel']=$_GPC['support_tel'];

        $data['bq_name']=$_GPC['bq_name'];   
        $data['bargain_title']=$_GPC['bargain_title'];   
        $data['bargain_price']=$_GPC['bargain_price'];   
            // $data['tel']=$_GPC['tel'];
          
            // $data['details']=html_entity_decode($_GPC['details']);
        $data['uniacid']=$_W['uniacid'];       
            // $data['address']=$_GPC['address'];
        $data['link_logo']=$_GPC['link_logo'];
        $data['auto_logo']=$_GPC['auto_logo'];
        $data['auto_logo1']=$_GPC['auto_logo1'];
        $data['manu_logo']=$_GPC['manu_logo'];
        $data['manu_logo1']=$_GPC['manu_logo1'];
        $data['gift_logo']=$_GPC['gift_logo'];
        $data['link_name']=$_GPC['link_name'];
        $data['cj_logo']=$_GPC['cj_logo'];
        $data['cj_name']=$_GPC['cj_name'];
        $data['dt_logo']=$_GPC['dt_logo'];
        $data['dt_name']=$_GPC['dt_name'];
        //     $data['mail']=$_GPC['mail'];
        //     $data['pic']=$_GPC['pic'];
        // $data['fontcolor']=$_GPC['fontcolor'];
            // if($_GPC['color']){


            //     $data['color']=$_GPC['color'];
            // }else{
            //     $data['color']="#ED414A";
            // }

            if($_GPC['id']==''){                
                $res=pdo_insert('yzcj_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('settings',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzcj_sun_system', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
                if($res){
                    message('编辑成功',$this->createWebUrl('settings',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/settings');