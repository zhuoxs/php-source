<?php

namespace app\api\model;

use app\common\model\CoverClass as CoverClassModel;

/**
 * 封面分类模型
 * Class CoverClass
 * @package app\api\model
 */
class CoverClass extends CoverClassModel
{
    /**
     * 关联封面图模型
     */
    public function cover()
    {
        return $this->hasMany('cover', 'class_id')
            ->field(['cover_id', 'class_id', 'image', 'sort'])
            ->order(['sort' => 'asc', 'cover_id' => 'desc']);
    }

}