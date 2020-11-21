<?php
/**

 */

defined('IN_IA') or exit('Access Denied');



class Yzmdwsc_sunModule extends WeModule {





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