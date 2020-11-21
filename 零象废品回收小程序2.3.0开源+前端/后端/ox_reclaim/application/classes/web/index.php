<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/20
 * Time: 15:12
 */
class Web_Index extends Web_Base
{
 	public function index(){
 		global $_W,$_GPC;
        $user_all = pdo_fetchcolumn("select count(*) from".tablename('ox_reclaim_member')." where uniacid=".$_W['uniacid']);
        $cycle_all = pdo_fetchcolumn("select count(*) from".tablename('ox_reclaim_order')." where uniacid=".$_W['uniacid']." and cycle > 0 AND `status` !=2" );
        $today_all = pdo_fetchcolumn("select count(*) from".tablename('ox_reclaim_order')." where uniacid=".$_W['uniacid']." and create_time >  " .strtotime(date('Y-m-d'),$_SERVER['REQUEST_TIME']));
        $account_all = pdo_fetchcolumn("select SUM(money) from".tablename('ox_reclaim_take_log')." where uniacid=".$_W['uniacid']." and create_time >  " .strtotime(date('Y-m-d'),$_SERVER['REQUEST_TIME']));
		include $this->template();
 	}

}