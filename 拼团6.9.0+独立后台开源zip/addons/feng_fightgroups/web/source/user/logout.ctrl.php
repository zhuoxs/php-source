<?php
defined('IN_IA') or exit('Access Denied');
isetcookie('___shop_session___', '', -10000);
@header('Location: '.wurl('user/login', array('shopid' => $_W['__shopid'])));