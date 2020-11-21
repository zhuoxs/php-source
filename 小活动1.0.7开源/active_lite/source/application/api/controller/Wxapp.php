<?php

namespace app\api\controller;

use app\common\model\Wxapp as WxappModel;

/**
 * 小程序管理
 * Class Wechat
 * @package app\api\controller
 */
class Wxapp extends BaseController
{
    /**
     * 小程序基础信息
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function base()
    {
        $wxapp = WxappModel::getWxappCache($this->wxapp_id);
        return $this->renderSuccess([
            'app_name' => $wxapp['app_name'],
            'description' => $wxapp['description'],
        ]);
    }

}
