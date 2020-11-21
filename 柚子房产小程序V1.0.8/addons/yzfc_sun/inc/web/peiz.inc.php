<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('yzfc_sun_system',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){

            $data['appid']=trim($_GPC['appid']);
            $data['appsecret']=trim($_GPC['appsecret']);

            $data['wxkey']=trim($_GPC['wxkey']);//腾讯地图申请网站
            $data['mchid']=trim($_GPC['mchid']);
            $data['map_key']=trim($_GPC['map_key']);
//            if($_GPC['gd_key']==''){
//                message('高德地图key不能为空!','','error');
//            }
//            if($_GPC['mapkey']==''){
//                message('腾讯地图key不能为空!','','error');
//            }
            if($_GPC['appid']==''){
                message('小程序appid不能为空!','','error');
            }
            if($_GPC['appsecret']==''){
                message('小程序appsecret不能为空!','','error');
            }
            $data['uniacid']=trim($_W['uniacid']);

            if($_GPC['id']==''){                
                $res=pdo_insert('yzfc_sun_system',$data,array('uniacid'=>$_W['uniacid']));
                if($res){
                    message('添加成功',$this->createWebUrl('peiz',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('yzfc_sun_system', $data, array('id' => $_GPC['id'],'uniacid'=>$_W['uniacid']));
                if($res){
                    message('编辑成功',$this->createWebUrl('peiz',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
    include $this->template('web/peiz');