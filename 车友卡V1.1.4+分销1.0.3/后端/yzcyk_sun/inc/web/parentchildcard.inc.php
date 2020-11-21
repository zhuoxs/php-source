<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('yzcyk_sun_settings',array('uniacid'=>$_W['uniacid']));

    if(checksubmit('submit')){
            $data['uniacid']=$_W['uniacid'];
            $data['background']=$_GPC['background'];
            $data['kkxf_background']=$_GPC['kkxf_background'];
            $data['money']=$_GPC['money'];
            $data['old_price']=$_GPC['old_price'];
            $data['privilege']=htmlspecialchars_decode($_GPC['privilege']);
            $data['rule']=htmlspecialchars_decode($_GPC['rule']);
            $data['weblogo']=$_GPC['weblogo'];
            $data['bg']=$_GPC['bg'];

            if($_GPC['id']==''){                
                $res=pdo_insert('yzcyk_sun_settings',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('parentchildcard',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzcyk_sun_settings', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('parentchildcard',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
      }
include $this->template('web/parentchildcard');