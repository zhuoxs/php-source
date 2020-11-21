<?php  if( !defined("IN_IA") ) 
{
	exit( "Access Denied" );
}
return array( "version" => "1.0", "id" => "taobao", "name" => "淘宝助手", "v3" => true, "menu" => array( "plugincom" => 1, "items" => array( array( "title" => "淘宝助手" ), array( "title" => "京东助手", "route" => "jingdong" ), array( "title" => "1688助手", "route" => "one688" ), array( "title" => "淘宝CSV上传", "route" => "taobaocsv" ), array( "title" => "淘宝助手客户端", "route" => "set" ) ) ) );
?>