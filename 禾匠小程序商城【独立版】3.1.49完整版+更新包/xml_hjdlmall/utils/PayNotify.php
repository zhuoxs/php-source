<?php
/**
 * @copyright ©2018 浙江禾匠信息科技
 * @author Lu Wei
 * @link http://www.zjhejiang.com/
 * Created by IntelliJ IDEA
 * Date Time: 2018/7/5 10:32
 */


namespace app\utils;

class PayNotify
{
    public static function getHostInfo()
    {
        $host_info = \Yii::$app->request->hostInfo;
        $protocol = env('PAY_NOTIFY_PROTOCOL', false);
        if ($protocol === 'http') {
            $host_info = str_replace('https:', 'http:', $host_info);
        }
        if ($protocol === 'https') {
            $host_info = str_replace('http:', 'https:', $host_info);
        }
        return $host_info;
    }
}
