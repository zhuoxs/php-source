<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
//

//
$cate = pdo_getall('zhls_sun_category',array('uniacid'=>$_W['uniacid']),'','','cid ASC');
$info=pdo_get('zhls_sun_dynamics',array('id'=>$_GPC['id']));

if($info['imgs']){
    $imgs = $info['imgs'];
}

if(checksubmit('submit')){
//    p($_GPC);die;
    if($_GPC['cid']==0){
        message('请选择文章类别！');
    }else{
        $data['cid'] = $_GPC['cid'];
    }
            $data['uniacid']=$_W['uniacid'];
            $data['content']=htmlspecialchars_decode($_GPC['content']);
            $data['imgs'] = $_GPC['imgs'];
            $data['team_name']=$_GPC['team_name'];
            $data['selftime']=time();
//            p($data);die;
			if(empty($_GPC['id'])){

                $res = pdo_insert('zhls_sun_dynamics', $data);
            }else{

                $res = pdo_update('zhls_sun_dynamics', $data, array('id' => $_GPC['id']));
            }
				if($res){
					message('编辑成功',$this->createWebUrl('dynamics',array()),'success');
				}else{
					message('编辑失败','','error');
				}
		}
include $this->template('web/dynamicsinfo');