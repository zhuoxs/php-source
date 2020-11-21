<?php

/**

 * 吃货部落小程序模块定义

 *

 * @author sun

 * @url 

 */

defined('IN_IA') or exit('Access Denied');



class byjs_sunModule extends WeModule {





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