<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
 $item=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
// print_r($item);die;
    if(checksubmit('submit')){
            $data['uniacid']=$_W['uniacid'];       

            $data['index_yu']=$_GPC['index_yu'];
            $data['index_yu_deta']=$_GPC['index_yu_deta'];
            $data['index_fa']=$_GPC['index_fa'];
            $data['index_fa_deta']=$_GPC['index_fa_deta'];

            if($_GPC['id']==''){                
                $res=pdo_insert('zhls_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('indexfont',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('zhls_sun_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('indexfont',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/indexfont');