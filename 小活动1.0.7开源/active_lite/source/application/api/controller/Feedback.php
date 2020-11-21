<?php

namespace app\api\controller;

use app\common\model\Wxapp as WxappModel;
use app\api\model\Feedback as FeedbackModel;

/**
 * 意见和反馈
 * Class Feedback
 * @package app\api\controller
 */
class Feedback extends BaseController
{
    /**
     * 反馈说明
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function description()
    {
        $description = WxappModel::description($this->wxapp_id);
        return $this->renderSuccess(['description' => $description]);
    }

    /**
     * 添加用户反馈
     * @param $content
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function add($content)
    {
        // 用户信息
        $user = $this->getUser();
        // 新增活动记录
        $model = new FeedbackModel;
        if ($model->add($this->wxapp_id, $user->user_id, $content)) {
            return $this->renderSuccess([], '感谢您的反馈~');
        }
        return $this->renderError('反馈失败');
    }

}
