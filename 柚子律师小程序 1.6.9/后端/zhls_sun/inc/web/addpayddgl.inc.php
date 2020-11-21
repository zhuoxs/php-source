<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
    $id=$_GPC['id'];
    $fid = $_GPC['fid'];
$ancontent = pdo_get('zhls_sun_fproblem',['uniacid'=>$_W['uniacid'],'fid'=>$fid]);

$info = pdo_get('zhls_sun_fanswer',['uniacid'=>$_W['uniacid'],'id'=>$id]);
		if(checksubmit('submit')){
            $data['fpro_id']=$fid;
            $data['answers']=$_GPC['answers'];
			$data['uniacid']=$_W['uniacid'];
            $data['huifutime']=date('Y-m-d H:i:s',time());
			if($_GPC['id']==''){
				$res=pdo_insert('zhls_sun_fanswer',$data);
				if($res){
					message('添加成功',$this->createWebUrl('payddgl',array('fid'=>$fid)),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('zhls_sun_fanswer', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('payddgl',array('fid'=>$fid)),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addpayddgl');