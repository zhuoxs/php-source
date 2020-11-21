<?php
/**
 * 微信淘宝客群代理
 *
 * @author 说图谱源码源码社区
 * @url www.shuotupu.com
 */
defined('IN_IA') or exit('Access Denied');

class Tiger_wxdailiModuleReceiver extends WeModuleReceiver {
	public function receive() {
		$type = $this->message['type'];
		//这里定义此模块进行消息订阅时的, 消息到达以后的具体处理过程, 请查看微擎文档来编写你的代码
	}
}