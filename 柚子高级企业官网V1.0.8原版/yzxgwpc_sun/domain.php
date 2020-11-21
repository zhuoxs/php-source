<?php
defined("IN_IA") or exit("Access Denied");
if (!defined("IN_MOBILE")) {
    $host = $_SERVER["HTTP_HOST"];
    $file = IA_ROOT . "/data/yzxgwpc_sun_domain/" . str_replace(".", "_", $host) . ".php";
    $domain = array();
    if(file_exists($file)) {
        @$domain = (include $file);
    }
    unset($file);
    if (@$domain["url"]) {
        header("Location:" . $domain["url"]);
    }
}