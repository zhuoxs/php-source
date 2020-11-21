<?php

namespace app\common\model;

use think\Request;

/**
 * 封面分类表模型
 * Class CoverClass
 * @package app\common\model
 */
class CoverClass extends BaseModel
{
    protected $name = 'cover_class';

    /**
     * 获取封面分类列表
     * @param $wxapp_id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getClassList($wxapp_id)
    {
        return $this->where(compact('wxapp_id'))
            ->order(['sort' => 'asc', 'class_id' => 'desc'])
            ->select();
    }

    /**
     * 添加封面
     * @param $wxapp_id
     * @return bool
     */
    public function add($wxapp_id)
    {
        // 封面数据
        $data = Request::instance()->post('CoverClass/a');
        $data['wxapp_id'] = $wxapp_id;
        return $this->save($data) !== false ? true : false;
    }

    /**
     * 更新封面
     * @param $wxapp_id
     * @return bool
     */
    public function edit($wxapp_id)
    {
        // 封面数据
        $data = Request::instance()->post('CoverClass/a');
        $data['wxapp_id'] = $wxapp_id;
        return $this->save($data) !== false ? true : false;
    }

    /**
     * 删除封面分类
     * @return bool|int
     * @throws \think\exception\DbException
     */
    public function remove()
    {
        // 验证分类下是否存在封面
        if (Cover::get(['class_id' => $this->class_id])) {
            return $this->error('该分类下存在封面图片，不允许删除');
        }
        return $this->delete();
    }

}