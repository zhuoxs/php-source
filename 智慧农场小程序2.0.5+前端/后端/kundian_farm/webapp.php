<?php
defined('IN_IA') or exit('Access Denied');

class Kundian_farmModuleWebapp extends WeModuleWebapp {
	public function doPageWebapp() {
        global $_W;
        $data=pdo_getall('cqkundian_farm_webappset',array('uniacid'=>$_W['uniacid']));
        $list=array();
        foreach ($data as $key=>$value){
            $list[$value['ikey']]=$value['value'];
        }
        //查询轮播图
        $slideData=pdo_getall('cqkundian_farm_webapp_slide',array('uniacid'=>$_W['uniacid'],'status'=>1),'','','rank desc');
		include $this->template('index/index');
	}
}