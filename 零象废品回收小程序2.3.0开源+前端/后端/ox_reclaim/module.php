<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
define('MODEL_NAME','ox_reclaim');
require_once IA_ROOT . '/addons/'.MODEL_NAME.'/application/bootstrap.php';
class Ox_reclaimModule extends WeModule
{
    public function welcomeDisplay()
    {
        header('location: ' . webUrl());
        exit();
    }
}
?>