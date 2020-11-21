<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
    $id=$_GPC['id'];
    $mid = $_GPC['mid'];
//    var_dump($id);die;
$ancontent = pdo_get('zhls_sun_mproblem',['uniacid'=>$_W['uniacid'],'mid'=>$mid]);

$info = pdo_get('zhls_sun_manswer',['uniacid'=>$_W['uniacid'],'id'=>$id]);
		if(checksubmit('submit')){
            $data['mpro_id']=$mid;
            $data['answers']=$_GPC['answers'];
			$data['uniacid']=$_W['uniacid'];
            $data['huifutime']=date('Y-m-d H:i:s',time());
			if($_GPC['id']==''){
				$res=pdo_insert('zhls_sun_manswer',$data);
				if($res){
					message('添加成功',$this->createWebUrl('mianddgl',array('mid'=>$mid)),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('zhls_sun_manswer', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('mianddgl',array('mid'=>$mid)),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addmianddgl');