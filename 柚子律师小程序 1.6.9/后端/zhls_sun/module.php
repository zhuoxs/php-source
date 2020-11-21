<?php

/**

 * 小程序模块定义

 *

 * @author

 * @url http://www.lanrenzhijia.com/

 */

defined('IN_IA') or exit('Access Denied');



class zhls_sunModule extends WeModule {





	public function welcomeDisplay()

    {   
    	global $_GPC, $_W;

        $url = $this->createWebUrl('index');
        if ($_W['role'] == 'operator') {
        	$url = $this->createWebUrl('account');
        }

        Header("Location: " . $url);

    }

}