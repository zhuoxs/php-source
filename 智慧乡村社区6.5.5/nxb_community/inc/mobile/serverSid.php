<?php
global $_W,$_GPC;
$config=$this->module['config'];
//载入ucpass类
require_once('Ucpaas.class.php');


//初始化必填
$options['accountsid']=$config['accountsid'];
$options['token']=$config['token'];
	
//初始化 $options必填
$ucpass = new Ucpaas($options);