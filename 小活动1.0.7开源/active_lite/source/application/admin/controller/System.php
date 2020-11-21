<?php

namespace app\admin\controller;

use app\common\model\Wxapp;
use think\Cache;
use think\Request;

class System extends BaseController
{
    /**
     * 系统设置
     * @param Request $request
     * @return array|mixed
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function setting(Request $request)
    {
        // 获取小程序信息
        $wxapp_id = $this->getWxAppId();
        $wxapp = Wxapp::get($wxapp_id);
        // 更新数据
        if ($request->isPost()) {
            $post = $request->post('Wxapp/a');
            if ($wxapp->save($post) === false)
                return $this->renderError('更新失败');
            Cache::rm('wxapp_' . $wxapp_id);
            return $this->renderSuccess('更新成功');
        }
        return $this->fetch('setting', compact('wxapp'));
    }

}
