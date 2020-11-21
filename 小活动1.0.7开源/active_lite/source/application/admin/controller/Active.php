<?php

namespace app\admin\controller;

use app\common\model\Active as ActiveModel;
use app\common\model\Cover as CoverModel;

/**
 * 活动管理
 * Class Active
 * @package app\admin\controller
 */
class Active extends BaseController
{
    /**
     * 活动列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        // 当前小程序id
        $wxapp_id = $this->getWxAppId();
        // 会员列表
        $list = (new ActiveModel)->getList($wxapp_id);
        // 默认封面图
        $cover_default = (new CoverModel)->getCoverDefault();
        return $this->fetch('index', compact('list', 'cover_default'));
    }

    /**
     * 删除活动
     * @param $active_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($active_id)
    {
        // 活动信息
        if (!$model = ActiveModel::get(['active_id' => $active_id])) {
            return $this->renderError('没有该活动信息');
        }
        // 删除活动
        if (!$model->remove()) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

}
