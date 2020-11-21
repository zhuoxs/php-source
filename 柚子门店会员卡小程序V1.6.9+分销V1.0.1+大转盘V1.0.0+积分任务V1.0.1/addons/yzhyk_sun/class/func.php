<?php
/*
*  各种函数
*  @淡蓝海寓
*/

/*
*判断字符串长度（）
*避免mb系列没有开启造成不能用，直接用正则计算长度
*$str     要计算长度的字符串
*/
function _strlen($str){
    preg_match_all("/./us", $str, $matches);
    return count(current($matches));
}

