<?php

/**
* 活动基本信息
*/
class Poster
{
	private static $t_reply = 'n1ce_mission_reply';

	public function get($rid){
		$reply = pdo_fetch("select data,bg,more_bg,posttype,img_type,quality from " .tablename(self::$t_reply). " where rid = :rid",array(':rid'=>$rid));
		return $reply;
	}
}