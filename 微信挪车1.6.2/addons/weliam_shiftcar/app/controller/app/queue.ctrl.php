<?php
defined('IN_IA') or exit('Access Denied');
//error_reporting(0);
set_time_limit(0);

$queue = new queue;
$queue -> queueMain();
