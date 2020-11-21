<?php

namespace app\common\model;

use app\common\exception\BaseException;
use think\Cache;

/**
 * 微信小程序表模型
 * Class Wxapp
 * @package app\common\model
 */
class Wxapp extends BaseModel
{
    protected $name = 'wxapp';

    /**
     * 从缓存中获取小程序信息
     * @param $wxapp_id
     * @return array|mixed
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public static function getWxappCache($wxapp_id)
    {
        if ($cache = Cache::get('wxapp_' . $wxapp_id))
            return $cache;
        if (!$wxapp = self::get($wxapp_id))
            throw new BaseException(['msg' => '未找到当前小程序信息']);
        Cache::set('wxapp_' . $wxapp_id, $wxapp->toArray());
        return $wxapp;
    }

    /**
     * 反馈说明
     * @param $wxapp_id
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public static function description($wxapp_id)
    {
        $wxapp = self::getWxappCache($wxapp_id);
        return $wxapp['description'];
    }

}