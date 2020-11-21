<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require EWEI_SHOPV2_PLUGIN . 'merch/core/inc/page_merch.php';
class Cube_EweiShopV2Page extends MerchWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if ($_W['ispost']) {
			$imgs = $_GPC['cube_img'];
			$urls = $_GPC['cube_url'];
			$cubes = array();

			if (is_array($imgs)) {
				foreach ($imgs as $key => $img) {
					$cubes[] = array('img' => trim($img), 'url' => save_media($urls[$key]));
				}
			}

			$sets = $this->model->getSet();
			$sets['shop']['cubes'] = $cubes;
			$this->model->updateSet(array('shop' => $sets['shop']));
			mplog('shop.cube.edit', '修改基本设置');
			show_json(1);
		}

		$sets = $this->getSet();
		$cubes = isset($sets['shop']['cubes']) ? $sets['shop']['cubes'] : array();
		include $this->template();
	}
}

?>
