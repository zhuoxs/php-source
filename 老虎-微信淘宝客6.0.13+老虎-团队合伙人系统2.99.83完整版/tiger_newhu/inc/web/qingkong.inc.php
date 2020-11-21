<?php
	global $_W,$_GPC;   
		$weid = $_W['uniacid'];
        $pid=$_GPC['pid'];
        pdo_delete('qrcode', array('uniacid' => $weid));
        pdo_update($this->modulename . "_share", array('ticketid' =>'', 'url' =>'','updatetime'=>'','sceneid'=>''), array('weid' =>$weid));
		//if ($pid){
			$shares = pdo_fetchall('select id from '.tablename($this->modulename."_share")." where weid='{$weid}'");
			foreach ($shares as $value) {
				@unlink("../addons/tiger_newhu/qrcode/mposter{$value['id']}.jpg");
			}
			message ( '海报缓存清空成功！', $this->createWebUrl ( 'mposter' ) );
		//}
?>