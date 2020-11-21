<?php
/**
 * 村民信息录入模块处理程序
 *
 * @author peng
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Nxb_informationModuleReceiver extends WeModuleReceiver {
	public function receive() {
		$type = $this->message['type'];
		//这里定义此模块进行消息订阅时的, 消息到达以后的具体处理过程, 请查看微擎文档来编写你的代码
	}
}