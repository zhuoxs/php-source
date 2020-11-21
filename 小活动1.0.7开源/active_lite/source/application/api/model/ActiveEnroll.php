<?php

namespace app\api\model;

use app\common\model\ActiveEnroll as ActiveEnrollModel;

/**
 * 活动报名记录模型
 * Class ActiveEnroll
 * @package app\api\model
 */
class ActiveEnroll extends ActiveEnrollModel
{
    protected $hidden = ['update_time'];

}