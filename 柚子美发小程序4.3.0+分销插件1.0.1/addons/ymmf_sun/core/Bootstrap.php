<?php
// +----------------------------------------------------------------------
// | 微擎模块
// +----------------------------------------------------------------------
// | Copyright (c) 柚子黑卡  All rights reserved.
// +----------------------------------------------------------------------
// | Author: 淡蓝海寓
// +----------------------------------------------------------------------

namespace core;
// 记录内存初始使用
define('MEMORY_LIMIT_ON',function_exists('memory_get_usage'));

class Bootstrap{

    public static function run($name,$arguments){
        global $_GPC;
        $isWeb = stripos($name, 'doWeb') === 0; //web端
        $isMobile = stripos($name, 'doMobile') === 0; //手机端
        $isPage = stripos($name, 'doPage') === 0;  //小程序接口
        if($isWeb) {
            $dir = 'admin';
            $classname = strtolower(substr($name, 5));
        }
        if($isMobile) {
            $dir = 'mobile';
            $classname = strtolower(substr($name, 8));
        }
        if($isPage) {
            $dir = 'wxapp';
            $classname = strtolower(substr($name, 6));
        }

        $class = 'app\\'.$dir.'\\controller\\'.$classname.'Class';
        $action = isset($_GPC['act'])&&$_GPC['act']?$_GPC['act']:'index';

        if (class_exists($class)){
            $obj = new $class();
            $obj->$action();
        }else{
//            $file = __DIR__."/../inc/web/".$classname.".inc.php";
//            if(file_exists($file)){
//                echo "11";
//                require $file;//兼容inc
//            }elseif(method_exists($this,$name)){
//                $this->$name();//兼容本类
//            }else{
                exit('404');
//            }
        }
    }
}


