<?php
class GoodsController extends PluginMobilePage
{
	public function detail()
	{
		global $_GPC;
		global $_W;
		$id = $_GPC['id'];

		if (!$this->model->checkGoodsExists($id)) {
			exit('浏览商品不存在');
		}

		$data = $this->model->invoke('goods::get_detail');
		array_unshift($data['goods']['thumbs'], $data['goods']['thumb']);
		require_once EWEI_SHOPV2_PATH . 'core/mobile/goods/picker.php';
		$pickerData = $this->model->invoke('goods::get_picker');

		if (!empty($data['goods']['packagegoods'])) {
			$_GPC['goodsid'] = $data['goods']['packagegoods']['goodsid'];
			$packages = $this->model->invoke('package::get_list');
			$data['packages'] = isset($packages['list']) ? $packages['list'] : NULL;
			array_walk($data['packages'], function(&$item) {
				$item['qrcode'] = m('qrcode')->createQrCode(mobileUrl('goods.package.detail', array('pid' => $item['id']), true));
			});
		}

		$data['specs'] = isset($pickerData['specs']) ? $pickerData['specs'] : NULL;
		$data['options'] = isset($pickerData['options']) ? $pickerData['options'] : NULL;
		$data['diyform'] = $pickerData['diyform'];
		$data['title'] = $data['goods']['title'];
		$comments = $this->model->invoke('goods::get_comments');
		$commentList = $this->model->invoke('goods::get_comment_list');
		$data['comment'] = array('count' => isset($comments['count']) ? $comments['count'] : NULL, 'list' => $commentList['list'], 'total' => $commentList['total'], 'page' => $commentList['page'], 'pagesize' => $commentList['pagesize']);
		$data['goods']['qrcode'] = m('qrcode')->createQrCode(mobileUrl('goods.detail', array('id' => $id), true));
		$data['goods']['breadcrumb'] = $this->model->getBreadcrumb($id);
		$data['goods']['footerMark'] = $this->model->getUserFooterMark($id);

		if (isset($_GPC['debug'])) {
			print_r($data);
			exit();
		}

		return $this->view('goods.detail', $data);
	}

	/**
     * 评论列表
     * @return mixed
     * @author: Vencenty
     * @time: 2019/5/30 14:12
     */
	public function comment_list()
	{
		return $this->model->invoke('goods::get_comment_list', false);
	}

	/**
     * 获取评论
     * @return mixed
     * @author: Vencenty
     * @time: 2019/6/5 14:30
     */
	public function comments()
	{
		return $this->model->invoke('goods::get_comments', false);
	}

	/**
     * 自定义表单加入购物车
     * @return mixed
     * @author: Vencenty
     * @time: 2019/6/5 14:30
     */
	public function addShopCartDiyForm()
	{
		return $this->model->invoke('order.create::diyform', false);
	}

	/**
     * 无自定义表单，普通加入购物车
     * @author: Vencenty
     * @time: 2019/6/11 9:09
     */
	public function addShopCart()
	{
		return $this->model->invoke('member.cart::add', false);
	}

	/**
     * 计算多规格商品价格
     * 目前接口已经废弃
     * @author: Vencenty
     * @time: 2019/5/31 19:59
     */
	public function calcSpecGoodsPrice()
	{
		global $_W;
		global $_GPC;
		$id = $_GPC['id'];
		$optionid = $_GPC['optionid'];
		sort($optionid);
		$optionid = implode('_', $optionid);
		$r = pdo_getall('ewei_shop_goods_option', array('goodsid' => $id));
		$specs = array_column($r, 'specs', 'id');
		array_walk($specs, function(&$value) {
			$tempValue = explode('_', $value);
			sort($tempValue);
			$value = implode('_', $tempValue);
		});
		$rowId = array_search($optionid, $specs);
		$findResult = array_filter($r, function($value) use($rowId) {
			return $value['id'] == $rowId;
		});
		return json_encode(current($findResult));
	}
}

?>
