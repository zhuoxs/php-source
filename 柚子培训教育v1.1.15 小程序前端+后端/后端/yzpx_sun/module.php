<?php

/**

 * -微圈小程序模块定义

 *

 * @author 

 * @url 

 */

defined('IN_IA') or exit('Access Denied');



class yzpx_sunModule extends WeModule {





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