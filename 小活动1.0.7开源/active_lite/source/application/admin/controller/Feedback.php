<?php

namespace app\admin\controller;

use app\common\model\Feedback as FeedbackModel;
use think\Request;

/**
 * 意见与反馈
 * Class Feedback
 * @package app\admin\controller
 */
class Feedback extends BaseController
{
    /**
     * 反馈列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        // 当前小程序id
        $wxapp_id = $this->getWxAppId();
        // 封面列表
        $list = (new FeedbackModel)->getList($wxapp_id);
        return $this->fetch('index', compact('list'));
    }

    /**
     * 删除封面分类
     * @param Request $request
     * @param $feedback_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete(Request $request, $feedback_id)
    {
        !$request->isAjax() && $this->error('非法请求');
        if (!$model = FeedbackModel::get($feedback_id)) {
            return $this->renderError('没有该封面分类信息');
        }
        if (!$model->remove()) {
            return $this->renderError('删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

}
