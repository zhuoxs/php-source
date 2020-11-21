<?php
/**
 * Created by PhpStorm.
 * User: Zzf
 * Date: 2018/9/7 0007
 * Time: 下午 12:22
 */
exec("pwd",$output);
print_r($output);
$config = file('../../../data/config.php');
$host = '';
$username = '';
$password = '';
$port = '';
$database = '';
if (!empty($config))
{
    foreach ($config as $k => $v)
    {
        if (strpos($v, 'db') && strpos($v, 'master') && strpos($v, 'host'))
        {
            $arr = explode("'", $v);
            $host = $arr[count($arr) - 2];
        }
        if (strpos($v, 'db') && strpos($v, 'master') && strpos($v, 'username'))
        {
            $arr = explode("'", $v);
            $username = $arr[count($arr) - 2];
        }
        if (strpos($v, 'db') && strpos($v, 'master') && strpos($v, 'password'))
        {
            $arr = explode("'", $v);
            $password = $arr[count($arr) - 2];
        }
        if (strpos($v, 'db') && strpos($v, 'master') && strpos($v, 'port'))
        {
            $arr = explode("'", $v);
            $port = $arr[count($arr) - 2];
        }
        if (strpos($v, 'db') && strpos($v, 'master') && strpos($v, 'database'))
        {
            $arr = explode("'", $v);
            $database = $arr[count($arr) - 2];
        }
    }
}
