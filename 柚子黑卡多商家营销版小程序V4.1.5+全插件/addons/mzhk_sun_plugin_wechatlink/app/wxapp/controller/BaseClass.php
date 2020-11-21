<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 柚子黑卡  All rights reserved.
// +----------------------------------------------------------------------
// | Author: 淡蓝海寓
// +----------------------------------------------------------------------

namespace app\wxapp\controller;

class BaseClass {

    public $modulename;
    public $uniacid;
    public $__define;
    public $navemenu;

    public function __construct(){
        global $_W, $_GPC;
        $this->modulename =  trim($_GPC['m']);
        $this->uniacid =  intval($_W['uniacid']);
        $this->__define =  IA_ROOT.'/addons/'.$this->modulename;
    }

    public function downloadImage($url, $path='mediaimg/'){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $file = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($httpCode == 404) {
            return false;
        }
        curl_close($ch);
        $this->saveAsImage($url, $file, $path);
        return pathinfo($url, PATHINFO_BASENAME);
    }

    private function saveAsImage($url, $file, $path){
        $filename = pathinfo($url, PATHINFO_BASENAME);
        $resource = fopen($path . $filename, 'a');
        fwrite($resource, $file);
        fclose($resource);
    }

}