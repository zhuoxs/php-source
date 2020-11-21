<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
    $id=$_GPC['id'];
    $pid = $_GPC['pid'];
//    var_dump($id);die;
$ancontent = pdo_get('zhls_sun_problem',['uniacid'=>$_W['uniacid'],'pid'=>$pid]);

$info = pdo_get('zhls_sun_answer',['uniacid'=>$_W['uniacid'],'id'=>$id]);
		if(checksubmit('submit')){
            $data['pro_id']=$pid;
            $data['question']=$_GPC['question'];
            $data['answers']=$_GPC['answers'];
			$data['uniacid']=$_W['uniacid'];
            $data['huifutime']=date('Y-m-d H:i:s',time());
			if($_GPC['id']==''){
				$res=pdo_insert('zhls_sun_answer',$data);
				if($res){
					message('添加成功',$this->createWebUrl('service',array('pid'=>$pid)),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('zhls_sun_answer', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('service',array('pid'=>$pid)),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addservice');