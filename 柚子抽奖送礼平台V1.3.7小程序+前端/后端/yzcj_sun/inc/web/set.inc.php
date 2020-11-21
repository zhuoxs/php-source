<?php
global $_GPC, $_W;

$GLOBALS['frames'] = $this->getMainMenu();

   $list = pdo_get('yzcj_sun_system',array('uniacid'=>$_W['uniacid']));
        if(checksubmit('submit')){
           
            $data['is_sjrz']=$_GPC['is_sjrz'];
            $data['url_name']=$_GPC['url_name'];
            $data['is_open_pop']=$_GPC['is_open_pop'];
            $data['support']=$_GPC['support'];
            $data['cjzt']=$_GPC['cjzt'];
            $data['uniacid']=$_W['uniacid'];

            $data['paidprice']=$_GPC['paidprice'];
            $data['passwordprice']=$_GPC['passwordprice'];
            $data['growpprice']=$_GPC['growpprice'];
            $data['codeprice']=$_GPC['codeprice'];
            $data['oneprice']=$_GPC['oneprice'];
            $data['senior']=$_GPC['senior'];
            $data['instructions']=$_GPC['instructions'];
            

            if($_GPC['id']==''){
                $res=pdo_insert('yzcj_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('set',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzcj_sun_system', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
                if($res){
                    message('编辑成功',$this->createWebUrl('set',array()),'success');
                }else{
                message('编辑失败','','error');
                }
            }
        }

include $this->template('web/set');