<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/page_mobile.php';
class Index_EweiShopV2Page extends AppMobilePage
{
	public function main()
	{
		exit('Access Denied');
	}

	public function cacheset()
	{
		global $_GPC;
		global $_W;
		$localversion = 2;
		$version = intval($_GPC['version']);
		$noset = intval($_GPC['noset']);
		$set = m('util')->get_area_config_set();
		if (empty($version) || $version < $localversion || $set['new_area'] != $version) {
			$arr = array(
				'update' => 1,
				'data'   => array('version' => $localversion, 'areas' => $this->getareas())
			);
		}
		else {
			$arr = array('update' => 0);
		}

		if (empty($noset)) {
			$arr['sysset'] = array(
				'shopname'    => $_W['shopset']['shop']['name'],
				'shoplogo'    => $_W['shopset']['shop']['logo'],
				'description' => $_W['shopset']['shop']['description'],
				'share'       => $_W['shopset']['share'],
				'texts'       => array('credit' => $_W['shopset']['trade']['credittext'], 'money' => $_W['shopset']['trade']['moneytext']),
				'isclose'     => $_W['shopset']['app']['isclose']
			);
			$arr['sysset']['share']['logo'] = tomedia($arr['sysset']['share']['logo']);
			$arr['sysset']['share']['icon'] = tomedia($arr['sysset']['share']['icon']);
			$arr['sysset']['share']['followqrcode'] = tomedia($arr['sysset']['share']['followqrcode']);

			if (!empty($_W['shopset']['app']['isclose'])) {
				$arr['sysset']['closetext'] = $_W['shopset']['app']['closetext'];
			}
		}

		return app_json($arr);
	}

	public function getareas()
	{
		global $_W;
		$set = m('util')->get_area_config_set();
		$path = EWEI_SHOPV2_PATH . 'static/js/dist/area/Area.xml';
		$path_full = EWEI_SHOPV2_STATIC . 'js/dist/area/Area.xml';

		if (!empty($set['new_area'])) {
			$path = EWEI_SHOPV2_PATH . 'static/js/dist/area/AreaNew.xml';
			$path_full = EWEI_SHOPV2_STATIC . 'js/dist/area/AreaNew.xml';
		}

		$xml = @file_get_contents($path);

		if (empty($xml)) {
			load()->func('communication');
			$getContents = ihttp_request($path_full);
			$xml = $getContents['content'];
		}

		$array = xml2array($xml);
		$newArr = array();

		if (is_array($array['province'])) {
			foreach ($array['province'] as $i => $v) {
				if (0 < $i) {
					$province = array(
						'name' => $v['@attributes']['name'],
						'code' => $v['@attributes']['code'],
						'city' => array()
					);

					if (is_array($v['city'])) {
						if (!isset($v['city'][0])) {
							$v['city'] = array($v['city']);
						}

						foreach ($v['city'] as $ii => $vv) {
							$city = array(
								'name' => $vv['@attributes']['name'],
								'code' => $vv['@attributes']['code'],
								'area' => array()
							);

							if (is_array($vv['county'])) {
								if (!isset($vv['county'][0])) {
									$vv['county'] = array($vv['county']);
								}

								foreach ($vv['county'] as $iii => $vvv) {
									$area = array('name' => $vvv['@attributes']['name'], 'code' => $vvv['@attributes']['code']);
									$city['area'][] = $area;
								}
							}

							$province['city'][] = $city;
						}
					}

					$newArr[] = $province;
				}
			}
		}

		return $newArr;
	}

	public function getstreet()
	{
		global $_GPC;
		$citycode = intval($_GPC['city']);
		$areacode = intval($_GPC['area']);
		if (empty($citycode) || empty($areacode)) {
			return app_error(AppError::$ParamsError, '城市代码或区代码为空');
		}

		$newArr = array();
		if (!empty($citycode) && !empty($areacode)) {
			$city2 = substr($citycode, 0, 2);
			$path = EWEI_SHOPV2_STATIC . 'js/dist/area/list/' . $city2 . '/' . $citycode . '.xml';
			$data = $this->curl_get($path);

			if (empty($data)) {
				$data = file_get_contents($path);
			}

			$array = xml2array($data);

			if (is_array($array['city']['county'])) {
				foreach ($array['city']['county'] as $k => $kv) {
					if (!is_numeric($k)) {
						$citys[] = $array['city']['county'];
					}
					else {
						$citys = $array['city']['county'];
					}
				}

				foreach ($citys as $i => $city) {
					if ($city['@attributes']['code'] == $areacode) {
						if (is_array($city['street'])) {
							foreach ($city['street'] as $ii => $street) {
								$newArr[] = isset($street['@attributes']) ? array('name' => $street['@attributes']['name'], 'code' => $street['@attributes']['code']) : $street;
							}
						}

						break;
					}
				}
			}
		}

		return app_json(array('street' => $newArr));
	}

	public function black()
	{
		global $_GPC;
		global $_W;

		if (!empty($_W['openid'])) {
			$member = m('member')->getMember($_W['openid']);

			if ($member['isblack']) {
				$isblack = true;
			}
			else {
				$isblack = false;
			}
		}
		else {
			$isblack = false;
		}

		return app_json(array('isblack' => $isblack));
	}

	public function curl_get($url)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($curl);
		curl_close($curl);
		return $data;
	}

	public function wxAppSetting()
	{
		global $_W;
		global $_GPC;
		$ret['sysset'] = array(
			'shopname'     => $_W['shopset']['shop']['name'],
			'shoplogo'     => tomedia($_W['shopset']['shop']['logo']),
			'description'  => $_W['shopset']['shop']['description'],
			'saleout_icon' => isset($_W['shopset']['shop']['saleout']) ? tomedia($_W['shopset']['shop']['saleout']) : '',
			'share'        => $_W['shopset']['share'],
			'texts'        => array('credit' => $_W['shopset']['trade']['credittext'], 'money' => $_W['shopset']['trade']['moneytext']),
			'isclose'      => $_W['shopset']['app']['isclose'],
			'force_auth'   => isset($_W['shopset']['app']['force_auth']) ? $_W['shopset']['app']['force_auth'] : 0
		);
		$ret['sysset']['share']['logo'] = tomedia($ret['sysset']['share']['logo']);
		$ret['sysset']['share']['icon'] = tomedia($ret['sysset']['share']['icon']);
		$ret['sysset']['share']['followqrcode'] = tomedia($ret['sysset']['share']['followqrcode']);

		if (!empty($_W['shopset']['app']['isclose'])) {
			$ret['sysset']['closetext'] = $_W['shopset']['app']['closetext'];
		}

		echo json_encode($ret);
	}
}

?>
