<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class DiyformModel extends PluginModel
{
	public $_data_type_config = array(0 => '单行文本', 1 => '多行文本', 2 => '下拉框', 3 => '多选框', 14 => '单选框', 5 => '图片', 6 => '身份证号码', 7 => '日期', 8 => '日期范围', 9 => '城市', 10 => '确认文本', 11 => '时间', 12 => '时间范围', 13 => '提示文本');
	public $_default_data_config = array('', '自定义', '姓名', '电话', '微信号');
	public $_default_date_config = array('', '填写当天', '特定日期');

	public function globalData()
	{
		global $_W;
		return array('data_type_config' => $this->_data_type_config, 'default_data_config' => $this->_default_data_config, 'default_date_config' => $this->_default_date_config, 'category' => pdo_fetchall('select * from ' . tablename('ewei_shop_diyform_category') . ' where uniacid=:uniacid order by id desc', array(':uniacid' => $_W['uniacid']), 'id'));
	}

	public function getInsertDataByAdmin()
	{
		global $_W;
		global $_GPC;
		$tp_type = $_GPC['tp_type'];
		$tp_name = $_GPC['tp_name'];
		$placeholder = $_GPC['placeholder'];
		$tp_is_default = $_GPC['tp_is_default'];
		$tp_default = $_GPC['tp_default'];
		$tp_must = $_GPC['tp_must'];
		$tp_text = $_GPC['tp_text'];
		$tp_max = $_GPC['tp_max'];
		$tp_name2 = $_GPC['tp_name2'];
		$tp_area = $_GPC['tp_area'];
		$default_time_type = $_GPC['default_time_type'];
		$default_time = $_GPC['default_time'];
		$default_btime_type = $_GPC['default_btime_type'];
		$default_btime = $_GPC['default_btime'];
		$default_etime_type = $_GPC['default_etime_type'];
		$default_etime = $_GPC['default_etime'];
		$m_pinyin = m('pinyin');

		if (!empty($tp_name)) {
			$data = array();
			$j = 0;

			foreach ($tp_name as $key => $val) {
				$i = $m_pinyin->getPinyin(trim($val), 'diy');

				if (array_key_exists($i, $data)) {
					$i .= $j;
					++$j;
				}

				$temp_tp_type = intval($tp_type[$key]);
				$data[$i]['data_type'] = trim($temp_tp_type);
				$data[$i]['tp_name'] = trim($val);
				$data[$i]['tp_must'] = intval(trim($tp_must[$key]));
				if ($temp_tp_type == 0 || $temp_tp_type == 1) {
					if ($temp_tp_type == 0) {
						$data[$i]['tp_is_default'] = trim($tp_is_default[$key]);

						if ($data[$i]['tp_is_default']) {
							$data[$i]['tp_default'] = trim($tp_default[$key]);

							switch ($data[$i]['tp_is_default']) {
							case 'diy':
								$data[$i]['tp_default'] = trim($tp_default[$key]);
								break;
							}
						}
					}

					$data[$i]['placeholder'] = trim($placeholder[$key]);
				}
				else {
					if ($temp_tp_type == 2 || $temp_tp_type == 3) {
						$text_array = explode('
', trim($tp_text[$key]));

						foreach ($text_array as $k => $v) {
							$text_array[$k] = trim($v);
						}

						$data[$i]['tp_text'] = $text_array;
					}
					else if ($temp_tp_type == 14) {
						$text_array = explode('
', trim($tp_text[$key]));

						foreach ($text_array as $k => $v) {
							$text_array[$k] = trim($v);
						}

						$data[$i]['tp_text'] = $text_array;
					}
					else if ($temp_tp_type == 5) {
						$data[$i]['tp_max'] = intval(trim($tp_max[$key]));
					}
					else if ($temp_tp_type == 7) {
						$data[$i]['default_time_type'] = intval($default_time_type[$key]);

						if ($data[$i]['default_time_type'] == 2) {
							$data[$i]['default_time'] = trim($default_time[$key]);
						}
					}
					else if ($temp_tp_type == 8) {
						$data[$i]['default_btime_type'] = intval($default_btime_type[$key]);
						$data[$i]['default_etime_type'] = intval($default_etime_type[$key]);

						if ($data[$i]['default_btime_type'] == 2) {
							$data[$i]['default_btime'] = trim($default_btime[$key]);
						}

						if ($data[$i]['default_etime_type'] == 2) {
							$data[$i]['default_etime'] = trim($default_etime[$key]);
						}
					}
					else if ($temp_tp_type == 9) {
						$data[$i]['tp_area'] = intval($tp_area[$key]);
					}
					else if ($temp_tp_type == 10) {
						$data[$i]['tp_name2'] = trim($tp_name2[$key]);
					}
					else {
						if ($temp_tp_type == 13) {
							$data[$i]['tp_text'] = trim($tp_text[$key]);
						}
					}
				}
			}
		}

		return $data;
	}

	public function getInsertData($fields, $memberdata, $array = false)
	{
		global $_W;
		$data = array();
		$m_data = array();
		$mc_data = array();

		foreach ($fields as $key => $value) {
			if ($array && isset($fields[0])) {
				$key = $value['diy_type'];
			}

			$data_type = $value['data_type'];

			if ($data_type == 0) {
				$data[$key] = trim($memberdata[$key]);

				if (!empty($data[$key])) {
					switch ($value['tp_is_default']) {
					case 2:
						$m_data['realname'] = $mc_data['realname'] = $data[$key];
						break;

					case 3:
						$m_data['mobile'] = $mc_data['mobile'] = $data[$key];
						break;

					case 4:
						$m_data['weixin'] = $data[$key];
						break;
					}
				}
			}
			else if ($data_type == 2) {
				$data[$key] = is_array($memberdata[$key]) ? $memberdata[$key][1] : $memberdata[$key];
			}
			else if ($data_type == 3) {
				if ($array && is_array($memberdata[$key])) {
					$newdata = array();

					foreach ($memberdata[$key] as $kk => $vv) {
						$newdata[] = $kk;
					}

					$memberdata[$key] = $newdata;
					unset($newdata);
				}

				$data[$key] = $memberdata[$key];
			}
			else if ($data_type == 5) {
				if (!$array) {
					$data[$key] = $memberdata[$key];
				}
				else {
					if (isset($memberdata[$key]['images']) && is_array($memberdata[$key]['images'])) {
						$newdata = array();

						foreach ($memberdata[$key]['images'] as $kk => $vv) {
							$newdata[] = $vv['filename'];
						}

						$data[$key] = $newdata;
					}
					else if (is_array($memberdata[$key])) {
						$data[$key] = $memberdata[$key];
					}
					else {
						$data[$key] = array();
					}
				}
			}
			else {
				if ($data_type == 6 || $data_type == 7 || $data_type == 11) {
					$data[$key] = trim($memberdata[$key]);
				}
				else {
					if ($data_type == 8 || $data_type == 12) {
						$data[$key] = array(trim($memberdata[$key][0]), trim($memberdata[$key][1]));
					}
					else if ($data_type == 9) {
						if ($array) {
							if (is_string($memberdata[$key])) {
								$areas = explode(' ', $memberdata[$key]);
								$data[$key]['province'] = $areas[0];
								$data[$key]['city'] = $areas[1];
								$data[$key]['area'] = $areas[2];
								$data[$key]['value'] = $areas[3];
							}
							else {
								$data[$key]['province'] = trim($memberdata[$key]['province']);
								$data[$key]['city'] = trim($memberdata[$key]['city']);
								$data[$key]['area'] = trim($memberdata[$key]['area']);
								$data[$key]['value'] = trim($memberdata[$key]['value']);
							}
						}
						else {
							$data[$key]['province'] = trim($memberdata[$key][0]);
							$data[$key]['city'] = trim($memberdata[$key][1]);
							$data[$key]['area'] = trim($memberdata[$key][2]);
							$data[$key]['value'] = trim($memberdata[$key][3]);
						}
					}
					else if ($data_type == 10) {
						if ($array) {
							@$data[$key] = array('name1' => trim($memberdata[$key]['name1']), 'name2' => trim($memberdata[$key]['name2']));
						}
						else {
							@$data[$key] = array('name1' => trim($memberdata[$key][0]), 'name2' => trim($memberdata[$key][1]));
						}
					}
					else if ($data_type == 13) {
					}
					else {
						$data[$key] = trim($memberdata[$key]);
					}
				}
			}
		}

		$insert_data['data'] = iserializer($data);
		$insert_data['m_data'] = $m_data;
		$insert_data['mc_data'] = $mc_data;
		return $insert_data;
	}

	public function getDiyformData($diyform_data, $fields, $member, $flag = 0, $last_flag = 0)
	{
		global $_W;

		if (!empty($diyform_data)) {
			if ($flag) {
				$f_data = iunserializer($diyform_data);
			}
			else {
				$f_data = $diyform_data;
			}

			if ($last_flag && is_array($f_data)) {
				foreach ($fields as $key => $value) {
					if (!array_key_exists($key, $f_data)) {
						$value['data_type'] = intval($value['data_type']);

						if ($value['data_type'] == 0) {
							switch ($value['tp_is_default']) {
							case 1:
								$f_data[$key] = $value['tp_default'];
								break;

							case 2:
								$f_data[$key] = $member['realname'];
								break;

							case 3:
								$f_data[$key] = $member['mobile'];
								break;

							case 4:
								$f_data[$key] = $member['weixin'];
								break;
							}
						}
						else if ($value['data_type'] == 7) {
							switch ($value['default_time_type']) {
							case 0:
								$f_data[$key] = '';
								break;

							case 1:
								$f_data[$key] = date('Y-m-d');
								break;

							case 2:
								$f_data[$key] = $value['default_time'];
								break;
							}
						}
						else if ($value['data_type'] == 8) {
							switch ($value['default_btime_type']) {
							case 0:
								$f_data[$key][0] = '';
								break;

							case 1:
								$f_data[$key][0] = date('Y-m-d');
								break;

							case 2:
								$f_data[$key][0] = $value['default_btime'];
								break;
							}

							switch ($value['default_etime_type']) {
							case 0:
								$f_data[$key][1] = '';
								break;

							case 1:
								$f_data[$key][1] = date('Y-m-d');
								break;

							case 2:
								$f_data[$key][1] = $value['default_etime'];
								break;
							}
						}
						else {
							$f_data[$key] = '';
						}
					}
					else {
						if ($value['data_type'] == 7) {
							switch ($value['default_time_type']) {
							case 1:
								$f_data[$key] = date('Y-m-d');
								break;

							case 2:
								$f_data[$key] = $value['default_time'];
								break;
							}
						}
					}
				}
			}
		}
		else {
			$f_data = array();

			foreach ($fields as $key => $value) {
				if ($value['data_type'] == 0) {
					switch ($value['tp_is_default']) {
					case 1:
						$f_data[$key] = $value['tp_default'];
						break;

					case 2:
						$f_data[$key] = $member['realname'];
						break;

					case 3:
						$f_data[$key] = $member['mobile'];
						break;

					case 4:
						$f_data[$key] = $member['weixin'];
						break;
					}
				}
				else if ($value['data_type'] == 7) {
					switch ($value['default_time_type']) {
					case 0:
						$f_data[$key] = '';
						break;

					case 1:
						$f_data[$key] = date('Y-m-d');
						break;

					case 2:
						$f_data[$key] = $value['default_time'];
						break;
					}
				}
				else if ($value['data_type'] == 8) {
					switch ($value['default_btime_type']) {
					case 0:
						$f_data[$key][0] = '';
						break;

					case 1:
						$f_data[$key][0] = date('Y-m-d');
						break;

					case 2:
						$f_data[$key][0] = $value['default_btime'];
						break;
					}

					switch ($value['default_etime_type']) {
					case 0:
						$f_data[$key][1] = '';
						break;

					case 1:
						$f_data[$key][1] = date('Y-m-d');
						break;

					case 2:
						$f_data[$key][1] = $value['default_etime'];
						break;
					}
				}
				else {
					$f_data[$key] = '';
				}
			}
		}

		return $f_data;
	}

	public function getFormatData($id, $fields, $member)
	{
		global $_W;

		if (!empty($id)) {
			$diyform_data = $this->getOneDiyformData($id);
		}

		$f_data = $this->getDiyformData($diyform_data, $fields, $member);
		return $f_data;
	}

	public function setGoodsLastData($type, $cid, $array, $openid)
	{
		global $_W;
		$change_data = array();
		$change_data['diyformid'] = $array['diyformid'];
		$change_data['diyformdata'] = $array['diyformdata'];
		$change_data['diyformfields'] = $array['diyformfields'];
		pdo_update('ewei_shop_diyform_temp', $change_data, array('cid' => $cid, 'uniacid' => $_W['uniacid'], 'openid' => $openid, 'type' => $type));
	}

	public function getLastData($type, $diymode, $diyformid, $cid, $fields, $member)
	{
		global $_W;

		if (!empty($cid)) {
			$table_name = 'ewei_shop_diyform_temp';
			$sql = 'select * from ' . tablename($table_name) . ' where cid=:cid and diyformid=:diyformid and uniacid=:uniacid and openid=:openid and type=:type order by id desc Limit 1';
			$params = array(':cid' => $cid, ':diyformid' => $diyformid, ':uniacid' => $_W['uniacid'], ':openid' => $member['openid'], ':type' => $type);
			$diyform_data = pdo_fetch($sql, $params);
			$DiyformInfo = $this->getDiyformInfo($diyformid, 0);
			$data = empty($DiyformInfo['savedata']) ? $diyform_data['diyformdata'] : '';

			if (empty($data)) {
				$table_name = 'ewei_shop_order_goods';
				$sql = 'select * from ' . tablename($table_name) . ' where id=:cid and diyformid=:diyformid and uniacid=:uniacid and openid=:openid order by id desc Limit 1';
				$params = array(':cid' => $cid, ':diyformid' => $diyformid, ':uniacid' => $_W['uniacid'], ':openid' => $member['openid']);
				$diyform_data = pdo_fetch($sql, $params);
				$data = $diyform_data['diyformdata'];
			}

			$f_data = $this->getDiyformData($data, $fields, $member, 1, 1);
		}

		return $f_data;
	}

	public function getLastCartData($goodsid = 0)
	{
		global $_W;
		$f_data = array();
		$cartdata = pdo_fetch('select * from ' . tablename('ewei_shop_member_cart') . ' where goodsid=:goodsid and openid=:openid order by id desc limit 1', array(':openid' => $_W['openid'], ':goodsid' => $goodsid));

		if (!empty($cartdata)) {
			$member = m('member')->getMember($_W['openid']);
			$f_data = $this->getDiyformData($cartdata['diyformdata'], iunserializer($cartdata['diyformfields']), $member, 1, 1);
		}

		return $f_data;
	}

	public function getLastOrderData($diyformid, $member)
	{
		global $_W;
		$f_data = array();

		if (!empty($diyformid)) {
			$DiyformInfo = $this->getDiyformInfo($diyformid, 0);

			if (empty($DiyformInfo['savedata'])) {
				$order = pdo_fetch('select diyformdata,diyformfields from ' . tablename('ewei_shop_order') . ' where diyformid=:diyformid and openid=:openid order by id desc limit 1', array(':diyformid' => $diyformid, ':openid' => $member['openid']));

				if (!empty($order)) {
					$f_data = $this->getDiyformData($order['diyformdata'], iunserializer($order['diyformfields']), $member, 1, 1);
				}
			}
		}

		return $f_data;
	}

	public function addDataNum($id)
	{
		global $_W;
		pdo_update('ewei_shop_diyform_type', 'alldata=alldata+1', array('id' => $id));
	}

	public function getCountData($typeid, $type = 0)
	{
		global $_W;
		$sql = 'select count(*) from ' . tablename('ewei_shop_diyform_data') . ' where typeid=:typeid and uniacid=:uniacid';
		$params = array(':typeid' => $typeid, ':uniacid' => $_W['uniacid']);

		if ($type) {
			$sql .= ' and type=:type';
			$params[':type'] = $type;
		}

		$datacount = pdo_fetchcolumn($sql, $params);
		return $datacount;
	}

	public function getGoodsTemp($goodsid, $diyformid, $openid, $type = 3)
	{
		global $_W;
		$sql = 'select * from ' . tablename('ewei_shop_diyform_temp') . ' where cid=:cid and diyformid=:diyformid and openid=:openid and type=:type and uniacid=:uniacid Limit 1';
		$params = array(':cid' => $goodsid, ':diyformid' => $diyformid, ':openid' => $openid, ':type' => $type, ':uniacid' => $_W['uniacid']);
		$data = pdo_fetch($sql, $params);

		if (!empty($data['savedata'])) {
			$data['diyformdata'] = '';
		}

		return $data;
	}

	public function getCountGoodsUsed($diyformid, $diyformtype = -1)
	{
		global $_W;
		$sql = 'select count(id) from ' . tablename('ewei_shop_goods') . ' where diyformid=:diyformid and uniacid=:uniacid';
		$params = array(':diyformid' => $diyformid, ':uniacid' => $_W['uniacid']);

		if ($diyformtype == -1) {
			$sql .= ' and diyformtype!=0';
		}
		else {
			if (0 <= $diyformtype) {
				$sql .= ' and diyformtype=:' . $diyformtype;
				$params[':diyformtype'] = $diyformtype;
			}
		}

		$datacount = pdo_fetchcolumn($sql, $params);
		return $datacount;
	}

	public function getDiyformList()
	{
		global $_W;
		$form_list = pdo_fetchall('select * from ' . tablename('ewei_shop_diyform_type') . ' where uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
		return $form_list;
	}

	public function getDiyformInfo($id, $flag = 1)
	{
		global $_W;
		$formInfo = pdo_fetch('select * from ' . tablename('ewei_shop_diyform_type') . ' where id=:id and uniacid=:uniacid Limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		if (!empty($formInfo) && $flag) {
			$formInfo['fields'] = iunserializer($formInfo['fields']);
		}

		return $formInfo;
	}

	public function getOneDiyformData($id, $flag = 1)
	{
		global $_W;
		$data = pdo_fetch('select * from ' . tablename('ewei_shop_diyform_data') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		if (!empty($data) && $flag) {
			$data['diyformfields'] = iunserializer($data['diyformfields']);
			$data['fields'] = iunserializer($data['fields']);
		}

		return $data;
	}

	public function getOneDiyformTemp($id, $flag = 1)
	{
		global $_W;
		$data = pdo_fetch('select * from ' . tablename('ewei_shop_diyform_temp') . ' where id=:id and uniacid=:uniacid Limit 1', array(':id' => $id, ':uniacid' => $_W['uniacid']));
		if (!empty($data) && $flag) {
			$data['diyformfields'] = iunserializer($data['diyformfields']);
			$data['diyformdata'] = iunserializer($data['diyformdata']);
		}

		return $data;
	}

	public function isHasDiyform($id)
	{
		global $_W;
		$sql = 'select count(1) from ' . tablename('ewei_shop_diyform_type') . ' where id=:id and uniacid=:uniacid';
		$params = array(':id' => $id, ':uniacid' => $_W['uniacid']);
		$diycount = pdo_fetchcolumn($sql, $params);
		return $diycount;
	}

	public function getDatas($fields, $data, $flag = 0)
	{
		$diyformfields = array();

		if (!is_array($fields)) {
			return $diyformfields;
		}

		foreach ($fields as $key => $value) {
			$tp_value = '';
			if ($value['data_type'] == 0 || $value['data_type'] == 1 || $value['data_type'] == 2 || $value['data_type'] == 6 || $value['data_type'] == 7 || $value['data_type'] == 11) {
				$tp_value = str_replace('
', '<br/>', $data[$key]);
			}
			else {
				if ($value['data_type'] == 3 || $value['data_type'] == 8 || $value['data_type'] == 12) {
					if (is_array($data[$key])) {
						foreach ($data[$key] as $k1 => $v1) {
							$tp_value .= $v1 . ' ';
						}
					}
				}
				else if ($value['data_type'] == 5) {
					if (is_array($data[$key])) {
						foreach ($data[$key] as $k1 => $v1) {
							$tp_value .= '<img style=\'height:25px;padding:1px;border:1px solid #ccc\'  src=\'' . tomedia($v1) . '\'/>';
						}
					}
				}
				else {
					if ($value['data_type'] == 9 && is_array($data[$key])) {
						$tp_value = ($data[$key]['province'] != '请选择省份' ? $data[$key]['province'] : '') . ' - ' . ($data[$key]['city'] != '请选择城市' ? $data[$key]['city'] : '');

						if (!empty($data[$key]['area'])) {
							$tp_value .= ' - ' . $data[$key]['area'];
						}
					}
					else {
						if ($value['data_type'] == 10 && is_array($data[$key])) {
							if (empty($flag)) {
								$tp_value = $data[$key]['name1'] . ' ' . $value['tp_name2'] . ':' . $data[$key]['name2'];
							}
							else {
								$tp_value = $data[$key]['name1'];
							}
						}
						else {
							if ($value['data_type'] == 14) {
								$tp_value = $data[$key];
							}
						}
					}
				}
			}

			$diyformfields[] = array('name' => $value['tp_name'], 'value' => $tp_value, 'key' => $key);
		}

		return $diyformfields;
	}

	public function getPostDatas($fields, $field_data_name = 'field_data')
	{
		global $_W;
		global $_GPC;
		$diyformfields = array();
		$key = 0;

		foreach ($fields as $field => $value) {
			$tp_value = '';
			if ($value['data_type'] == 0 || $value['data_type'] == 1 || $value['data_type'] == 2 || $value['data_type'] == 6 || $value['data_type'] == 7 || $value['data_type'] == 11) {
				$tp_value = trim($_GPC[$field_data_name . $key]);
				if (empty($tp_value) && $value['tp_must']) {
					return error(-1, '请填写' . $value['tp_name']);
				}
			}
			else if ($value['data_type'] == 3) {
				if (is_array($_GPC[$field_data_name . $key])) {
					foreach ($_GPC[$field_data_name . $key] as $k1 => $v1) {
						$tp_value[] = trim($v1);
					}
				}

				if (empty($tp_value) && $value['tp_must']) {
					return error(-1, '请选择' . $value['tp_name']);
				}
			}
			else if ($value['data_type'] == 5) {
				$tp_value = array();

				if (is_array($_GPC[$field_data_name . $key])) {
					$tp_value = $_GPC[$field_data_name . $key];
				}

				if (empty($tp_value) && $value['tp_must']) {
					return error(-1, '请选择' . $value['tp_name']);
				}
			}
			else {
				if ($value['data_type'] == 8 || $value['data_type'] == 12) {
					if (is_array($_GPC[$field_data_name . $key])) {
						foreach ($_GPC[$field_data_name . $key] as $k1 => $v1) {
							$tp_value[] = trim($v1);
						}
					}

					if (empty($tp_value) && $value['tp_must']) {
						return error(-1, '请选择' . $value['tp_name']);
					}
				}
				else if ($value['data_type'] == 9) {
					$tp_value = array();
					if ($_GPC[$field_data_name . '_province' . $key] != '请选择省份' && !empty($_GPC[$field_data_name . '_province' . $key])) {
						$tp_value['province'] = $_GPC[$field_data_name . '_province' . $key];
					}

					if ($_GPC[$field_data_name . '_city' . $key] != '请选择城市' && !empty($_GPC[$field_data_name . '_city' . $key])) {
						$tp_value['city'] = $_GPC[$field_data_name . '_city' . $key];
					}

					if ($_GPC[$field_data_name . '_area' . $key] != '请选择区域' && !empty($_GPC[$field_data_name . '_area' . $key])) {
						$tp_value['area'] = $_GPC[$field_data_name . '_area' . $key];
					}

					if ((!isset($tp_value['province']) || !isset($tp_value['city'])) && $value['tp_must']) {
						return error(-1, '请选择' . $value['tp_name']);
					}
				}
				else {
					if ($value['data_type'] == 14) {
						if (is_array($_GPC[$field_data_name . $key])) {
							foreach ($_GPC[$field_data_name . $key] as $k1 => $v1) {
								$tp_value .= trim($v1) . ' ';
							}
						}

						if (empty($tp_value) && $value['tp_must']) {
							return error(-1, '请选择' . $value['tp_name']);
						}
					}
				}
			}

			$diyformfields[$field] = $tp_value;
			++$key;
		}

		return $diyformfields;
	}

	public function wxApp($fields, $f_data, $member = array())
	{
		$newFields = array();
		if (empty($f_data) || !is_array($f_data)) {
			$f_data = array();
		}

		if (!empty($fields) && is_array($fields)) {
			foreach ($fields as $k => $v) {
				$v['diy_type'] = $k;

				if (empty($v['placeholder'])) {
					$v['placeholder'] = '请输入' . $v['tp_name'];
				}

				if ($v['data_type'] == 0) {
					switch ($v['tp_is_default']) {
					case 1:
						$f_data[$k] = $v['tp_default'];
						break;

					case 2:
						$f_data[$k] = $member['realname'];
						break;

					case 3:
						$f_data[$k] = $member['mobile'];
						break;

					case 4:
						$f_data[$k] = $member['weixin'];
						break;
					}
				}

				if ($v['data_type'] == 2) {
					if (empty($f_data[$k])) {
						$f_data[$k] = array(0, $v['tp_text'][0]);
					}
					else {
						$index = -1;

						foreach ($v['tp_text'] as $i => $val) {
							if ($val == $f_data[$k]) {
								$index = $i;
							}
						}

						if ($index < 0) {
							$f_data[$k] = array(0, $v['tp_text'][0]);
						}
						else {
							$f_data[$k] = array($index, $f_data[$k]);
						}
					}
				}
				else {
					if ($v['data_type'] == 3 && is_array($f_data[$k])) {
						$newdata = array();

						foreach ($f_data[$k] as $kk => $vv) {
							$newdata[$vv] = 1;
						}

						$f_data[$k] = $newdata;
						unset($newdata);
					}
					else if ($v['data_type'] == 5) {
						if (!empty($f_data[$k]) && is_array($f_data[$k])) {
							$newdata = array();

							foreach ($f_data[$k] as $kk => $vv) {
								$newdata[] = array('url' => tomedia($vv), 'filename' => $vv);
							}

							$f_data[$k] = array('images' => $newdata, 'count' => count($newdata));
						}
						else {
							$f_data[$k] = array(
								'images' => array(),
								'count'  => 0
							);
						}
					}
					else if ($v['data_type'] == 7) {
						switch ($v['default_time_type']) {
						case 0:
							$f_data[$k] = '';
							break;

						case 1:
							$f_data[$k] = date('Y-m-d');
							break;

						case 2:
							$f_data[$k] = $v['default_time'];
							break;
						}
					}
					else {
						if ($v['data_type'] == 8 && !is_array($f_data[$k])) {
							$f_data[$k] = array();

							switch ($v['default_btime_type']) {
							case 0:
								$f_data[$k][0] = '';
								break;

							case 1:
								$f_data[$k][0] = date('Y-m-d');
								break;

							case 2:
								$f_data[$k][0] = $v['default_btime'];
								break;
							}

							switch ($v['default_etime_type']) {
							case 0:
								$f_data[$k][1] = '';
								break;

							case 1:
								$f_data[$k][1] = date('Y-m-d');
								break;

							case 2:
								$f_data[$k][1] = $v['default_etime'];
								break;
							}
						}
						else {
							if ($v['data_type'] == 10 && (empty($f_data[$k]) || !is_array($f_data[$k]))) {
								$f_data[$k] = array('name1' => '', 'name2' => '');
							}
						}
					}
				}

				$newFields[] = $v;
			}
		}

		return array('fields' => $newFields, 'f_data' => array_filter($f_data));
	}

	public function getInsertFields($fields)
	{
		if (!is_array($fields)) {
			return array();
		}

		$newFields = array();

		foreach ($fields as $index => $field) {
			$newFields[$field['diy_type']] = $field;
			unset($newFields[$field['diy_type']]['diy_type']);
		}

		return iserializer($newFields);
	}
}

?>
