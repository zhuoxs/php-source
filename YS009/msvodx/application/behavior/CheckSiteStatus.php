<?php

namespace app\behavior;

use think\Request;

class CheckSiteStatus
{

    public function run(&$params){
        $this->checkSiteStatus();
    }

    public function checkSiteStatus()
    {
        $request=Request::instance();

        $baseConfig=get_config_by_group('base');

        if(isset($baseConfig['site_status']) && $baseConfig['site_status']==0 && !$request->isMobile()){
            header("location:/error/index.html");
            exit('siteClosed');
        }

        if(isset($baseConfig['wap_site_status']) && $baseConfig['wap_site_status']==0 && $request->isMobile()){
            header("location:/error/m.html");
            exit('wapClosed');
        }
    }

}