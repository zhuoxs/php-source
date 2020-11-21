<?php
global $_W, $_GPC;
		$sid = $_GPC['sid'];
		$pid = $_GPC['pid'];
        if(!empty($_GPC['sceneid'])){
          pdo_delete("qrcode",array('uniacid'=>$_W['uniacid'],'qrcid'=>$_GPC['sceneid']));
        }
		pdo_delete($this->modulename."_share",array('id'=>$sid));
		pdo_update($this->modulename."_share",array('helpid'=>0),array('helpid'=>$sid));
        @unlink("../addons/tiger_newhu/qrcode/mposter{$sid}.jpg");
		message('删除成功！',$this->createWebUrl('share',array('pid'=>$pid,'status'=>$_GPC['status'])));