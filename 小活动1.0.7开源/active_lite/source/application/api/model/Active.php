<?php

namespace app\api\model;

use app\common\model\Active as ActiveModel;

/**
 * 活动表模型
 * Class Active
 * @package app\api\model
 */
class Active extends ActiveModel
{
    protected $hidden = ['create_time', 'update_time'];

    /**
     * 我发布的活动列表
     * @param $user_id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function mylist($user_id)
    {
        return $this->with(['cover'])
            ->where(['user_id' => $user_id])
            ->order(['create_time' => 'desc'])
            ->select();
    }

    /**
     * 已报名活动列表
     * @param $user_id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function enlist($user_id)
    {
        $model = new ActiveEnroll;
        return $model->with(['active', 'active.cover'])
            ->where(['user_id' => $user_id])
            ->order(['create_time' => 'desc'])
            ->select();
    }

    /**
     * 添加活动
     * @param $data
     * @return bool|false|int
     */
    public function add($data)
    {
        $data['active_time'] = strtotime($data['active_date'] . ' ' . $data['active_time']);
        $data['people'] = 1;
        if (!$this->allowField(true)->save($data))
            return false;
        // 添加活动报名人
        $model = new ActiveEnroll;
        return $model->save([
            'active_id' => $this->active_id,
            'user_id' => $this->user_id,
            'wxapp_id' => $this->wxapp_id
        ]);
    }

    /**
     * 添加活动
     * @param $data
     * @return false|int
     */
    public function edit($data)
    {
        $data['active_time'] = strtotime($data['active_date'] . ' ' . $data['active_time']);
        return $this->allowField(true)->save($data);
    }

    /**
     * 活动报名
     * @param $user_id
     * @return false|int
     * @throws \think\Exception
     */
    public function joinIn($user_id)
    {
        // 更新报名表报名人数
        $this->setInc('people');
        // 添加报名记录
        return (new ActiveEnroll)->save([
            'active_id' => $this->active_id,
            'user_id' => $user_id,
            'wxapp_id' => $this->wxapp_id
        ]);
    }

    /**
     * 取消活动报名
     * @param $active_id
     * @param $user_id
     * @return int
     * @throws \think\Exception
     */
    public function joinOut($active_id, $user_id)
    {
        // 更新报名表报名人数
        $this->setDec('people');
        // 删除报名记录
        return (new ActiveEnroll)->where(compact('active_id', 'user_id'))->delete();
    }

    /**
     * 活动留言
     * @param $active_id
     * @param $user_id
     * @param $message
     * @return false|int
     */
    public function message($active_id, $user_id, $message)
    {
        $model = new ActiveEnroll;
        return $model->save(['message' => $message], compact('active_id', 'user_id'));
    }

}