<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$info=pdo_get('ymktv_sun_goods',array('id'=>$_GPC['id'],'uniacid' => $_W['uniacid']));

if(checksubmit('submit')){
            $data['goodsId'] = $_GPC['id'];
            $data['beginTime'] = $_GPC['beginTime'];
            $data['endTime'] = $_GPC['endTime'];
            $data['uniacid'] = $_W['uniacid'];
            $res = pdo_insert('ymktv_sun_teamwork',$data);
            if($res){
                message('编辑成功',$this->createWebUrl('teamwork',array()),'success');
            }else{
                message('编辑失败','','error');
            }
		}
include $this->template('web/teamworkinfo');