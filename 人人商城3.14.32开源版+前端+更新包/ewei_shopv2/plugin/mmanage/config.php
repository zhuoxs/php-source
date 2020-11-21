<?php
/*
 * @ PHP 5.6
 * @ Decoder version : 1.0.0.1
 * @ Release on : 24.03.2018
 * @ Website    : http://EasyToYou.eu
 */

if (!defined("IN_IA")) {
    exit("Access Denied");
}
return array("version" => "1.0", "id" => "mmanage", "name" => "手机端管理", "v3" => true, "menu" => array("plugincom" => 1, "items" => array(array("title" => "基本设置", "route" => "setting"))));

?>