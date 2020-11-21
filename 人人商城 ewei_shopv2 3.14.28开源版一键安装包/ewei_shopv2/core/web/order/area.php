<?php
//QQ63779278
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Area_EweiShopV2Page extends WebPage
{
	public function unicodeDecode($name)
	{
		$json = '{"str":"' . $name . '"}';
		$arr = json_decode($json, true);

		if (empty($arr)) {
			return '';
		}

		return $arr['str'];
	}

	public function main()
	{
		global $_W;
		print_r(123);
		exit();
		load()->func('communication');
		$url = 'https://g.alicdn.com/kg/??address/6.0.5/index-min.js?t=1469670241662.js';
		$response = ihttp_get($url);
		$content = $response['content'];
		$l1_array = array();
		$l2_array = array();
		$l3_array = array();
		$data = array();
		preg_match_all('/["[\\d]+",[^>]+(.*)[\\d]+"]/U', $content, $params1);

		if (!empty($params1[0])) {
			foreach ($params1[0] as &$row) {
				$response = preg_replace('/(\\[|\\]|\\")/', '', $row);
				$city_data = explode(',', $response);
				$code = $city_data[0];
				$name = $city_data[1];
				$pcode = $city_data[3];
				$data[$code]['code'] = $code;
				$data[$code]['status'] = 1;
				$data[$code]['level'] = 0;
				$data[$code]['pcode'] = $pcode;
				if ($pcode == 1 || $pcode == 2) {
					$l1_array[$code] = $name;
					$data[$code]['level'] = 1;
					$data[$code]['name'] = $name;
				}
				else if (2 < $pcode) {
					if (array_key_exists($pcode, $l1_array)) {
						$l2_array[$code] = $name;
						$data[$code]['level'] = 2;
						$data[$code]['name'] = $name;
					}
					else {
						if (array_key_exists($pcode, $l2_array)) {
							if (!array_key_exists($code, $l3_array)) {
								$l3_array[$code] = $name;
								$data[$code]['level'] = 3;
								$data[$code]['name'] = $name;
							}
						}
					}
				}
				else {
					$data[$code]['name'] = $name;
				}
			}
		}

		unset($row);

		foreach ($data as $k => $v) {
			if (!empty($v)) {
				pdo_insert('ewei_shop_city2', $v);
			}
		}

		print_r('OK');
		exit();
	}

	public function get_area($code)
	{
		global $_W;
		$params = array();
		$params[':code'] = $code;
		$sql = 'select * from ' . tablename('ewei_shop_city') . ' where  code=:code and status=1 Limit 1';
		$item = pdo_fetch($sql, $params);
		return $item;
	}

	public function add_area($l1, $l2, $l3)
	{
		global $_W;
		error_reporting(0);
		set_time_limit(0);
		load()->func('communication');
		$url = 'https://lsp.wuliu.taobao.com/locationservice/addr/output_address_town_array.do?l1=' . $l1 . '&l2=' . $l2 . '&l3=' . $l3 . '&lang=zh-S&_ksTS=1482116962514_7635&callback=jsonp7636&qq-pf-to=pcqq.group';
		$response = ihttp_get($url);
		$content = $response['content'];
		preg_match_all('/[\\\'[\\d]+\\\',[^>]+(.*)\\\']/U', $content, $params1);
		print_r($params1[0]);
		exit();
		$data = array();

		if (!empty($params1[0])) {
			foreach ($params1[0] as &$row) {
				$response = preg_replace('/(\\[|\\]|\')/', '', $row);
				$city_data = explode(',', $response);
				$code = $city_data[0];
				$name = $city_data[1];
				$pcode = $city_data[2];
				$words = $city_data[3];
				if (!empty($code) && !empty($name)) {
					$data[$code]['name'] = $name;
					$data[$code]['code'] = $code;
					$data[$code]['status'] = 1;
					$data[$code]['level'] = 4;
					$data[$code]['pcode'] = $pcode;
					$data[$code]['words'] = $words;
				}
			}
		}

		if (!empty($data)) {
			foreach ($data as $k => $v) {
				if (!empty($v)) {
					$item2 = $this->get_area($v['code']);

					if (empty($item2)) {
						pdo_insert('ewei_shop_city', $v);
					}
				}
			}
		}
	}

	public function add_area2($l1, $l2, $l3)
	{
		global $_W;
		error_reporting(0);
		set_time_limit(0);
		load()->func('communication');
		$url = 'https://lsp.wuliu.taobao.com/locationservice/addr/output_address_town_array.do?l1=' . $l1 . '&l2=' . $l2 . '&l3&lang=zh-S&_ksTS=1482116962514_7635&callback=jsonp7636&qq-pf-to=pcqq.group';
		$response = ihttp_get($url);
		$content = $response['content'];
		preg_match_all('/[\\\'[\\d]+\\\',[^>]+(.*)\\\']/U', $content, $params1);
		$data = array();

		if (!empty($params1[0])) {
			foreach ($params1[0] as &$row) {
				$response = preg_replace('/(\\[|\\]|\')/', '', $row);
				$city_data = explode(',', $response);
				$code = $city_data[0];
				$name = $city_data[1];
				$pcode = $l3;
				$words = $city_data[3];
				if (!empty($code) && !empty($name)) {
					$data[$code]['name'] = $name;
					$data[$code]['code'] = $code;
					$data[$code]['status'] = 1;
					$data[$code]['level'] = 4;
					$data[$code]['pcode'] = $pcode;
					$data[$code]['words'] = $words;
				}
			}
		}

		if (!empty($data)) {
			foreach ($data as $k => $v) {
				if (!empty($v)) {
					$item2 = $this->get_area($v['code']);

					if (empty($item2)) {
						pdo_insert('ewei_shop_city', $v);
					}
				}
			}
		}
	}

	public function get()
	{
		global $_W;
		set_time_limit(0);
		$list = $this->get_area_list(3);
		print_r($list);
		exit();

		foreach ($list as $k3 => $v3) {
			$l3 = $v3['code'];
			$item2 = $this->get_area($v3['pcode']);

			if (!empty($item2)) {
				$l2 = $item2['code'];
				$l1 = $item2['pcode'];
				if (!empty($l2) && !empty($l1)) {
					$this->add_area($l1, $l2, $l3);
				}
			}

			sleep(1.5);
		}

		print_r('OK2');
	}

	public function getnoarea()
	{
		global $_W;
		set_time_limit(0);
		$list2 = $this->get_area_list(2);
		print_r($list2);
		exit();

		foreach ($list2 as $k2 => $v2) {
			$l1 = $v2['pcode'];
			$l2 = $v2['code'];
			$list3 = $this->get_child_list($v2['code']);

			if (!empty($list3)) {
				foreach ($list3 as $k3 => $v3) {
					if (!empty($l2) && !empty($l1)) {
						$l3 = $v3['code'];
						$this->add_area2($l1, $l2, $l3);
					}
				}
			}

			sleep(1.5);
		}

		print_r('OK3');
	}

	public function count()
	{
		global $_W;
		$list = $this->get_area_list(4);

		foreach ($list as $k => $v) {
			$params = array();
			$params[':code'] = $v['code'];
			$sql = 'select count(1) from ' . tablename('ewei_shop_city') . ' where  code=:code';
			$count = pdo_fetchcolumn($sql, $params);

			if (1 < $count) {
				print_r($count);
				print_r('
');
				print_r($v['name']);
				print_r('
');
			}
		}
	}

	public function get_area_list($level)
	{
		global $_W;
		$params = array();
		$params[':level'] = $level;
		$sql = 'select * from ' . tablename('ewei_shop_city') . ' where  level=:level and status=1';
		$list = pdo_fetchall($sql, $params);
		return $list;
	}

	public function get_child_list($pcode)
	{
		global $_W;
		$params = array();
		$params[':pcode'] = $pcode;
		$sql = 'select * from ' . tablename('ewei_shop_city') . ' where  pcode=:pcode and status=1 order by id';
		$list = pdo_fetchall($sql, $params);
		return $list;
	}

	public function check_area($name)
	{
		if (-1 < strpos($name, '属于') || -1 < strpos($name, '合并') || -1 < strpos($name, '更名为')) {
			return 1;
		}

		return 0;
	}

	public function xml()
	{
		global $_W;
		$xml = '<?xml version="1.0" encoding="utf-8"?>
 <address>
<province name="请选择省份">
	<city name="请选择城市">
		<county name="请选择区域"/>
	</city>
</province>';
		$list1 = $this->get_area_list(1);

		foreach ($list1 as $k1 => $v1) {
			$xml .= '
';
			$xml .= '<province name="' . $v1['name'] . '" code="' . $v1['code'] . '">';
			$list2 = $this->get_child_list($v1['code']);

			foreach ($list2 as $k2 => $v2) {
				$xml .= '
';
				$xml .= '<city name="' . $v2['name'] . '" code="' . $v2['code'] . '">';
				$list3 = $this->get_child_list($v2['code']);

				foreach ($list3 as $k3 => $v3) {
					$check = $this->check_area($v3['name']);

					if (!empty($check)) {
						continue;
					}

					$xml .= '
';
					$xml .= '<county name="' . $v3['name'] . '" code="' . $v3['code'] . '" />';
				}

				$xml .= '
';
				$xml .= '</city>';
			}

			$xml .= '
';
			$xml .= '</province>';
		}

		$xml .= '
';
		$xml .= '</address>';
		print_r($xml);
		exit();
	}

	public function xmllist()
	{
		global $_W;
		$list2 = $this->get_area_list(2);
		print_r($list2);
		exit();

		foreach ($list2 as $k2 => $v2) {
			$list3 = $this->get_child_list($v2['code']);
			$xml = '<?xml version="1.0" encoding="utf-8"?>';
			$xml .= '
';
			$xml .= '<address>';
			$xml .= '
';
			$xml .= '<city name="' . $v2['name'] . '" code="' . $v2['code'] . '">';

			foreach ($list3 as $k3 => $v3) {
				$check = $this->check_area($v3['name']);

				if (!empty($check)) {
					continue;
				}

				$xml .= '
';
				$xml .= '<county name="' . $v3['name'] . '" code="' . $v3['code'] . '">';
				$list4 = $this->get_child_list($v3['code']);

				foreach ($list4 as $k4 => $v4) {
					$xml .= '
';
					$xml .= '    <street name="' . $v4['name'] . '" code="' . $v4['code'] . '" />';
				}

				$xml .= '
';
				$xml .= '</county>';
			}

			$xml .= '
';
			$xml .= '</city>';
			$xml .= '
';
			$xml .= '</address>';
			$left = substr($v2['code'], 0, 2);
			$styles = array();
			$dir = IA_ROOT . '/addons/ewei_shopv2/static/js/dist/area/list/' . $left . '/';

			if (!is_dir($dir)) {
				mkdir($dir, 511, true);
			}

			$filename = $dir . $v2['code'] . '.xml';
			$fp = fopen($filename, 'w');
			fwrite($fp, $xml);
			fclose($fp);
		}
	}

	public function js()
	{
		global $_W;
		$xml = 'var FoxUICityData = [';
		$list1 = $this->get_area_list(1);

		foreach ($list1 as $k1 => $v1) {
			$xml .= '{"text": "' . $v1['name'] . '",';
			$xml .= '"children": [';
			$list2 = $this->get_child_list($v1['code']);

			foreach ($list2 as $k2 => $v2) {
				$xml .= '{"text": "' . $v2['name'] . '",';
				$xml .= '"children": [';
				$list3 = $this->get_child_list($v2['code']);

				foreach ($list3 as $k3 => $v3) {
					$check = $this->check_area($v3['name']);

					if (!empty($check)) {
						continue;
					}

					$xml .= '"' . $v3['name'] . '",';
				}

				$xml = trim($xml, ',');
				$xml .= ']},';
			}

			$xml .= ']},';
		}

		$xml = trim($xml, ',');
		$xml .= '];';
		print_r($xml);
		exit();
	}

	public function js2()
	{
		global $_W;
		$xml = 'var FoxUICityDataNew = [';
		$list1 = $this->get_area_list(1);

		foreach ($list1 as $k1 => $v1) {
			$xml .= '{"text": "' . $v1['name'] . '",';
			$xml .= '"value": "' . $v1['code'] . '",';
			$xml .= '"children": [';
			$list2 = $this->get_child_list($v1['code']);

			foreach ($list2 as $k2 => $v2) {
				$xml .= '{"text": "' . $v2['name'] . '",';
				$xml .= '"value": "' . $v2['code'] . '",';
				$xml .= '"children": [';
				$list3 = $this->get_child_list($v2['code']);

				foreach ($list3 as $k3 => $v3) {
					$check = $this->check_area($v3['name']);

					if (!empty($check)) {
						continue;
					}

					$xml .= '{"text": "' . $v3['name'] . '",';
					$xml .= '"value": "' . $v3['code'] . '",';
					$xml .= '"children": []';
					$xml .= '},';
				}

				$xml = trim($xml, ',');
				$xml .= ']},';
			}

			$xml .= ']},';
		}

		$xml = trim($xml, ',');
		$xml .= '];';
		print_r($xml);
		exit();
	}

	public function copy()
	{
		global $_W;
		$list = $this->get_area_list(4);

		foreach ($list as $k => $v) {
			if (!empty($v)) {
				if ($v['id'] <= 30340) {
					continue;
				}

				unset($v['id']);
			}
		}
	}

	public function query()
	{
		$i = 0;
		$list2 = $this->get_area_list(2);
		$data = array();

		foreach ($list2 as $k2 => $v2) {
			$list3 = $this->get_child_list($v2['code']);

			if (empty($list3)) {
				$data[$i]['code'] = $v2['code'] . '001';
				$data[$i]['name'] = $v2['name'];
				$data[$i]['level'] = 3;
				$data[$i]['pcode'] = $v2['code'];
				$data[$i]['status'] = 1;
				$data[$i]['ishand'] = 1;
				++$i;
			}
		}

		foreach ($data as $k => $v) {
			if (!empty($v)) {
			}
		}

		print_r($data);
	}
}

?>
