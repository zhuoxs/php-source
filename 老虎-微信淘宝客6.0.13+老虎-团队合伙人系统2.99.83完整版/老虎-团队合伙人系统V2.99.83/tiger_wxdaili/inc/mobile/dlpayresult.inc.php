<?php
	global $_GPC, $_W;
	//file_put_contents(IA_ROOT."/addons/tiger_wxdaili/log.txt","\n dddo1ld:".json_encode($_GPC),FILE_APPEND); 
        //$share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$_GPC['uid']}'");
        $orderno = $_GPC['orderno'];
        $orderid = $_GPC['orderid'];
        $order = pdo_fetch("SELECT orderno FROM " . tablename($this->modulename."_order") . " WHERE id = '{$orderid}' ");
        $result = $this->dldealpayresult($order['orderno'],$_GPC);
        die(json_encode($result));
				
				
				
?>