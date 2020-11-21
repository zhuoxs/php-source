<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2018/1/18
 * Time: 17:07
 */

namespace app\behaviors;


class DoNotDoIt
{
    public static function doNotDoIt($only_routes)
    {
        $route = \Yii::$app->controller->route;
        if (is_array($only_routes)) {
            $in_array = false;
            foreach ($only_routes as $r) {
                if ($r == $route) {
                    $in_array = true;
                    break;
                }
                $r = str_replace('/', '\/', $r);
                $r = str_replace('*', '.*', $r);
                $r = "/^{$r}$/";
                preg_match($r, $route, $res);
                if (is_array($res) && count($res)) {
                    $in_array = true;
                    break;
                }
            }
            if ($in_array) {
                return false;
            } else {
                return true;
            }
        }
        return false;
    }
}