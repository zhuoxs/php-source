<?php

/**
 * Created by PhpStorm.
 * User: sunyaoyao
 * Date: 2016/1/7
 * Time: 17:20
 * 自动加载类库
 */
class Autoloader
{
    /**
     * @param string $class 对象类名
     * @return void
     */
    public static function autoload($class)
    {
        $name = $class;
        if (false !== strpos($name, '\\')) {
            $name = strstr($class, '\\', true);
        }

        $searchDirectoryList = array();
        $searchDirectoryList[] = 'nuomiopenplatform';
        $searchDirectoryList[] = 'nuomiopenplatform/requests';
        $searchDirectoryList[] = 'nuomiopenplatform/library';
        $searchDirectoryList[] = 'nuomiopenplatform/library/request';
        $searchDirectoryList[] = 'nuomiopenplatform/library/sign';


        foreach($searchDirectoryList as $dir){

            /**
             * 兼容性判断，没有办法使用__DIR__这个魔术变量在PHP5.3版本之前，要用dirname(__FILE__)替代
             */

            $filename =  sprintf("%s/%s/%s.php",dirname(__FILE__) , $dir,$name);

            if (is_file($filename)) {
                require_once $filename;
                return;
            }
        }
    }

}

spl_autoload_register('Autoloader::autoload');
?>