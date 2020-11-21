<?php
/**
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2017/9/9
 * Time: 11:54
 */

namespace app\controllers;


use app\models\DataAcquisition;
use app\models\Option;
use yii\helpers\VarDumper;

class TestController extends \yii\web\Controller
{
    public function actionIndex()
    {
        var_dump(\Yii::$app->request->getIsSecureConnection());
        var_dump(\Yii::$app->request->isSecureConnection);
    }

    public function actionDaq()
    {
        DataAcquisition::getData('https://item.taobao.com/item.htm?spm=a219r.lm843.14.28.1693d45amvDAej&id=540274649359&ns=1&abbucket=12#detail');
    }

    public function actionUrl()
    {
        VarDumper::dump(\Yii::$app->request->getIsSecureConnection(), 2, 1);
        echo "<br>";
        VarDumper::dump(\Yii::$app->request->getHostInfo(), 2, 1);
        echo "<br>";
        VarDumper::dump($_SERVER, 2, 1);
        echo "<br>";
    }

    /**
     * 解析获取php.ini 的upload_max_filesize（单位：byte）
     * @param $dec int 小数位数
     * @return float （单位：byte）
     * */
    function get_upload_max_filesize_byte($dec = 2)
    {
        $max_size = ini_get('upload_max_filesize');
        preg_match('/(^[0-9\.]+)(\w+)/', $max_size, $info);
        $size = $info[1];
        $suffix = strtoupper($info[2]);
        $a = array_flip(array("B", "KB", "MB", "GB", "TB", "PB"));
        $b = array_flip(array("B", "K", "M", "G", "T", "P"));
        $pos = $a[$suffix] && $a[$suffix] !== 0 ? $a[$suffix] : $b[$suffix];
        return round($size * pow(1024, $pos), $dec);
    }

    public function actionOption()
    {
        Option::set('store_name', '我的商城', 1, '');
        Option::set('app_id', true, 1, '');
        Option::set('app_secret', 123, 1, '');
        Option::set('test', NULL, 1, '');
        $res = Option::getList('store_name,app_id,app_secret,test', 0, '', '');
        VarDumper::dump($res, 3, 1);
        VarDumper::dump(null, 3, 1);
    }

    public function actionVideo()
    {
        $url = "http://v.youku.com/v_show/id_XMjkwMzc0Njg4.html";
        $info = VideoUrlParser::parse($url);
        VarDumper::dump($info, 4, 1);
    }

    public function actionCache()
    {
        $key = 'TEST_CACHE';
        $val = '123';
        \Yii::$app->cache->set($key, $val, 1);
        sleep(3);
        VarDumper::dump(\Yii::$app->cache->get($key), 3, 1);
        var_dump(\Yii::$app->cache->get($key));
    }
}