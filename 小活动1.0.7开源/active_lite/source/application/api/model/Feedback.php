<?php

namespace app\api\model;

use app\common\model\Feedback as FeedbackModel;

/**
 * 意见和反馈模型
 * Class Feedback
 * @package app\api\model
 */
class Feedback extends FeedbackModel
{
    /**
     * 添加反馈记录
     * @param $wxapp_id
     * @param $user_id
     * @param $content
     * @return false|int
     */
    public function add($wxapp_id, $user_id, $content)
    {
        return $this->save(compact('wxapp_id', 'user_id', 'content'));
    }

}