<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/8
 * Time: 15:27
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
include $this->template('web/test');