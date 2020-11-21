<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
// print_r($item);die;
    if(checksubmit('submit')){
            $data['uniacid']=$_W['uniacid'];       

            $data['zaixian']=$_GPC['zaixian'];
            $data['mianfei']=$_GPC['mianfei'];
            $data['fufei']=$_GPC['fufei'];
            $data['dianhua']=$_GPC['dianhua'];
            if($_GPC['color']){
                $data['color']=$_GPC['color'];
            }else{
                $data['color']="#ED414A";
            }

            $data['appionmoney']=$_GPC['appionmoney'];

            if($_GPC['id']==''){                
                $res=pdo_insert('zhls_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('indextu',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('zhls_sun_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('indextu',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/indextu');