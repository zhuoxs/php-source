<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Address_EweiShopV2Page extends AppMobilePage
{
	public function get_list()
	{
		global $_W;
		global $_GPC;

		if (empty($_W['openid'])) {
			return app_error(AppError::$ParamsError);
		}

		$limit = '';
		$page = intval($_GPC['page']);

		if (1 < $page) {
			$pindex = max(1, $page);
			$psize = 20;
			$limit = ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		}

		$condition = ' and openid=:openid and deleted=0 and  `uniacid` = :uniacid  ';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']);
		$sql = 'SELECT COUNT(*) FROM ' . tablename('ewei_shop_member_address') . (' where 1 ' . $condition);
		$total = pdo_fetchcolumn($sql, $params);
		$sql = 'SELECT * FROM ' . tablename('ewei_shop_member_address') . ' where 1 ' . $condition . ' ORDER BY `isdefault` DESC ' . $limit;
		$list = pdo_fetchall($sql, $params);
		return app_json(array('page' => $pindex, 'pagesize' => $psize, 'total' => $total, 'list' => $list));
	}

	public function get_detail()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$data = array();

		if (!empty($id)) {
			$address = pdo_fetch('select *  from ' . tablename('ewei_shop_member_address') . ' where id=:id and openid=:openid and uniacid=:uniacid limit 1 ', array(':id' => $id, ':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

			if (!empty($address)) {
				$address['areas'] = $address['province'] . ' ' . $address['city'] . ' ' . $address['area'];
				$data['detail'] = $address;
			}
		}

		$set = m('util')->get_area_config_set();
		$data['openstreet'] = !empty($set['address_street']) ? true : false;
		return app_json($data);
	}

	public function set_default()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$data = pdo_fetch('select id from ' . tablename('ewei_shop_member_address') . ' where id=:id and deleted=0 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $id));

		if (empty($data)) {
			return app_error(AppError::$AddressNotFound);
		}

		pdo_update('ewei_shop_member_address', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid']));
		pdo_update('ewei_shop_member_address', array('isdefault' => 1), array('id' => $id, 'uniacid' => $_W['uniacid'], 'openid' => $_W['openid']));
		return app_json();
	}

	public function submit()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$data = array();
		$data['address'] = trim($_GPC['address']);
		$data['realname'] = trim($_GPC['realname']);
		$data['mobile'] = trim($_GPC['mobile']);
		$data['province'] = trim($_GPC['province']);
		$data['city'] = trim($_GPC['city']);
		$data['area'] = trim($_GPC['area']);
		$data['street'] = trim($_GPC['street']);
		$data['openid'] = $_W['openid'];
		$data['uniacid'] = $_W['uniacid'];
		$data['datavalue'] = trim($_GPC['datavalue']);
		$data['streetdatavalue'] = trim($_GPC['streetdatavalue']);
		$post = $data;
		$post['id'] = $id;
		$post['is_from_wx'] = $_GPC['is_from_wx'];

		if ($this->is_repeated_address($post)) {
			return app_error(AppError::$ParamsError, '此地址已经添加过');
		}

		if (empty($data['address'])) {
			return app_error(AppError::$ParamsError, '详细地址为空');
		}

		if (empty($data['realname'])) {
			return app_error(AppError::$ParamsError, '收件人姓名为空');
		}

		if (empty($data['mobile'])) {
			return app_error(AppError::$ParamsError, '收件人手机为空');
		}

		if (empty($data['province'])) {
			return app_error(AppError::$ParamsError, '收件省份为空');
		}

		if (empty($data['city'])) {
			return app_error(AppError::$ParamsError, '收件城市为空');
		}

		if (empty($data['area'])) {
			return app_error(AppError::$ParamsError, '收件区域为空');
		}

		$set = m('util')->get_area_config_set();
		if (!empty($set['address_street']) && (empty($data['datavalue']) && empty($_GPC['is_from_wx']))) {
			return app_error(AppError::$ParamsError, '地址数据出错，请重新选择');
		}

		if (empty($id)) {
			$addresscount = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('ewei_shop_member_address') . ' where openid=:openid and deleted=0 and `uniacid` = :uniacid ', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

			if ($addresscount <= 0) {
				$data['isdefault'] = 1;
			}

			pdo_insert('ewei_shop_member_address', $data);
			$id = pdo_insertid();
		}
		else {
			$data['lng'] = '';
			$data['lat'] = '';
			pdo_update('ewei_shop_member_address', $data, array('id' => $id, 'uniacid' => $_W['uniacid'], 'openid' => $_W['openid']));
		}

		return app_json(array('addressid' => $id));
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$data = pdo_fetch('select id,isdefault from ' . tablename('ewei_shop_member_address') . ' where  id=:id and openid=:openid and deleted=0 and uniacid=:uniacid  limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':id' => $id));

		if (empty($data)) {
			return app_error(AppError::$AddressNotFound);
		}

		pdo_update('ewei_shop_member_address', array('deleted' => 1), array('id' => $id));

		if ($data['isdefault'] == 1) {
			pdo_update('ewei_shop_member_address', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'id' => $id));
			$data2 = pdo_fetch('select id from ' . tablename('ewei_shop_member_address') . ' where openid=:openid and deleted=0 and uniacid=:uniacid order by id desc limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']));

			if (!empty($data2)) {
				pdo_update('ewei_shop_member_address', array('isdefault' => 1), array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid'], 'id' => $data2['id']));
				return app_json(array('defaultid' => $data2['id']));
			}
		}

		return app_json();
	}

	public function selector()
	{
		global $_W;
		global $_GPC;
		$condition = ' and openid=:openid and deleted=0 and  `uniacid` = :uniacid  ';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid']);
		$sql = 'SELECT id,realname,mobile,address,province,city,area,isdefault FROM ' . tablename('ewei_shop_member_address') . ' where 1 ' . $condition . ' ORDER BY isdefault desc, id DESC ';
		$list = pdo_fetchall($sql, $params);
		return app_json(array('list' => $list));
	}

	/**
     * 验证地址是否重复添加
     * @param $post
     * author 洋葱
     * @return bool
     */
	private function is_repeated_address($post)
	{
		global $_W;
		if (empty($post['is_from_wx']) || $post['id']) {
			return false;
		}

		if (empty($post['province']) || empty($post['city']) || empty($post['area'])) {
			return false;
		}

		$condition = 'uniacid=:uniacid and openid=:openid and realname=:realname and mobile=:mobile and mobile=:mobile and province=:province and city=:city and area=:area and address=:address and deleted=0';
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':realname' => $post['realname'], ':mobile' => $post['mobile'], ':province' => $post['province'], ':city' => $post['city'], ':area' => $post['area'], ':address' => $post['address']);
		$address = pdo_fetch('SELECT id FROM ' . tablename('ewei_shop_member_address') . (' where ' . $condition . ' limit 1'), $params);

		if ($address) {
			return true;
		}

		return false;
	}
}

?>
