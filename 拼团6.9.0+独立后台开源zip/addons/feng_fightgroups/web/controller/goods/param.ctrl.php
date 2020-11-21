<?php
defined('IN_IA') or exit('Access Denied');

$tag = random(32);
global $_GPC;
load()->func('tpl');
include wl_template('goods/param');
