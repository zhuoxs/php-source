<?php
global $_W, $_GPC;

$mid=intval($_GPC['mid']);

		$newdata = array(
			'isrz'=>1,			
			 );
		$res = pdo_update('bc_community_member', $newdata,array('mid'=>$mid));
		if (!empty($res)) {
			message('认证成功！', $this -> createWebUrl('member'), 'success');
		} else {
			message('认证失败！', $this -> createWebUrl('member'), 'error');
		}



?>