<?php

namespace app\common\model;

/**
 * 活动报名记录模型
 * Class ActiveEnroll
 * @package app\common\model
 */
class ActiveEnroll extends BaseModel
{
    public $name = 'active_enroll';

    /**
     * 关联用户表
     * @return \think\model\relation\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('user');
    }

    /**
     * 关联活动表
     * @return \think\model\relation\BelongsTo
     */
    public function active()
    {
        return $this->belongsTo('active');
    }

}