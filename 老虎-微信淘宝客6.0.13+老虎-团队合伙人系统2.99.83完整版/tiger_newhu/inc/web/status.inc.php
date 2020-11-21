<?php
global $_W, $_GPC;
		$sid = $_GPC['sid'];
		$pid = $_GPC['pid'];
		if ($_GPC['status']){
			if (pdo_update($this->modulename."_share",array('status'=>0),array('id'=>$sid)) === false){
				message('恢复失败！');
			}else message('恢复成功！',$this->createWebUrl('share',array('pid'=>$pid,'status'=>1)));
		}else{
			if (pdo_update($this->modulename."_share",array('status'=>1),array('id'=>$sid)) === false){
				message('拉黑失败！');
			}else message('拉黑成功！',$this->createWebUrl('share',array('pid'=>$pid)));
		}