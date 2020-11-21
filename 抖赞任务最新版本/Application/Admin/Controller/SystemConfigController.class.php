<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
use Common\Model\SystemConfigModel;

/**
 * 系统设置
 */
class SystemConfigController extends AdminBaseController{
    /**
    +----------------------------------------------------------
     * 配置网站信息
    +----------------------------------------------------------
     */
    public function set() {
        if (IS_POST) {
            $_POST['zx_bfb_1'] =  $_POST['zx_bfb_1']/100;
            $_POST['zx_bfb_2'] =  $_POST['zx_bfb_2']/100;
            $_POST['fx_bfb'] =  $_POST['fx_bfb']/100;
            SystemConfigModel::set($_POST);
            $this->success('已更新');
        } else {
            $info = SystemConfigModel::get();
            $info['zx_bfb_1'] = $info['zx_bfb_1']*100;
            $info['zx_bfb_2'] = $info['zx_bfb_2']*100;
            $info['fx_bfb'] = $info['fx_bfb']*100;
            $this->assign('info',$info);
            $this->display();
        }
    }
}
