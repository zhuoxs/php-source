<?php
    //自定义模板处理，变量 函数 等等

    //检查入口是否非法访问
	defined('ENTRANCE') or exit('Access Denied');

	//自定义代码开始喽
	function get_time(){
		return date('Y-m-d H:i:s',time());
	}

	function get_weekday(){
        $weekarray = array("日","一","二","三","四","五","六");
        return "星期".$weekarray[date("w")];
    }

    /*
    for($i=1;$i<=9;$i++) {
        for($j=1;$j<=$i;$j++) {
            echo "$i*$j=".$i*$j .'&nbsp;&nbsp;';
        }
        echo "<br />";
    }
    */

?>