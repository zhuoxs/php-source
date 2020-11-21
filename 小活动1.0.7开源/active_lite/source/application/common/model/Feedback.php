<?php

namespace app\common\model;
use think\Request;

/**
 * 反馈建议表模型
 * Class Feedback
 * @package app\common\model
 */
class Feedback extends BaseModel
{
    protected $name = 'feedback';
    protected $updateTime = false;

    /**
     * 关联会员表
     */
    public function user()
    {
        return $this->belongsTo('user');
    }

    /**
     * 获取反馈列表
     * @param $wxapp_id
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($wxapp_id)
    {
        return $this->with(['user'])
            ->where(compact('wxapp_id'))
            ->order(['create_time' => 'desc'])
            ->paginate(15, false, ['query' => Request::instance()->request()]);
    }

    /**
     * 删除反馈
     */
    public function remove() {
        return $this->delete();
    }

}