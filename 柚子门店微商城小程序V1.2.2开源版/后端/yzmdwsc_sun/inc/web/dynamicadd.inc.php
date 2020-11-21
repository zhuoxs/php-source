<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('yzmdwsc_sun_dynamic',array('uniacid'=>$_W['uniacid'],'id'=>$_GPC['id']));
$goods=pdo_getall('yzmdwsc_sun_goods',array('uniacid'=>$_W['uniacid'],'lid'=>array(1,2,4,5,6)));
if($info['imgs']){
			if(strpos($info['imgs'],',')){
			$imgs= explode(',',$info['imgs']);
		}else{
			$imgs=array(
				0=>$info['imgs']
				);
		}
}
if(checksubmit('submit')){
    
    if($_GPC['imgs']){
        $data['imgs']=implode(",",$_GPC['imgs']);
    }else{
        $data['imgs']='';
    }
            $system=pdo_get('yzmdwsc_sun_system',array('uniacid'=>$_W['uniacid']));
            $tab=pdo_get('yzmdwsc_sun_tab',array('uniacid'=>$_W['uniacid']));
            $data['uniacid']=$_W['uniacid'];
			$data['title']=$system['pt_name']; 
            $data['content']=$_GPC['content'];
            $data['add_time']=time();
            $data['gid']=$_GPC['gid'];
            $data['head_img']=$system['shopmsg_img'];
			if(empty($_GPC['id'])){
                if($tab['is_review']==2){
                  $data['is_status']=1; 
                }
                $res = pdo_insert('yzmdwsc_sun_dynamic', $data);
            }else{
                $res = pdo_update('yzmdwsc_sun_dynamic', $data, array('id' => $_GPC['id']));
            }
				if($res){
					message('编辑成功',$this->createWebUrl('dynamic',array()),'success');
				}else{
					message('编辑失败','','error');
				}
		}
include $this->template('web/dynamicadd');