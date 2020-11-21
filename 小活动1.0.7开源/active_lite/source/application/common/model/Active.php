<?php

namespace app\common\model;

use think\Request;

/**
 * 活动表模型
 * Class Active
 * @package app\common\model
 */
class Active extends BaseModel
{
    public $name = 'active';

    protected $hidden = ['create_time', 'update_time'];

    /**
     * 关联会员表
     */
    public function user()
    {
        return $this->belongsTo('user');
    }

    /**
     * 关联活动封面表
     */
    public function cover()
    {
        return $this->belongsTo('cover')
            ->field(['cover_id', 'image'])->bind(['cover_image' => 'image']);
    }

    /**
     * 关联活动报名表
     * @return \think\model\relation\HasMany
     */
    public function enroll()
    {
        return $this->hasMany('ActiveEnroll')->order(['create_time']);
    }

    /**
     * 格式化活动时间
     * @param $name
     * @return array
     */
    public function getActiveTimeAttr($name)
    {
        return [
            'default' => $name,
            'active_date' => date('Y-m-d', $name),
            'active_date_show' => date('m/d', $name),
            'active_time' => date('H:i', $name),
        ];
    }

    /**
     * 获取活动详情
     * @param $wxapp_id
     * @param $active_id
     * @return array|false|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function detail($wxapp_id, $active_id)
    {
        return $this->with(['cover', 'user', 'enroll', 'enroll.user'])
            ->find(compact('wxapp_id', 'active_id'));
    }

    /**
     * 格式化活动详情
     * @param $detail
     * @param $user_id
     * @return mixed
     */
    public function format($detail, $user_id)
    {
        // 整理活动详情
        $active_time = $detail['active_time']['default'];
        $time = time();
        foreach ($detail['enroll'] as $key => $item) {
            $enroll_time = strtotime($item['create_time']);
            $detail['enroll'][$key]['enroll_date'] = date('m/d', $enroll_time);
            $detail['enroll'][$key]['enroll_time'] = date('H:i', $enroll_time);
            $detail['enroll'][$key]['overdue'] = intval($enroll_time <= $active_time && $active_time < $time);
        }
        // 当前用户是否已报名
        $detail['is_join'] = in_array($user_id, array_column($detail['enroll'], 'user_id'));
        return $detail;
    }

    /**
     * 删除活动
     * @return int
     */
    public function remove()
    {
        // 删除报名记录
        (new ActiveEnroll)->where(['active_id' => $this->active_id])->delete();
        return $this->delete();
    }

    /**
     * 获取活动列表
     * @param $wxapp_id
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($wxapp_id)
    {
        $request = Request::instance();
        $filter = ['wxapp_id' => $wxapp_id];
        return $this->with(['cover'])
            ->where($filter)
            ->order(['create_time' => 'desc', 'active_id' => 'desc'])
            ->paginate(15, false, ['query' => $request->request()]);
    }

}