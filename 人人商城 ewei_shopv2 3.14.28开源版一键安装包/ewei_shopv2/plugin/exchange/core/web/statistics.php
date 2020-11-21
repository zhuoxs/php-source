<?php
if (!(defined('IN_IA'))) 
{
	exit('Access Denied');
}
class Statistics_EweiShopV2Page extends WebPage 
{
	public function main() 
	{
		global $_W;
		global $_GPC;
		include $this->template();
	}
	public function goods() 
	{
		global $_W;
		global $_GPC;
	}
	public function redpacket() 
	{
		global $_W;
		global $_GPC;
	}
	public function score() 
	{
		global $_W;
		global $_GPC;
	}
	public function balance() 
	{
		global $_W;
		global $_GPC;
	}
}
?>