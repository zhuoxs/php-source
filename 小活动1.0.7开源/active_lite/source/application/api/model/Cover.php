<?php

namespace app\api\model;

use app\common\model\Cover as CoverModel;

/**
 * 封面记录表模型
 * Class Cover
 * @package app\common\model
 */
class Cover extends CoverModel
{
    /**
     * 根据封面分类分组查询所有封面图
     * @param $wxapp_id
     * @return false|\PDOStatement|string|\think\Collection|\think\Paginator
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getList($wxapp_id)
    {
        return (new CoverClass)->field(['class_id', 'class_name'])
            ->with(['cover'])
            ->where(['wxapp_id' => $wxapp_id])
            ->select();
    }

}