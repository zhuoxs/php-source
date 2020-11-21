<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('zhls_sun_mproblem',array('mid'=>$_GPC['mid']));
$law = pdo_getall('zhls_sun_lawyer',['uniacid'=>$_W['uniacid']]);

if(checksubmit('submit')){
    if($_W['ispost']){
        if(!$_GPC['answer']){
            message('请填写律师解答！');
        }else{
            $data['answer'] = $_GPC['answer'];
        }
        if($item['ls_id']){
            $_GPC['ls_id'] = $item['ls_id'];
        }
        if($_GPC['ls_id']==0){
            message('请选择解答的律师！');
        }else{
            $data['ls_id'] = $_GPC['ls_id'];
        }
        $data['is_answer'] = 1;
        $res = pdo_update('zhls_sun_mproblem',$data,array('mid'=>$_GPC['mid']));

        if($res){
            message('编辑成功！', $this->createWebUrl('ddgl'), 'success');
        }else{
            message('编辑失败！','','error');
        }
    }
}
include $this->template('web/ddglinfo');