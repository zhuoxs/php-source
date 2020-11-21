<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/13
 * Time: 11:43
 */
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
include $this->template('web/wxpages');