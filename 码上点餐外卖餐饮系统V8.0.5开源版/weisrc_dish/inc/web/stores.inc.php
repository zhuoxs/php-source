<?php
global $_W, $_GPC, $code;
$jump_url = $this->createWebUrl('stores2', array('op' => 'display'));
header("location:$jump_url");