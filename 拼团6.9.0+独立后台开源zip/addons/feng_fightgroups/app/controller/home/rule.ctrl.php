<?php
defined('IN_IA') or exit('Access Denied');
$pagetitle = !empty($config['tginfo']['sname']) ? '拼团规则 - '.$config['tginfo']['sname'] : '拼团规则';
include wl_template('home/rule');
