<?php
class PreviewController extends PluginMobilePage
{
	public function member()
	{
		return $this->view('preview.member.address');
	}

	public function register()
	{
		return $this->view('preview.member.register');
	}

	public function order_submit()
	{
		return $this->view('preview.order.submit');
	}

	public function order_list()
	{
		return $this->view('preview.order.list');
	}

	public function order_detail()
	{
		return $this->view('preview.order.detail');
	}

	public function goods_detail()
	{
		return $this->view('preview.goods.detail');
	}
}

?>
