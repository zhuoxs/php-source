<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class IndexController extends PluginMobilePage
{
	/**
     * @var PcModel
     */
	public $model;

	/**
     * 渲染模板界面
     * @return string|void
     * @throws \Twig\Error\SyntaxError
     * @author: Vencenty
     * @time: 2019/5/27 21:02
     */
	public function main()
	{
		global $_W;
		global $_GPC;
		$data = $this->model->getData('home');
		$data['layout'] = $this->model->getTemplateSetting();
		$info = m('common')->getSysset('shop');
		$data['title'] = empty($info['name']) ? '人人商城' : $info['name'];
		$data['seckill'] = plugin_run('seckill::getTaskSeckillInfo');

		if (isset($_GET['debug'])) {
			print_r($this->model->getTemplateGlobalVariables());
			exit();
		}

		return $this->view('index', $data);
	}

	public function debug()
	{
		$r = $this->model->getData('home');
	}

	public function seckill()
	{
		$seckill_list = $this->model->invoke('seckill.index::get_list', false);
		$currentSecKillActivity = $seckill_list['times'][$seckill_list['timeindex']];
	}

	/**
     * 全局变量
     * @author: Vencenty
     * @time: 2019/5/27 19:09
     */
	public function globalVariables()
	{
		$r = $this->model->getTemplateGlobalVariables();
		print_r($r);
		exit();
	}

	/**
     * 获取二维码
     */
	public function getCode()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		$url = mobileUrl($_GPC['url'], array('id' => $id), true);
		$qrcode = m('qrcode')->createQrcode($url);
		return json_encode(array('status' => 1, 'img' => $qrcode));
	}
}

?>
