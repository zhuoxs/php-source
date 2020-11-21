<?php
/**
 * 深蓝网络 Copyright (c) www.zhshenlan.com
 * 模块小程序接口定义
 */

defined('IN_IA') or exit('Access Denied');

require_once IA_ROOT . '/addons/slwl_aicard/defines.php';
require_once SLWL_PATH . 'version.php';
require_once SLWL_INC . 'basic.inc.php';
require_once SLWL_INC . 'functions.inc.php';
require_once SLWL_INC . 'fun_store.inc.php'; // 新版商城-模块
require_once SLWL_INC . 'fun_website.inc.php'; // 官网-模块
require_once SLWL_INC . 'fun_commission_store.inc.php'; // 商城分销-模块
class Slwl_aicardModuleWxapp extends WeModuleWxapp
{
	/** 测试 */
	public function doPageSL_test()
	{
		global $_GPC, $_W;

		dump($_GPC);
	}

	/** 获取系统设置 */
	public function doPageSmk_config()
	{
		global $_GPC, $_W;

		// 系统基本设置
		$settings['config'] = array();
		if ($_W['slwl']['set']['site_settings']) {
			$set_str = $_W['slwl']['set']['site_settings'];

			$set_str['thumb_url'] = tomedia($set_str['thumb']);
			$set_str['logo_url'] = tomedia($set_str['logo']);
			$set_str['consult_img_url'] = tomedia($set_str['consult_img']);
			$set_str['dynamic_img_url'] = tomedia($set_str['dynamic_img']);

			$set_str['server_msg'] = isset($set_str['server_msg'])? $set_str['server_msg']:'0';
			$set_str['consult'] = isset($set_str['consult'])? $set_str['consult']:'0';

			$settings['config'] = $set_str;
		}

		// 版权设置
		$settings['cpright'] = array();
		if ($_W['slwl']['set']['cpright_site_settings']) {
			$set_cp = $_W['slwl']['set']['cpright_site_settings'];

			$set_cp['logo_url'] = tomedia($set_cp['logo']);
		} else {
			$set_cp['cpright_show'] = '0';
		}
		$settings['cpright'] = $set_cp;

		// 颜色
		$settings['color'] = array();
		if ($_W['slwl']['set']['site_color_settings']) {
			$set_color = $_W['slwl']['set']['site_color_settings'];

			if ($set_color['topcolor'] == '') { $set_color['topcolor'] = '#ffffff'; }

			if (empty($set_color['maincolor'])) { $set_color['maincolor'] = '#4a86e8'; }
			if (empty($set_color['subcolor'])) { $set_color['subcolor'] = '#0b5394'; }
			if (empty($set_color['bottomcolor'])) { $set_color['bottomcolor'] = '#ffffff'; }
			if (empty($set_color['bottomfontcolor'])) { $set_color['bottomfontcolor'] = '#333333'; }
			if (empty($set_color['bottomfonthovercolor'])) { $set_color['bottomfonthovercolor'] = '#4a86e8'; }

			$settings['color'] = $set_color;
		} else {
			$settings['color'] = array(
				'topcolor'=>'#ffffff',
				'maincolor'=>'#4a86e8',
				'subcolor'=>'#0b5394',
				'bottomcolor'=>'#ffffff',
				'bottomfontcolor'=>'#333333',
				'bottomfonthovercolor'=>'#4a86e8',
			);
		}

		// 小程序列表
		$condition_mod_wxapp = ' AND uniacid=:uniacid ';
		$params_mod_wxapp = array(':uniacid' => $_W['uniacid']);
		$pindex_mod_wxapp = max(1, intval($_GPC['page']));
		$psize_mod_wxapp = 100;
		$sql_mod_wxapp = "SELECT * FROM " . tablename('slwl_aicard_mod_wxapp'). ' WHERE 1 ' . $condition_mod_wxapp;
		$list_mod_wxapp = pdo_fetchall($sql_mod_wxapp, $params_mod_wxapp);

		$settings['wxapp'] = $list_mod_wxapp;


		// 新版商城-基本设置-颜色
		if ($_W['slwl']['set']['set_store_config']) {
			$set_store = $_W['slwl']['set']['set_store_config'];

			if (isset($set_store['is_custom_color_store'])) {
				$settings['color']['is_custom_color_store'] = $set_store['is_custom_color_store'];
			}
		}


		// 底部导航
		$settings['menus'] = array();
		if ($_W['slwl']['set']['menus_set_settings']) {
			$set_menus = $_W['slwl']['set']['menus_set_settings'];

			$settings['menus']['items'] = $set_menus['item'];
			$settings['menus']['enabled'] = $set_menus['enabled'];
		} else {
			$settings['menus']['items'] = array();
			$settings['menus']['enabled'] = 0;
		}

		// 快捷菜单(悬浮按钮)
		$settings['quick'] = array();
		if ($_W['slwl']['set']['set_menu_quick']) {
			$set_menu_quick = $_W['slwl']['set']['set_menu_quick'];

			$settings['quick']['items'] = $set_menu_quick['items'];
			$settings['quick']['enabled'] = $set_menu_quick['enabled'];
		} else {
			$settings['quick']['items'] = array();
			$settings['quick']['enabled'] = 0;
		}


		return $this->result(0, 'ok', $settings);
	}

	/** 接收推送用户 */
	public function doPageSmk_create_user()
	{
		global $_GPC, $_W;
		load()->func('communication');

		$code = $_GPC['code'];
		$id_invite = intval($_GPC['invite']); // 邀请人
		$pid = intval($_GPC['pid']); // 卡片ID

		$data_bak = array();

		// 获取名片
		$condition_card = " AND uniacid=:uniacid AND enabled='1' AND id=:id ";
		$params_card = array(':uniacid' => $_W['uniacid'], ':id' => $pid);
		$one_card = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition_card, $params_card);

		if ($one_card) {
			$data_bak['card'] = $one_card;
		} else {
			$data_bak['card'] = null;
		}

		// 获取-系统设置
		$syscfg = array();
		if ($_W['slwl']['set']['site_settings']) {
			$settings = $_W['slwl']['set']['site_settings'];

			$settings['thumb_url'] = tomedia($settings['thumb']);
			$settings['logo_url'] = tomedia($settings['logo']);
			$settings['imggeurluc'] = tomedia($settings['ucenter']);
			$settings['videourl'] = tomedia($settings['video']);
			$syscfg = $settings;
		}

		$data_bak['syscfg'] = $syscfg;

		$sys_id = $_W['uniacid'];
		$account = uni_fetch($sys_id);

		$get_nicename = json_encode($_GPC['nicename']);
		$get_avatar = $_GPC['avatar'];
		$get_province = $_GPC['province'];
		$get_city = $_GPC['city'];
		$get_gender = $_GPC['gender'];

		$appid = $account['key'];
		$secret = $account['secret'];

		$url = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";

		$resp = ihttp_request($url);
		$result = @json_decode($resp['content']);

		@putlog('获取微信用户信息', $result);

		if (property_exists($result, 'openid')) {
			$openid = $result->openid;
			$session_key = $result->session_key;

			$rst = $this->save_session_key($session_key);
			if ($rst['return_code'] == '1') {
				return $this->result(1, '保存session_key出错');
			}

			// 获取企业微信授权信息
			if (empty($_W['slwl']['set']['set_auth_qywx_settings'])) {
				return $this->result(1, '获取企业微信用户为空，请检查后台企业微信配置');
			}
			$set_auth_qywx_str = $_W['slwl']['set']['set_auth_qywx_settings'];

			$one = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_users')
				. " WHERE openid=:openid AND uniacid=:uniacid", array(":openid" => $openid, ":uniacid" => $_W['uniacid']));

			if (empty($one)) {
				// 添加用户关系
				$data_send_add_user = array(
					'corp_id'=>$set_auth_qywx_str['corpid'],
					'user_id'=>$openid,
					'user_name'=>$get_nicename,
					'head_img'=>$get_avatar,
					'sex'=>$get_gender,
					'city'=>$get_city,
					'province'=>$get_province,
				);

				$url_add_user = SLWL_API_URL . 'Radar/Msg/add_user';

				$resp_send_add_user = ihttp_request($url_add_user, $data_send_add_user);
				$result_send_add_user = @json_decode($resp_send_add_user['content'], true);

				@putlog('接收推送用户-添加用户关系', $result_send_add_user);

				if ($result_send_add_user['IsSuccess']) {
					$data_add_user = [
						'uniacid'   => $_W['uniacid'],
						'openid'    => $openid,
						'nicename'  => $get_nicename,
						'avatar'    => $get_avatar,
						'province'  => $get_province,
						'city'      => $get_city,
						'gender'    => $get_gender,
						'addtime'   => $_W['slwl']['datetime']['now'],
						'last_time' => $_W['slwl']['datetime']['now'],
					];

					pdo_insert('slwl_aicard_users', $data_add_user);
					$id = pdo_insertid();

					$data_add_user['id'] = $id;
					$data_add_user['new_user'] = '1';
					$data_add_user['nicename'] = sl_nickname($data_add_user['nicename']);
					$data_add_user['corp_id'] = $set_auth_qywx_str['corpid'];

					$rst = set_wx_head_img($id);

					$data_bak['user'] = $data_add_user;

					if ($id_invite) {
						$rst = sl_store_commission_post($id, $id_invite); // 添加分销关系

						if ($rst && $rst['code'] != 0) {
							sl_ajax(1, '添加分销关系失败'.$rst['msg']);
						}
					}

					return $this->result(0, 'ok', $data_bak);
				} else {
					return $this->result(1, $result_send_add_user['ErrMsg']);
				}
			} else {
				$one['nicename'] = sl_nickname($one['nicename']);
				$one['corp_id'] = $set_auth_qywx_str['corpid'];
				$one['new_user'] = '0';

				$rst = set_wx_head_img($one['id']);

				$data_bak['user'] = $one;

				$data_update = [
					'last_time'=>$_W['slwl']['datetime']['now'],
				];
				pdo_update('slwl_aicard_users', $data_update, ['id'=>$one['id']]); // 最后访问时间

				return $this->result(0, 'ok', $data_bak);
			}
		} else {
			return $this->result(1, '操作失败'.$result->errcode);
		}
	}

	/** save_session_key */
	private function save_session_key($session_key)
	{
		global $_GPC, $_W;

		if (!$session_key) {
			$rst = [
				'return_code' => '-999999',
				'return_msg'  => 'session_key不存在',
			];
			return $rst;
		}

		$options = array(
			'session_key'=>$session_key,
		);

		$data = array();
		$data['setting_value'] = json_encode($options); // 压缩

		if ($_W['slwl']['set']['set_session_key']) {
			$where['uniacid'] = $_W['uniacid'];
			$where['setting_name'] = 'set_session_key';
			$rst = pdo_update('slwl_aicard_settings', $data, $where);
		} else {
			$data['uniacid'] = $_W['uniacid'];
			$data['setting_name'] = 'set_session_key';
			$data['addtime'] = $_W['slwl']['datetime']['now'];
			$rst = pdo_insert('slwl_aicard_settings', $data);
		}

		if ($rst !== false) {
			$data_bak = [
				'return_code' =>'0',
				'return_msg'  =>'ok',
			];
			return $data_bak;
		} else {
			$data_bak = [
				'return_code' => '1',
				'return_msg'  => 'err',
			];
			return $data_bak;
		}
	}

	private function dispose_get_wx_phone($uid, $code, $iv, $enData)
	{
		global $_GPC, $_W;

		$sys_id = $_W['uniacid'];
		$account = uni_fetch($sys_id);
		$appid = $account['key'];
		$session_key = '';

		if ($code) {
			$secret = $account['secret'];

			load()->func('communication');

			$url = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";

			$resp = ihttp_request($url);
			$result = @json_decode($resp['content']);

			@putlog('获取用户手机号请求', $result);

			if (property_exists($result, 'openid')) {
				$openid = $result->openid;
				$session_key = $result->session_key;
			} else {
				$err_rst = array(
					'return_code'=>$result->errcode,
					'return_msg'=>$result->errmsg,
				);
				return $err_rst;
			}

			$rst = $this->save_session_key($session_key);
			if ($rst['return_code'] == '1') {
				$err_rst = array(
					'return_code' => '1111',
					'return_msg'  => '保存session_key出错',
				);
				return $err_rst;
			}

		} else {
			// 用户信息
			$condition_user_uid = ' AND uniacid=:uniacid AND id=:id ';
			$params_user_uid = array(':uniacid' => $_W['uniacid'], ':id' => $uid);
			$one_user_uid = pdo_fetch("SELECT * FROM ".tablename('slwl_aicard_users').' WHERE 1 '
				. $condition_user_uid, $params_user_uid);

			if ($one_user_uid) {
				$openid = $one_user_uid['openid'];
			} else {
				$err_rst = array(
					'return_code' => '1',
					'return_msg'  => '用户不存在',
				);
				return $err_rst;
			}

			$session_key = $_W['slwl']['set']['set_session_key']['session_key'];
		}

		if ($session_key != '') {
			require_once MODULE_ROOT . "/lib/wxphone/wxBizDataCrypt.php";
			$pc = new WXBizDataCrypt($appid, $session_key);
			$errCode = $pc->decryptData($enData, $iv, $redata);

			if ($errCode == 0) {
				$data_1 = json_decode($redata, true);
				$mobile = '';

				if ($data_1) {
					$mobile = @$data_1['phoneNumber'];

					// 更新手机号
					$data_user = array(
						'mobile' => $mobile,
					);

					$rst_set = set_card_user_mobile($openid, $mobile); //修改-用户的手机号

					if ($rst_set['errcode'] == '0') {
						$rst_ok = array(
							'return_code'=>'SUCCESS',
							'return_msg'=>$mobile,
						);
						pdo_update('slwl_aicard_users', $data_user, array('id' => $uid));
					} else {
						$rst_ok = array(
							'return_code'=>'ERROR',
							'return_msg'=>'发送号码到AI端失败'.$rst_set['errmsg'],
						);
					}
					@putlog('发送手机号请求---', $rst_set);
					return $rst_ok;
				} else {
					$rst_err = array(
						'return_code'=>'ERROR',
						'return_msg'=>'解密失败,请重试',
					);
					return $rst_err;
				}
			} else {
				$rst = array(
					'return_code'=>$errCode,
					'return_msg'=>'微信返回失败,请重试',
				);
				return $rst;
			}
		} else {
			$rst = array(
				'return_code'=>'-999999',
				'return_msg'=>'session_key不存在',
			);
			return $rst;
		}
	}

	/** 获取微信手机号 */
	public function doPageSmk_get_wx_phone()
	{
		global $_GPC, $_W;

		$uid = $_GPC['uid'];
		$iv = $_GPC['iv'];
		$enData = $_GPC['ed'];
		$code = $_GPC['code'];

		$rst = $this->dispose_get_wx_phone($uid, $code, $iv, $enData);

		// dump($code);
		// dump($rst);exit;

		if ($rst['return_code'] == 'SUCCESS') {
			return $this->result(0, 'ok', $rst['return_msg']);
		} else {
			return $this->result(1, $rst['return_code'].$rst['return_msg'], $rst['return_code']);
		}
	}

	/** list页-名片列表 */
	public function doPageSmk_list_data()
	{
		global $_GPC, $_W;
		$uid = intval($_GPC['uid']);

		// 用户信息
		$condition_user_uid = ' AND uniacid=:uniacid AND id=:id ';
		$params_user_uid = array(':uniacid' => $_W['uniacid'], ':id' => $uid);
		$one_user_uid = pdo_fetch("SELECT * FROM ".tablename('slwl_aicard_users').' WHERE 1 '
			. $condition_user_uid, $params_user_uid);

		// 名片信息
		$condition_mycard = " AND uniacid=:uniacid AND enabled='1' AND user_id=:user_id ";
		$params_mycard = array(':uniacid' => $_W['uniacid'], ':user_id' => $uid);
		$pindex_mycard = max(1, intval($_GPC['page']));
		$psize_mycard = 100;
		$sql_mycard = "SELECT * FROM " . tablename('slwl_aicard_mycard') . ' WHERE 1 '
			. $condition_mycard . " ORDER BY displayorder DESC, id DESC LIMIT "
			. ($pindex_mycard - 1) * $psize_mycard .',' .$psize_mycard;
		$list_mycard = pdo_fetchall($sql_mycard, $params_mycard);

		if ($list_mycard) {
			$flags = '';
			foreach ($list_mycard as $item) {
				$flags .= $item['card_id'] . ',';
			}
			$flags = substr($flags, 0, strlen($flags)-1);
			$where =' AND id IN(' . $flags . ')';

			$condition_card = " AND uniacid=:uniacid AND enabled='1' ";
			$condition_card .= $where;
			$params_card = array(':uniacid' => $_W['uniacid']);

			$card_list_not_sort = pdo_fetchall('SELECT * FROM '
				. tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition_card . '  ORDER BY displayorder DESC, id DESC ', $params_card);

			$card_list = array();
			foreach ($list_mycard as $k => $v) {
				foreach ($card_list_not_sort as $key => $value) {
					if ($v['card_id'] == $value['id']) {
						$card_list[] = $value;
						break;
					}
				}
			}

		} else {
			$condition_card = " AND uniacid=:uniacid AND isdefault='1' AND enabled='1' ";
			$params_card = array(':uniacid' => $_W['uniacid']);
			$card_list_tmp = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition_card, $params_card);

			if ($card_list_tmp) {
				$source_text = $_W['slwl']['datetime']['now'] . ' 来自扫码';

				$data = array(
					'uniacid' => $_W['uniacid'],
					'user_id' => $uid,
					'card_id' => $card_list_tmp['id'],
					'source_id' => '0',
					'source_text' => $source_text,
					'addtime' => $_W['slwl']['datetime']['now'],
				);
				pdo_insert('slwl_aicard_mycard', $data);

				// 补充用户来源信息
				if (empty($one_user_uid['source_cardid'])) {
					$source_name = $card_list_tmp['last_name'].$card_list_tmp['first_name'];
					$data_user = array(
						'source_cardid' => $card_list_tmp['id'],
						'source_name' => $source_name,
						'source_txt' => $source_text,
					);
					pdo_update('slwl_aicard_users', $data_user, array('id' => $uid));
				}

				$card_list_tmp['source_text'] = $source_text;
				$card_list = array($card_list_tmp);
			}
		}

		if ($card_list) {
			// 获取基本设置信息
			if ($_W['slwl']['set']['site_settings']) {
				$set_str = $_W['slwl']['set']['site_settings'];

				$set_str['thumb_url'] = tomedia($set_str['thumb']);
				// $proxy_url = wxappUrl('SL_proxy_img', array('url'=> tomedia($set_str['thumb'])));
				// $set_str['thumb_url'] = $proxy_url;

				$set_str['logo_url'] = tomedia($set_str['logo']);
				$set_str['ucenter_url'] = tomedia($set_str['ucenter']);
				$set_str['videourl'] = tomedia($set_str['video']);
				$set_str['consult_img_url'] = tomedia($set_str['consult_img']);
				$set_str['dynamic_img_url'] = tomedia($set_str['dynamic_img']);

				$one['logo_url'] = tomedia($set_str['logo']);

				$one_set_cfg = $set_str;
			}

			foreach ($card_list as $k => $v) {
				foreach ($list_mycard as $key => $value) {
					if ($v['id'] == $value['card_id']) {
						$card_list[$k]['source_text'] = $value['source_text'];
						$card_list[$k]['mycard_sort'] = $value['displayorder'];
						$card_list[$k]['mycard_id'] = $value['id'];
						break;
					}
				}

				$card_list[$k]['thumb_url'] = tomedia($v['thumb']);
				$card_list[$k]['qrcode_url'] = tomedia($v['qrcode']);

				if ($v['attr']) {
					$smeta = '';
					$smeta = json_decode($v['attr'], true);

					if ($smeta['items']) {
						foreach ($smeta['items'] as $key => $value) {
							if ($value['page_url'] == 'people') {
								$card_list[$k]['mobile'] = $value['content'];
							}
							if ($value['page_url'] == 'company') {
								$card_list[$k]['company'] = $value['content'];
							}
							if ($value['page_url'] == 'corp') {
								$card_list[$k]['company'] = $value['content'];
							}
							if ($value['page_url'] == 'email') {
								$card_list[$k]['email'] = $value['content'];
							}
							// 地址
							if ($value['page_url'] == 'location') {
								$card_list[$k]['address'] = isset($value['content'])?$value['content']:$one_set_cfg['address'];
							}
							if ($value['page_url'] == 'address') {
								$card_list[$k]['address'] = isset($value['content'])?$value['content']:$one_set_cfg['address'];
							}
						}
					}
				}
			}
		} else {
			$condition_default_now = " AND uniacid=:uniacid AND isdefault='1' AND enabled='1' ";
			$params_default_now = array(':uniacid' => $_W['uniacid']);
			$one_default_now = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 '
				. $condition_default_now, $params_default_now);

			if ($one_default_now) {
				$card_list = array($one_default_now);
			}
		}

		if ($card_list) {
			foreach ($card_list as $k => $v) {
				if ($v['attr']) {
					$smeta = json_decode($v['attr'], true);
					if ($smeta) {
						$card_list[$k]['smeta'] = $smeta;
					}
				}
			}

			foreach ($card_list as $key => $value) {
				unset($card_list[$k]['attr']);
				unset($card_list[$k]['other_attr']);
				unset($card_list[$k]['pic_content']);
				unset($card_list[$k]['thumb']);
			}
		}

		$res['list'] = $card_list;

		return $this->result(0, 'ok', $res);
	}

	/** list页，默认数据 */
	public function doPageSmk_list_data_default()
	{
		global $_GPC, $_W;
		$uid = intval($_GPC['uid']);

		$condition_card = " AND uniacid=:uniacid AND isdefault='1' AND enabled='1' ";
		$params_card = array(':uniacid' => $_W['uniacid']);
		$card_list_tmp = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition_card, $params_card);

		if ($card_list_tmp) {
			$source_text = $_W['slwl']['datetime']['now'] . ' 来自扫码';


			$card_list_tmp['source_text'] = $source_text;
			$card_list = array($card_list_tmp);
		}

		if ($card_list) {
			foreach ($card_list as $k => $v) {

				$card_list[$k]['thumb_url'] = tomedia($v['thumb']);

				if ($v['attr']) {
					$smeta = '';
					$smeta = json_decode($v['attr'], true);

					if ($smeta['items']) {
						foreach ($smeta['items'] as $key => $value) {
							if ($value['page_url'] == 'people') {
								$card_list[$k]['mobile'] = $value['content'];
							}
							if ($value['page_url'] == 'company') {
								$card_list[$k]['company'] = $value['content'];
							}
							if ($value['page_url'] == 'corp') {
								$card_list[$k]['company'] = $value['content'];
							}
							if ($value['page_url'] == 'email') {
								$card_list[$k]['email'] = $value['content'];
							}
						}
					}
				}
				unset($card_list[$k]['attr']);
				unset($card_list[$k]['pic_content']);
				unset($card_list[$k]['thumb']);
			}
		}

		$res['list'] = $card_list;

		return $this->result(0, 'ok', $res);
	}

	/** one-del */
	public function doPageSL_card_del()
	{
		global $_GPC, $_W;
		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];

		if (empty($ver)) { return $this->result(1, '版本号不存在'); }
		if (empty($uid)) { return $this->result(1, '用户不存在'); }

		$form_json = $_GPC['__input']; // 参数

		if ($form_json) {
			// card_id
			$card_id = isset($form_json['id']) ? $form_json['id'] : '';
		}

		if (empty($card_id)) {
			return $this->result(1, '名片不存在');
		}

		$rst = @pdo_delete('slwl_aicard_mycard', ['uniacid'=>$_W['uniacid'],'user_id'=>$uid,'card_id'=>$card_id]);

		if ($rst !== false) {
			return $this->result(0, '成功');
		} else {
			return $this->result(1, '不存在或已删除');
		}
	}

	/** one-card */
	public function doPageSmk_list_one()
	{
		global $_GPC, $_W;
		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];
		$shareid = $_GPC['sid']; // 分享人ID
		$pid = intval($_GPC['pid']); // 卡片ID

		$condition = " AND uniacid=:uniacid AND enabled='1' AND id=:id ";
		$params = array(':uniacid' => $_W['uniacid'], ':id' => $pid);
		$one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition, $params);

		if (empty($one)) {
			$where_1 = ['uniacid'=>$_W['uniacid'], 'id'=>$pid];
			$one = pdo_get(sl_table_name('card'), $where_1);

			if (empty($one)) {
				return $this->result(1, 'err', '卡片信息缓存已过期');
			}

			$where_2 = ['uniacid'=>$_W['uniacid'], 'enabled'=>1, 'join_id'=>$one['join_id']];
			$one = pdo_get(sl_table_name('card'), $where_2);

			if (empty($one)) {
				return $this->result(1, 'err', '卡片信息缓存已过期');
			}
		}

		if ($one) {
			// 用户信息
			$condition_user_uid = ' AND uniacid=:uniacid AND id=:id ';
			$params_user_uid = array(':uniacid' => $_W['uniacid'], ':id' => $uid);
			$one_user_uid = pdo_fetch("SELECT * FROM ".tablename('slwl_aicard_users').' WHERE 1 '
				. $condition_user_uid, $params_user_uid);

			// 查询点赞记录
			$condition_like = " AND uniacid=:uniacid AND user_id=:user_id AND card_id=:card_id ";
			$params_like = array(':uniacid' => $_W['uniacid'], ':user_id' => $uid, ':card_id' => $pid);
			$one_like = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_like') . ' WHERE 1 ' . $condition_like, $params_like);

			// 获取基本设置信息
			if ($_W['slwl']['set']['site_settings']) {
				$set_str = $_W['slwl']['set']['site_settings'];

				$set_str['thumb_url'] = tomedia($set_str['thumb']);
				// $proxy_url = wxappUrl('SL_proxy_img', array('url'=> tomedia($set_str['thumb'])));
				// $set_str['thumb_url'] = $proxy_url;

				$set_str['logo_url'] = tomedia($set_str['logo']);
				$set_str['ucenter_url'] = tomedia($set_str['ucenter']);
				$set_str['videourl'] = tomedia($set_str['video']);
				$set_str['consult_img_url'] = tomedia($set_str['consult_img']);
				$set_str['dynamic_img_url'] = tomedia($set_str['dynamic_img']);

				$one['logo_url'] = tomedia($set_str['logo']);

				$one_set_cfg = $set_str;
			}

			// 开始处理信息
			$other_attr = json_decode($one['other_attr'], true);

			$str_defautl_share_title = '您好，我是[公司]的[姓名]';
			$str_defautl_welcomes = '你好，我是[公司]的[姓名]，欢迎进入我的名片，有什么可以帮到你的吗？你可以在这里跟我实时沟通。';

			$one['sign_show'] = $other_attr['sign_show'];
			$one['sign'] = $other_attr['sign'];
			// 印象
			$one['impression_show'] = $other_attr['impression_show'];
			// 音频
			$one['audio_show'] = $other_attr['audio_show'];
			$one['audio_title'] = $other_attr['audio_title'];
			$one['audio_autoplay'] = $other_attr['audio_autoplay'];
			// 视频
			$one['video_show'] = $other_attr['video_show'];
			$one['video_autoplay'] = $other_attr['video_autoplay'];
			// 自定义分享标题-状态
			$one['share_title_status'] = isset($other_attr['share_title_status'])?$other_attr['share_title_status']:'0';
			//分享标题内容
			if ($one['share_title_status']) {
				$one['share_title_cont'] = $other_attr['share_title_cont']?$other_attr['share_title_cont']:'';
			} else {
				$one['share_title_cont'] = $str_defautl_share_title;
			}
			$one['official_account_status'] = $other_attr['official_account_status'];
			$one['address_books_status'] = isset($other_attr['address_books_status'])?$other_attr['address_books_status']:'1';
			$one['recommend_goods_status'] = isset($other_attr['recommend_goods_status'])?$other_attr['recommend_goods_status']:'1';
			//欢迎语-状态
			$one['welcomes_status'] = isset($other_attr['welcomes_status'])?$other_attr['welcomes_status']:'0';
			// 欢迎语内容
			if ($one['welcomes_status']) {
				$one['welcomes_cont'] = $other_attr['welcomes_cont']?$other_attr['welcomes_cont']:'';
			} else {
				$one['welcomes_cont'] = $str_defautl_welcomes;
			}

			$one['videourl'] = tomedia($other_attr['video']);
			$one['audiourl'] = tomedia($other_attr['audio']);
			$one['video_poster_url'] = tomedia($other_attr['video_poster']);

			// $one['thumb_url'] = tomedia($one['thumb']);
			$proxy_url = wxappUrl('SL_proxy_img', array('url'=> tomedia($one['thumb'])));
			$one['thumb_url'] = $proxy_url;
			$one['qrcodeurl'] = tomedia($one['qrcode']);

			$num = $one['view'] + 1;

			$data = array(
				'view' => $num,
			);
			$rst = pdo_update('slwl_aicard_card', $data, array('id' => $pid));
			$one['view'] = $num;

			if ($one_like) {
				$one['islike'] = '1';
			} else {
				$one['islike'] = '0';
			}

			$one['company'] = $one_set_cfg['company'];

			if ($one['attr']) {
				$smeta = json_decode($one['attr'], true);

				if (empty($smeta['style'])) {
					$smeta['style'] = 'list';
				}

				if ($smeta['items']) {
					foreach ($smeta['items'] as $k => $v) {
						if ($v['page_url'] == 'wechat') {
							$one['wechat'] = $v['content'];
							break;
						}
					}

					foreach ($smeta['items'] as $key => $value) {
							$smeta['items'][$key]['act_txt'] = '复制';

						if ($value['page_url'] == 'people') {
							$one['mobile'] = $value['content'];
							$smeta['items'][$key]['act_txt'] = '拨打';
						}
						// 公司
						if ($value['page_url'] == 'company') {
							$one['company'] = isset($value['content'])?$value['content']:$one_set_cfg['company'];
							$smeta['items'][$key]['act_txt'] = '定位';
						}
						if ($value['page_url'] == 'corp') {
							$one['company'] = isset($value['content'])?$value['content']:$one_set_cfg['company'];
							// $smeta['items'][$key]['act_txt'] = '复制';
						}
						// 地址
						if ($value['page_url'] == 'location') {
							$one['address'] = isset($value['content'])?$value['content']:$one_set_cfg['address'];
							// $smeta['items'][$key]['act_txt'] = '定位';
						}
						if ($value['page_url'] == 'address') {
							$one['address'] = isset($value['content'])?$value['content']:$one_set_cfg['address'];
							// $smeta['items'][$key]['act_txt'] = '复制';
						}
						if ($value['page_url'] == 'location') {
							// $one['company'] = $value['content'];
							$smeta['items'][$key]['act_txt'] = '定位';
						}
						if ($value['page_url'] == 'email') {
							$one['email'] = $value['content'];
						}
						if ($value['page_url'] == 'tel') {
							$one['tel'] = $value['content'];
							$smeta['items'][$key]['act_txt'] = '拨打';
						}
					}

					unset($one['attr']);
					$one['smeta'] = $smeta;
				}
			}

			// 替换
			$user_name = $one['last_name'].$one['middle_name'].$one['first_name'];
			// if ($one['share_title_status'] == '1') {
				$one['share_title_cont'] = str_replace('[公司]', $one['company'], $one['share_title_cont']);
				$one['share_title_cont'] = str_replace('[姓名]', $user_name, $one['share_title_cont']);
			// }

			// if ($one['welcomes_status'] == '1') {
				$one['welcomes_cont'] = str_replace('[公司]', $one['company'], $one['welcomes_cont']);
				$one['welcomes_cont'] = str_replace('[姓名]', $user_name, $one['welcomes_cont']);
			// }


			// 查是否存在名片
			$condition_mycard = " AND uniacid=:uniacid AND enabled='1' AND card_id=:card_id AND user_id=:user_id ";
			$params_mycard = array(':uniacid' => $_W['uniacid'], ':card_id' => $pid, ':user_id' => $uid);
			$sql_mycard = "SELECT * FROM " . tablename('slwl_aicard_mycard') . ' WHERE 1 ' . $condition_mycard;
			$one_mycard = pdo_fetch($sql_mycard, $params_mycard);

			if (empty($one_mycard)) {
				$data_mycard = array(
					'uniacid' => $_W['uniacid'],
					'user_id' => $uid,
					'card_id' => $one['id'],
					'addtime' => $_W['slwl']['datetime']['now'],
				);

				if ($shareid) {
					$condition_share_user = ' AND uniacid=:uniacid AND id=:id ';
					$params_share_user = array(':uniacid' => $_W['uniacid'], ':id'=>$shareid);
					$one_share_user = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_users') . ' WHERE 1 '
						. $condition_share_user, $params_share_user);

					$nicename = json_decode($one_share_user['nicename']);
					$data_mycard['source_id'] = $one_share_user['id'];
					$data_mycard['source_name'] = $nicename;
					$data_mycard['source_text'] = $_W['slwl']['datetime']['now'] . ' 来自'.$nicename.'的分享';
				} else {
					$data_mycard['source_name'] = '';
					$data_mycard['source_text'] = $_W['slwl']['datetime']['now'] . ' 来自扫码';
				}

				pdo_insert('slwl_aicard_mycard', $data_mycard);

				if (empty($one_user_uid['source_cardid'])) {
					$source_name = $one['last_name'].$one['first_name'];
					$data_user = array(
						'source_cardid' => $one['id'],
						'source_name' => $source_name,
						'source_txt' => $data_mycard['source_text'],
					);
					pdo_update('slwl_aicard_users', $data_user, array('id' => $uid));
				}
			}

			// 浏览用户记录
			$condition_myuser = " AND uniacid=:uniacid AND user_id=:uid ";
			$params_myuser = array(':uniacid' => $_W['uniacid'], ':uid' => $uid);
			$one_myuser = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_myuser') . ' WHERE 1 '
				. $condition_myuser, $params_myuser);

			if (empty($one_myuser)) {
				$data_myuser = array(
					'uniacid' => $_W['uniacid'],
					'user_id' => $uid,
					'card_id' => $one['id'],
					'addtime' => $_W['slwl']['datetime']['now'],
				);
				pdo_insert('slwl_aicard_myuser', $data_myuser);
			}

			// 查询用户浏览记录
			$condition_myuser_six = " AND uniacid=:uniacid AND card_id=:card_id ";
			$params_myuser_six = array(':uniacid' => $_W['uniacid'], ':card_id' => $pid);
			$pindex_myuser_six = max(1, intval($_GPC['page']));
			$psize_myuser_six = 6;
			$sql_myuser_six = "SELECT * FROM " . tablename('slwl_aicard_myuser') . ' WHERE 1 '
				. $condition_myuser_six . " ORDER BY id DESC LIMIT "
				. ($pindex_myuser_six - 1) * $psize_myuser_six .',' .$psize_myuser_six;
			$list_myuser_six = pdo_fetchall($sql_myuser_six, $params_myuser_six);

			$user_history = array();
			if ($list_myuser_six) {
				$flags = '';
				foreach ($list_myuser_six as $item) {
					$flags .= $item['user_id'] . ',';
				}
				$flags = substr($flags, 0, strlen($flags)-1);
				$where_six =' AND id IN(' . $flags . ')';

				$condition_user_six = " AND uniacid=:uniacid ";
				$condition_user_six .= $where_six;
				$params_user_six = array(':uniacid' => $_W['uniacid']);

				$list_user_six = pdo_fetchall('SELECT id,avatar,addtime FROM ' . tablename('slwl_aicard_users') . ' WHERE 1 '
					. $condition_user_six . ' ORDER BY id ASC ', $params_user_six);

				$user_history['items'] = $list_user_six;
			}

			$condition_myuser_count = " AND uniacid=:uniacid AND card_id=:card_id ";
			$params_myuser_count = array(':uniacid' => $_W['uniacid'], ':card_id' => $pid);
			$sql_myuser_count = "SELECT COUNT(*) FROM " . tablename('slwl_aicard_myuser') . ' WHERE 1 ' . $condition_myuser_count;
			$list_myuser_count = pdo_fetchcolumn($sql_myuser_count, $params_myuser_count);

			$user_history['count'] = $list_myuser_count;


			// 首页推荐商品
			$condition_mygood = " AND uniacid=:uniacid AND card_id=:card_id ";
			$params_mygood = array(':uniacid' => $_W['uniacid'], ':card_id' => $pid);
			$pindex_mygood = max(1, intval($_GPC['page']));
			$psize_mygood = 100;
			$sql_mygood = "SELECT * FROM " . tablename('slwl_aicard_card_goods') . ' WHERE 1 '
				. $condition_mygood . " ORDER BY id DESC LIMIT " . ($pindex_mygood - 1) * $psize_mygood .',' .$psize_mygood;
			$list_mygood = pdo_fetchall($sql_mygood, $params_mygood);

			if ($list_mygood) {
				$flags_mygood = '';
				foreach ($list_mygood as $item) {
					$flags_mygood .= $item['good_id'] . ',';
				}
				$flags_mygood = substr($flags_mygood, 0, strlen($flags_mygood)-1);
				$where_mygood =' AND id IN(' . $flags_mygood . ')';


				$condition_mygs = " AND uniacid=:uniacid AND deleted='0' ";
				$condition_mygs .= $where_mygood;
				$params_mygs = array(':uniacid' => $_W['uniacid']);
				$pindex_mygs = max(1, intval($_GPC['page']));
				$psize_mygs = 100;
				$sql_mygs = "SELECT * FROM " . tablename('slwl_aicard_store_goods') . ' WHERE 1 '
					. $condition_mygs . " ORDER BY displayorder DESC, id DESC LIMIT "
					. ($pindex_mygs - 1) * $psize_mygs .',' .$psize_mygs;

				$list_mygs = pdo_fetchall($sql_mygs, $params_mygs);
				// $total_mygs = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('slwl_aicard_card_goods') . ' WHERE 1 '
				//      . $condition_mygood, $params_mygood);
				// $pager_mygs = pagination($total_mygs, $pindex_mygood, $psize_mygood);

				foreach ($list_mygs as $k => $v) {
					foreach ($list_mygood as $key => $value) {
						if ($v['id'] == $value['good_id']) {
							$list_mygs[$k]['card_good_id'] = $value['id'];
						}
					}

					$list_mygs[$k]['thumb_url'] = tomedia($v['thumb']);
					$list_mygs[$k]['price_format'] = number_format($v['price'] / 100, 2);
					$list_mygs[$k]['original_price_format'] = number_format($v['original_price'] / 100, 2);
				}
			}

			// 印象列表.start
			$condition_impression = " AND uniacid=:uniacid AND card_id=:card_id ";
			$params_impression = array(':uniacid' => $_W['uniacid'], ':card_id' => $pid);
			$pindex_impression = max(1, intval($_GPC['page']));
			$psize_impression = 100;
			$sql_impression = "SELECT * FROM " . tablename('slwl_aicard_impression') . ' WHERE 1 '
				. $condition_impression . " ORDER BY displayorder DESC, id DESC LIMIT " . ($pindex_impression - 1) * $psize_impression .','
				. $psize_impression;
			$list_impression = pdo_fetchall($sql_impression, $params_impression);

			// 查询点赞记录
			$condition_im_like = " AND uniacid=:uniacid AND user_id=:user_id AND card_id=:card_id ";
			$params_im_like = array(':uniacid' => $_W['uniacid'], ':user_id' => $uid, ':card_id' => $pid);
			$list_im_like = pdo_fetchall('SELECT * FROM ' . tablename('slwl_aicard_impression_like') . ' WHERE 1 '
				. $condition_im_like, $params_im_like);

			foreach ($list_impression as $k => $v) {
				$list_impression[$k]['is_like'] = '0';
				foreach ($list_im_like as $key => $value) {
					if ($v['id'] == $value['impression_id']) {
						$list_impression[$k]['is_like'] = '1';
						break;
					}
				}
			}
			$one['impression'] = $list_impression;

			// 印象列表.end

		} else {
			return $this->result(1, 'err', '卡片信息缓存已过期');
		}

		$res = array(
			'one'=>$one,
			'user_history'=>$user_history,
			'goods'=>$list_mygs,
		);

		return $this->result(0, 'ok', $res);
	}

	// 转发，加1
	public function doPageSmk_share_add_one()
	{
		global $_GPC, $_W;
		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];
		$pid = intval($_GPC['pid']);

		$condition = " AND uniacid=:uniacid AND id=:id ";
		$params = array(':uniacid' => $_W['uniacid'], ':id' => $pid);
		$rst = pdo_query("UPDATE " . tablename('slwl_aicard_card') . " SET relay=relay+1 WHERE 1 " . $condition, $params);

		if ($rst !== false) {
			return $this->result(0, 'ok');
		} else {
			return $this->result(1, '失败');
		}
	}

	// 动态，list
	public function doPageSmk_dylist_data()
	{
		global $_GPC, $_W;
		$uid = intval($_GPC['uid']);

		$page = ((empty($_GPC['page']) ? '' : $_GPC['page']));
		$pindex = max(1, intval($page));
		$psize =  max(10, intval($_GPC['psize']));
		$termid = max(0, intval($_GPC['tid'])); // 分类ID

		// 用户信息
		$condition_user = " AND uniacid=:uniacid AND id=:id ";
		$params_user = array(':uniacid' => $_W['uniacid'], ':id' => $uid);
		$one_user = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_users') . ' WHERE 1 ' . $condition_user, $params_user);

		if (empty($one_user)) {
			return $this->result(1, '用户ID为空');
		}

		// 获取动态列表信息
		$condition = " AND uniacid=:uniacid AND enabled='1' AND dy_type='0' ";
		$params = array(':uniacid' => $_W['uniacid']);
		$list = pdo_fetchall('SELECT * FROM ' . tablename('slwl_aicard_dynamic_act') . ' WHERE 1 '
			. $condition . '  ORDER BY displayorder DESC, id DESC limit ' . (($pindex - 1) * $psize) . ',' . $psize, $params);

		if ($list) {
			foreach ($list as $k => $v) {
				$list[$k]['createtime_cn'] = date('Y-m-d', $v['createtime']);
				$list[$k]['thumb_url'] = tomedia($v['thumb']);
				$list[$k]['dy_share'] = '0';
				$list[$k]['islike_my'] = '-1';

				if ($v) {
					// 点赞列表
					$condition_islike = " AND uniacid=:uniacid AND dy_id=:dy_id ";
					$params_islike = array(':uniacid'=>$_W['uniacid'], ':dy_id'=>$v['id']);

					$list_islike = pdo_fetchall('SELECT * FROM ' . tablename('slwl_aicard_dynamic_islike') . ' WHERE 1 '
						. $condition_islike . ' ORDER BY id ASC ', $params_islike);

					if ($list_islike) {
						$tmp_like_user = array();
						foreach ($list_islike as $key => $value) {
							if ($value) {
								$nicename = json_decode($value['nicename']);
								$list[$k]['islikestr'] .= $nicename . ', ';
								$tmp_like_user[] = $nicename;
							} else {
								$list[$k]['islikestr'] = '';
							}
						}
						$list[$k]['islikestr'] = rtrim($list[$k]['islikestr'] , ', ');
						$list[$k]['like_user'] = $tmp_like_user;

						foreach ($list_islike as $key => $value) {
							if ($value['user_id'] == $uid) {
								$list[$k]['islike_my'] = $key;
								break;
							}
						}
					}

					// 评论列表
					$condition_comment = " AND uniacid=:uniacid AND dy_id=:dy_id AND status='1' AND enabled='1' ";
					$params_comment = array(':uniacid'=>$_W['uniacid'], ':dy_id'=>$v['id']);
					$list_comment = pdo_fetchall('SELECT * FROM ' . tablename('slwl_aicard_dynamic_comment') . ' WHERE 1 '
						. $condition_comment . ' ORDER BY id ASC ', $params_comment);

					if ($list_comment) {
						foreach ($list_comment as $key => $value) {
							$list_comment[$key]['nicename_cn'] = json_decode($value['nicename']);
						}
					}

					$list[$k]['comment'] = $list_comment;
				} else {
					$list[$k]['islikestr'] = '';
					$list[$k]['comment'] = null;
				}
			}
		}

		foreach ($list as $k => $v) {
			unset($list[$k]['detail']);
		}

		$obj_dy_config = array();
		if ($_W['slwl']['set']['settings_dynamic']) {
			$obj_dy_config = $_W['slwl']['set']['settings_dynamic'];
			$obj_dy_config['dynamic_img_url'] = tomedia($obj_dy_config['dynamic_img']);
		}

		$rs = array(
			'dylist'=>$list,
			'dy_config'=>$obj_dy_config,
		);

		return $this->result(0, 'ok', $rs);
	}

	// 动态-config
	public function doPageSL_dylist_config()
	{
		global $_GPC, $_W;
		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];
		$pid = intval($_GPC['pid']);

		$obj_dy_config = array();
		if ($_W['slwl']['set']['settings_dynamic']) {
			$obj_dy_config = $_W['slwl']['set']['settings_dynamic'];
			$obj_dy_config['dynamic_img_url'] = tomedia($obj_dy_config['dynamic_img']);
		}

		$data_bak = array(
			'dy_config'=>$obj_dy_config,
		);

		return $this->result(0, 'ok', $data_bak);
	}

	// 动态，文章内容
	public function doPageSmk_dyact_one()
	{
		global $_GPC, $_W;
		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];
		$pid = intval($_GPC['pid']);

		$condition = " AND uniacid=:uniacid AND id=:id AND enabled='1' ";
		$id = max(0, intval($_GPC['aid']));
		$params = array(':uniacid' => $_W['uniacid'], 'id' => $id);

		$one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_dynamic_act') . ' WHERE 1 ' . $condition, $params);

		if ($one) {
			$one['thumb_url'] = tomedia($one['thumb']);
			$one['out_thumb_url'] = tomedia($one['out_thumb']);
		}

		$res = array(
			'one'=>$one
		);

		return $this->result(0, 'ok', $res);
	}

	// 动态，操作-打开评论
	public function doPageSmk_send_op_link_show_comment()
	{
		global $_GPC, $_W;
		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];
		$pid = intval($_GPC['pid']);

		// 用户信息
		$condition_user = ' AND uniacid=:uniacid AND id=:id ';
		$params_user = array(':uniacid' => $_W['uniacid'], ':id' => $uid);
		$one_user = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_users') . ' WHERE 1 ' . $condition_user, $params_user);

		// 卡片信息
		$condition_card = " AND uniacid=:uniacid AND enabled='1' AND id=:id ";
		$params_card = array(':uniacid' => $_W['uniacid'], ':id' => $pid);
		$one_card = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition_card, $params_card);

		if ($one_card) {
			return $this->result(0, 'ok');
		} else {
			return $this->result(1, '名片不存在');
		}
	}

	// 动态，评论
	public function doPageSmk_comment_insert()
	{
		global $_GPC, $_W;

		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];
		$msg = $_GPC['msg'];
		$pid = intval($_GPC['pid']);
		$dy_id = intval($_GPC['dyid']);

		// 用户信息
		$condition_user = ' AND uniacid=:uniacid AND id=:id ';
		$params_user = array(':uniacid' => $_W['uniacid'], ':id' => $uid);
		$one_user = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_users') . ' WHERE 1 ' . $condition_user, $params_user);

		// 卡片信息
		$condition_card = " AND uniacid=:uniacid AND enabled='1' AND id=:id ";
		$params_card = array(':uniacid' => $_W['uniacid'], ':id' => $pid);
		$one_card = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition_card, $params_card);

		// 获取 配置
		$issh = '0';
		if ($_W['slwl']['set']['set_comment_set_settings']) {
			$tmp_comment = $_W['slwl']['set']['set_comment_set_settings'];

			if ($tmp_comment && $tmp_comment['comment_show'] == '1') {
				$issh = '1';
			}
		}

		$return_comment_data = '';
		if ($one_card) {
			$comment_data = array(
				'uniacid' => $_W['uniacid'],
				'openid' => $one_user['openid'],
				'user_id' => $uid,
				'nicename' => $one_user['nicename'],
				'dy_id' => $dy_id,
				'content' => $msg,
				'status' => ($issh == 0) ? '1' : '0',
				'enabled' => '0',
				'addtime' => $_W['slwl']['datetime']['now'],
			);
			$res = pdo_insert('slwl_aicard_dynamic_comment', $comment_data);
			$id = pdo_insertid();
			$return_comment_data = $comment_data;
			$return_comment_data['id'] = $id;
			$return_comment_data['check_switch'] = $issh;
			$return_comment_data['nicename_cn'] = json_decode($one_user['nicename']);

			if ($res > 0) {
				if ($issh == '1') {
					return $this->result(0, '评论成功等待审核', $return_comment_data);
				} else {
					return $this->result(0, '评论成功', $return_comment_data);
				}
			} else {
				return $this->result(1, '评论失败');
			}
		} else {
			return $this->result(1, '名片不存在');
		}
	}

	// 官网模块.start
	// 官网-首页
	public function doPageSmk_website_index_data()
	{
		website_index_data();
	}

	// 官网-文章列表，传分类ID
	public function doPageSmk_act_news()
	{
		website_act_list();
	}

	// 官网-普通文章-内容
	public function doPageSmk_act_one()
	{
		website_act_one();
	}

	// 官网-单页面文章-内容
	public function doPageSmk_adact_one()
	{
		website_adact_one();
	}

	// 官网-获取所有兄弟分类
	public function doPageSmk_act_list_nav()
	{
		website_act_list_nav();
	}

	// 官网-返回指定分类下的文章
	public function doPageSmk_act_list_list()
	{
		website_term_act_list();
	}
	// 官网模块.end


	// 产品列表-配置
	public function doPageSL_pro_list_config()
	{
		global $_GPC, $_W;
		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];
		$pid = intval($_GPC['pid']);

		$tmp_pl_config = array();
		if ($_W['slwl']['set']['set_pro_list']) {
			$tmp_pl_config = $_W['slwl']['set']['set_pro_list'];
		}

		$data_bak = array(
			'config'=>$tmp_pl_config,
		);

		return $this->result(0, 'ok', $data_bak);
	}

	// 产品列表
	public function doPageSmk_pro_list()
	{
		global $_GPC, $_W;

		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];
		$pid = intval($_GPC['pid']);

		$page = ((empty($_GPC['page']) ? '' : $_GPC['page']));
		$pindex = max(1, intval($page));
		$psize =  max(10, intval($_GPC['psize']));
		$termid = max(0, intval($_GPC['tid'])); // 分类ID

		$condition = " AND uniacid=:uniacid AND enabled='1' ";
		$params = array(':uniacid' => $_W['uniacid']);
		$list = pdo_fetchall('SELECT * FROM ' . tablename('slwl_aicard_product_list') . ' WHERE 1 '
			. $condition . '  ORDER BY displayorder DESC, id DESC limit ' . (($pindex - 1) * $psize) . ',' . $psize, $params);

		foreach ($list as $k => $v) {
			$list[$k]['thumb_url'] = tomedia($v['thumb']);
		}

		$list_news['items'] = $list;

		$data_bak = array(
			'topic'=>$list_news,
		);

		return $this->result(0, 'ok', $data_bak);
	}

	// 产品  文章内容
	public function doPageSmk_pro_one()
	{
		global $_GPC, $_W;

		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];
		$pid = intval($_GPC['pid']);
		$id = intval($_GPC['aid']);

		$condition = " AND uniacid=:uniacid AND id=:id AND enabled='1' ";
		$params = array(':uniacid' => $_W['uniacid'], 'id' => $id);

		$one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_product_list') . ' WHERE 1 ' . $condition, $params);

		if ($one) {
			if ($one['detail']) {
				$one['detail'] = preg_replace('/alt=".*?"/', '', $one['detail']);
			}
			$one['thumb_url'] = tomedia($one['thumb']);
			$one['out_thumb_url'] = tomedia($one['out_thumb']);
		}

		$data_bak = array(
			'one'=>$one
		);

		return $this->result(0, 'ok', $data_bak);
	}

	// 聊天前的信息获取
	public function doPageSmk_cloud_im_config()
	{
		global $_GPC, $_W;

		$opuser_id = $_GPC['uid'];
		$pid = intval($_GPC['pid']);

		// 用户信息
		$condition_user = " AND uniacid=:uniacid AND id=:id ";
		$params_user = array(':uniacid' => $_W['uniacid'], ':id' => $opuser_id);
		$one_user = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_users') . ' WHERE 1 ' . $condition_user, $params_user);

		// 获取-企业微信配置信息

		if (empty($_W['slwl']['set']['set_auth_qywx_settings'])) {
			return $this->result(1, '企业微信配置信息为空');
		}
		$set_auth_qywx_str = $_W['slwl']['set']['set_auth_qywx_settings'];

		// 卡片信息
		$condition_card = " AND uniacid=:uniacid AND enabled='1' AND id=:id ";
		$params_card = array(':uniacid' => $_W['uniacid'], ':id' => $pid);
		$one_card = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition_card, $params_card);

		if (empty($one_card)) {
			return $this->result(1, '卡片信息为空');
		}

		// 获取基本设置信息
		if ($_W['slwl']['set']['site_settings']) {
			$set_str = $_W['slwl']['set']['site_settings'];

			$set_str['thumb_url'] = tomedia($set_str['thumb']);
			$set_str['logo_url'] = tomedia($set_str['logo']);
			$set_str['ucenter_url'] = tomedia($set_str['ucenter']);
			$set_str['videourl'] = tomedia($set_str['video']);
			$set_str['consult_img_url'] = tomedia($set_str['consult_img']);
			$set_str['dynamic_img_url'] = tomedia($set_str['dynamic_img']);

			$one_set_cfg = $set_str;
		}

		$one_card['thumb_url'] = tomedia($one_card['thumb']);
		$one_card['nick_name'] = json_decode($one_card['nick_name']);
		$one_card['qrcode_url'] = tomedia($one_card['qrcode']);

		if ($one_card['other_attr']) {
			$other_attr = json_decode($one_card['other_attr'], true);
			$str_defautl_share_title = '您好，我是[公司]的[姓名]';
			$str_defautl_welcomes = '你好，我是[公司]的[姓名]，欢迎进入我的名片，有什么可以帮到你的吗？你可以在这里跟我实时沟通。';

			$one_card['sign_show'] = $other_attr['sign_show'];
			$one_card['sign'] = $other_attr['sign'];
			$one_card['video_show'] = $other_attr['video_show'];
			$one_card['video_autoplay'] = $other_attr['video_autoplay'];
			$one_card['audio_title'] = $other_attr['audio_title'];
			$one_card['audio_show'] = $other_attr['audio_show'];
			$one_card['audio_autoplay'] = $other_attr['audio_autoplay'];
			// 自定义分享标题-状态
			$one_card['share_title_status'] = isset($other_attr['share_title_status'])?$other_attr['share_title_status']:'0';
			//分享标题内容
			$one_card['share_title_cont'] = isset($other_attr['share_title_cont'])?$other_attr['share_title_cont']:$str_defautl_share_title;
			$one_card['official_account_status'] = $other_attr['official_account_status'];
			//欢迎语-状态
			$one_card['welcomes_status'] = isset($other_attr['welcomes_status'])?$other_attr['welcomes_status']:'0';
			// 欢迎语内容
			$one_card['welcomes_cont'] = isset($other_attr['welcomes_cont'])?$other_attr['welcomes_cont']:$str_defautl_welcomes;

			$one_card['address_books_status'] = isset($other_attr['address_books_status'])?$other_attr['address_books_status']:'1';
			$one_card['recommend_goods_status'] = isset($other_attr['recommend_goods_status'])?$other_attr['recommend_goods_status']:'1';
		}

		$one_card['company'] = $one_set_cfg['company'];
		if ($one_card['attr']) {
			$smeta = json_decode($one_card['attr'], true);

			if ($smeta['items']) {
				foreach ($smeta['items'] as $k => $v) {
					if ($v['page_url'] == 'wechat') {
						$one_card['wechat'] = $v['content'];
						break;
					}
				}

				foreach ($smeta['items'] as $key => $value) {
					$smeta['items'][$key]['act_txt'] = '复制';

					if ($value['page_url'] == 'people') {
						$one_card['mobile'] = $value['content'];
						$smeta['items'][$key]['act_txt'] = '拨打';
					}
					if ($value['page_url'] == 'company') {
						$one_card['company'] = $value['content'];
						$smeta['items'][$key]['act_txt'] = '定位';
					}
					if ($value['page_url'] == 'corp') {
						$one_card['company'] = $value['content'];
						// $smeta['items'][$key]['act_txt'] = '复制';
					}
					if ($value['page_url'] == 'location') {
						// $one_card['company'] = $value['content'];
						$smeta['items'][$key]['act_txt'] = '定位';
					}
					if ($value['page_url'] == 'email') {
						$one_card['email'] = $value['content'];
					}
					if ($value['page_url'] == 'tel') {
						$one_card['tel'] = $value['content'];
						$smeta['items'][$key]['act_txt'] = '拨打';
					}
				}

				unset($one_card['attr']);
				$one['smeta'] = $smeta;
			}
		}

		unset($one_card['other_attr']);
		unset($one_card['pic_content']);

		// 替换
		$user_name = $one_card['last_name'].$one_card['middle_name'].$one_card['first_name'];
		$one_card['share_title_cont'] = str_replace('[公司]', $one_card['company'], $one_card['share_title_cont']);
		$one_card['share_title_cont'] = str_replace('[姓名]', $user_name, $one_card['share_title_cont']);
		$one_card['welcomes_cont'] = str_replace('[公司]', $one_card['company'], $one_card['welcomes_cont']);
		$one_card['welcomes_cont'] = str_replace('[姓名]', $user_name, $one_card['welcomes_cont']);

		$cloud_im_data = array(
			'corp_id'=>$set_auth_qywx_str['corpid'],
			'user_id'=>$one_card['userid'],
			'op_user_id'=>$one_user['openid'],
			'user_name'=>json_encode($one_card['first_name'].$one_card['last_name']),
			'head_img'=>$one_card['thumb'],
			'num'=>100,
		);

		load()->func('communication');
		$url = SLWL_API_URL . 'Radar/Msg/get_im_and_user_info';
		$resp_cloud_im = ihttp_request($url, $cloud_im_data);
		$result_cloud_im = @json_decode($resp_cloud_im['content'], true);

		@putlog('打开聊天窗口获取配置信息', $result_cloud_im);

		// dump($cloud_im_data);
		// dump($resp_cloud_im);
		// dump($result_cloud_im);exit;

		if (!$result_cloud_im['IsSuccess']) {
			return $this->result(1, $result_cloud_im['ErrMsg']);
		}

		$data_bak = array(
			'user_info'=>$result_cloud_im['Data']['user_info'],
			'corp_info'=>$result_cloud_im['Data']['corp_info'],
			'msg_record'=>$result_cloud_im['Data']['msg_record'],
			'card'=>$one_card,
		);

		return $this->result(0, 'ok', $data_bak);
	}

	// 聊天-获取消息
	public function doPageSmk_cloud_im_get_msg()
	{
		global $_GPC, $_W;
		$openid = $_GPC['openid'];
		$corpid = $_GPC['corpid'];
		$card_userid = $_GPC['cuid'];
		$card_id = $_GPC['caid'];

		if (empty($card_userid) || $card_userid=='') {
			// 名片信息
			$condition_card = " AND uniacid=:uniacid AND enabled='1' AND id=:id ";
			$params_card = array(':uniacid' => $_W['uniacid'], ':id' => $card_id);
			$one_card = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition_card, $params_card);

			if ($one_card) {
				$card_userid = $one_card['userid'];
			}
		}

		$cloud_im_data = array(
			'corp_id'=>$corpid,
			'user_id'=>$card_userid,
			'op_user_id'=>$openid,
			'num'=>100,
		);

		// dump($cloud_im_data);exit;

		load()->func('communication');
		$url = SLWL_API_URL . 'Radar/Msg/get_im_msg_curr';
		$resp_cloud_im = ihttp_request($url, $cloud_im_data);
		$result_cloud_im = @json_decode($resp_cloud_im['content'], true);

		@putlog('聊天-获取消息', $result_cloud_im);

		// dump($cloud_im_data);
		// dump($resp_cloud_im);
		// dump($result_cloud_im);
		// exit;

		$res = array(
			'msg_record'=>$result_cloud_im['Data']['msg_record'],
		);

		return $this->result(0, 'ok', $res);
	}

	// 发送信息前的保存
	public function doPageSmk_save_im_msg()
	{
		global $_GPC, $_W;
		$uid = $_GPC['uid'];
		$card_id = $_GPC['cuid'];

		// $app_id = $_GPC['appid'];
		$corp_id = $_GPC['corpid'];
		$send_content = $_GPC['scont'];
		$receive_id = $_GPC['friendid'];
		$create_by = $_GPC['createby'];

		// 用户信息
		$condition_user = " AND uniacid=:uniacid AND id=:id ";
		$params_user = array(':uniacid' => $_W['uniacid'], ':id' => $uid);
		$one_user = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_users') . ' WHERE 1 ' . $condition_user, $params_user);

		// 名片信息
		$condition_card = " AND uniacid=:uniacid AND enabled='1' AND id=:id ";
		$params_card = array(':uniacid' => $_W['uniacid'], ':id' => $card_id);
		$one_card = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition_card, $params_card);

		$receive_uuid = $one_card['userid'];

		$cloud_im_data = array(
			// 'app_id'=>$app_id,
			'send_name'=>$one_user['nicename'],
			'corp_id'=>$corp_id,
			'content'=>$send_content,
			'receive_id'=>$receive_id,
			'receive_uuid'=>$receive_uuid,
			'read_status'=>'0',
			'create_by'=>$create_by,
			'chat_type'=>'private',
			'source'=>'wxapp',
		);

		load()->func('communication');
		$url = SLWL_API_URL . 'Radar/Msg/save_im_msg';
		$resp_cloud_im = ihttp_request($url, $cloud_im_data);
		$result_cloud_im = @json_decode($resp_cloud_im['content'], true);

		$result_cloud_im['data'] = $cloud_im_data;
		@putlog('保存发送信息', $result_cloud_im);

		if ($result_cloud_im['IsSuccess']) {
			return $this->result(0, 'ok');
		} else {
			return $this->result(1, $result_cloud_im['ErrMsg']);
		}
	}

	// 发送模板消息接口
	public function doPageSend_wxapp_template_msg()
	{
		global $_GPC, $_W;

		$openid = $_GPC['openid'];
		$uid = $_GPC['userid'];
		$appid = $_GPC['appid'];

		if (empty($openid) || empty($uid) || empty($appid)) {
			return $this->result(1, '必需参数不能为空');
		}

		$condition_card = " AND uniacid=:uniacid AND userid=:userid ";
		$params_card = array(':uniacid' => $appid, ':userid' => $uid);
		$one_card = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition_card, $params_card);

		if ($one_card) {

			require_once MODULE_ROOT . "/lib/Common.class.php";
			$app = Common::get_app_info($appid);
			require_once MODULE_ROOT . "/lib/jssdk/jssdk.php";
			$jssdk = new JSSDK($app['appid'], $app['secret'], 'token_name_'.$appid);

			// $openid = get_openid($uid); // 获取 openid
			$template_id = get_template_id(); // 获取 openid

			if ($template_id == 'NONE') {
				@putlog('模板ID为空，请开启模板功能');
				return $this->result(1, '模板ID为空，请开启模板功能');
			}

			$form_id = get_form_id($openid); // 获取 form_id

			if ($form_id == 'NONE') {
				@putlog('form_id为空，用户还没有和你互动或互动数已用完');
				return $this->result(1, 'form_id为空，用户还没有和你互动或互动数已用完');
			}

			$send_data = array(
				'openid'=>$openid,
				'template_id'=>$template_id,
				'form_id'=>$form_id,
				'uid'=>$one_card['id'],
				'username'=>$one_card['last_name'].$one_card['middle_name'].$one_card['first_name'],
				'datetime'=>$_W['slwl']['datetime']['now'],
			);

			$result = $jssdk->templates_send_client($send_data);
			$result->send_data = $send_data;

			@putlog('发送服务通知', $result);

			if ($result && property_exists($result, 'errcode') && ($result->errmsg == 'ok')) {
				return $this->result(0, 'ok', $result);
			} else {
				return $this->result(1, 'err', $result);
			}
		} else {
			@putlog('发送服务通知', '用户不存在');

			return $this->result(1, '用户不存在');
		}
	}

	// 操作-online
	public function doPageSmk_send_op_online()
	{
		global $_GPC, $_W;

		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];

		$openid = $_GPC['openid'];
		$status = $_GPC['status'];

		if (empty($_W['slwl']['set']['set_auth_qywx_settings'])) {
			return $this->result(1, '获取企业微信用户为空，请检查后台企业微信配置');
		}

		//status 1=在线，0=离线
		$set_auth_qywx_str = $_W['slwl']['set']['set_auth_qywx_settings'];

		$send_data = array(
			'corp_id'=>$set_auth_qywx_str['corpid'],
			'user_id'=>$openid,
			'status'=>$status,
		);

		load()->func('communication');
		$url = SLWL_API_URL . 'Radar/Msg/set_user_login_status';
		$resp = ihttp_request($url, $send_data);
		$result = @json_decode($resp['content'], true);

		@putlog('操作聊天状态-'.$status, $result);

		return $this->result(0, 'ok', $resp);
	}

	// 置顶
	public function doPageSmk_set_mycard_displayorder()
	{
		global $_GPC, $_W;

		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];
		$pid = intval($_GPC['pid']);
		$post_sort = $_GPC['sort']; // 排序

		// 用户信息
		$condition_user = " AND uniacid=:uniacid AND id=:id ";
		$params_user = array(':uniacid' => $_W['uniacid'], ':id' => $uid);
		$one_user = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_users') . ' WHERE 1 ' . $condition_user, $params_user);

		// 查询名片记录
		$condition_card = " AND uniacid=:uniacid AND enabled='1' AND id=:id ";
		$params_card = array(':uniacid' => $_W['uniacid'], ':id' => $pid);
		$one_card = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition_card, $params_card);

		if ($one_card) {
			if ($post_sort == 0) {
				$tmp_sort = $_W['slwl']['datetime']['timestamp'];
			} else {
				$tmp_sort = 0;
			}
			$data_sort = array(
				'displayorder' => $tmp_sort,
			);

			$res = pdo_update('slwl_aicard_mycard', $data_sort, array('user_id'=>$uid, 'card_id' => $pid));

			if ($one_user) {

				$bak = array(
					'pts'=>$tmp_sort,
				);

				return $this->result(0, 'ok', $bak);
			} else {
				return $this->result(1, '操作失败1');
			}
		} else {
			return $this->result(1, '操作失败-名片不存在');
		}
	}


	// AI端-获取名片信息
	public function doPageSmk_ai_get_card_info()
	{
		global $_GPC, $_W;

		$userid = $_GPC['uid'];
		$poster_type = $_GPC['type'];

		$data_bak = array();

		// 用户信息
		$condition_card = " AND uniacid=:uniacid AND enabled='1' AND userid=:userid ";
		$params_card = array(':uniacid' => $_W['uniacid'], ':userid' => $userid);
		$one_card = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition_card, $params_card);

		if ($one_card) {
			$one_card['thumb_url'] = tomedia($one_card['thumb']);
			$one_card['qrcode_url'] = tomedia($one_card['qrcode']);

			if ($one_card['other_attr']) {
				$other_attr = json_decode($one_card['other_attr'], true);

				$one_card['sign_show'] = $other_attr['sign_show'];
				$one_card['sign'] = $other_attr['sign'];
				$one_card['video_show'] = $other_attr['video_show'];
				$one_card['video_poster'] = $other_attr['video_poster'];
				$one_card['video'] = $other_attr['video'];
				$one_card['video_autoplay'] = $other_attr['video_autoplay'];
				$one_card['audio_title'] = $other_attr['audio_title'];
				$one_card['audio_show'] = $other_attr['audio_show'];
				$one_card['audio'] = $other_attr['audio'];
				$one_card['audio_autoplay'] = $other_attr['audio_autoplay'];
				$one_card['share_title_status'] = $other_attr['share_title_status'];
				$one_card['share_title_cont'] = $other_attr['share_title_cont'];
				$one_card['official_account_status'] = $other_attr['official_account_status'];
				$one_card['address_books_status'] = $other_attr['address_books_status'];
				$one_card['recommend_goods_status'] = $other_attr['recommend_goods_status'];
			}

			if ($one_card['attr']) {
				$smeta = json_decode($one_card['attr'], true);

				foreach ($smeta['items'] as $key => $value) {
					// 地址
					if ($value['page_url'] == 'location') {
						$one_card['address'] = $value['content'];
						break;
					}
					if ($value['page_url'] == 'address') {
						$one_card['address'] = $value['content'];
						break;
					}
				}
			}

			unset($one_card['attr']);
			unset($one_card['other_attr']);
			unset($one_card['pic_content']);
		}


		$data_bak['user'] = $one_card;

		if ($_W['slwl']['set']['site_settings']) {
			$set_str = $_W['slwl']['set']['site_settings'];

			$set_str['thumb_url'] = tomedia($set_str['thumb']);
			$set_str['logo_url'] = tomedia($set_str['logo']);
			$set_str['ucenter_url'] = tomedia($set_str['ucenter']);
			$set_str['video_url'] = tomedia($set_str['video']);
			$set_str['consult_img_url'] = tomedia($set_str['consult_img']);
			$set_str['dynamic_img_url'] = tomedia($set_str['dynamic_img']);


			$data_bak['corp'] = $set_str;
		} else {
			$data_bak['corp'] = array();
		}

		if ($poster_type == 'poster') {
			$condition_cusposter = " AND uniacid=:uniacid AND enabled='1' ";
			$params_cusposter = array(':uniacid' => $_W['uniacid']);
			$pindex_cusposter = max(1, intval($_GPC['page']));
			$psize_cusposter = 100;
			$sql_cusposter = "SELECT id,thumb FROM " . tablename('slwl_aicard_custom_poster') . ' WHERE 1 '
				. $condition_cusposter . " ORDER BY id DESC LIMIT "
				. ($pindex_cusposter - 1) * $psize_cusposter . ',' . $psize_cusposter;
			$list_cusposter = pdo_fetchall($sql_cusposter, $params_cusposter);

			// if (empty($list_cusposter)) {
			//     return $this->result(1, '鸡血海报不存在');
			// }

			foreach ($list_cusposter as $k => $v) {
				$list_cusposter[$k]['image_url'] = tomedia($v['thumb']);
			}

			$data_bak['poster'] = $list_cusposter;
		}

		return $this->result(0, 'ok', $data_bak);
	}

	// AI端-修改名片信息
	public function doPageSmk_ai_set_card_info()
	{
		global $_GPC, $_W;

		$userid = $_GPC['uid'];

		if ($_GPC['extension']) {
			return $this->result(1, '文件后缀不能为空');
		}

		// 用户信息
		$condition_card = " AND uniacid=:uniacid AND enabled='1' AND userid=:userid ";
		$params_card = array(':uniacid' => $_W['uniacid'], ':userid' => $userid);
		$one_card = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition_card, $params_card);

		if ($one_card) {
			if ($_W['ispost']) {
				$data = array();

				if (isset($_GPC['head_img'])) {
					load()->func('file');
					$file = base64_decode($_GPC['head_img']);

					$sys_id = $_W['uniacid'];
					$filename = 'images/' . $sys_id . '/' . date('Y/m/', $_W['slwl']['datetime']['timestamp']);
					$filename .= file_random_name($filename, 'jpeg');

					$rst = file_write($filename, $file);
					$rst_remote = file_remote_upload($filename);
				}

				if (isset($_GPC['last_name']))           { $data['last_name']              = $_GPC['last_name']; }
				if (isset($_GPC['first_name']))          { $data['first_name']             = $_GPC['first_name']; }
				if (isset($_GPC['position']))            { $data['honour']                 = $_GPC['position']; }
				if (isset($_GPC['head_img']))            { $data['thumb']                  = $filename; }
				if (isset($_GPC['mobile']))              { $data['mobile_show']            = $_GPC['mobile']; }
				if (isset($_GPC['email']))               { $data['email']                  = $_GPC['email']; }
				if (isset($_GPC['pic_show']))            { $data['pic_show']               = $_GPC['pic_show']; }
				if (isset($_GPC['pic_title']))           { $data['pic_title']              = $_GPC['pic_title']; }
				if (isset($_GPC['card_style']))          { $data['card_style']             = $_GPC['card_style']; }

				// 其他属性-编辑里的属性
				$one_other_attr = array();
				if ($one_card['other_attr']) {
					$other_attr = json_decode($one_card['other_attr'], true);

					$one_other_attr['sign_show'] = $other_attr['sign_show'];
					$one_other_attr['sign'] = $other_attr['sign'];
					$one_other_attr['video_show'] = $other_attr['video_show'];
					$one_other_attr['video_poster'] = $other_attr['video_poster'];
					$one_other_attr['video'] = $other_attr['video'];
					$one_other_attr['video_autoplay'] = $other_attr['video_autoplay'];
					$one_other_attr['audio_title'] = $other_attr['audio_title'];
					$one_other_attr['audio_show'] = $other_attr['audio_show'];
					$one_other_attr['audio'] = $other_attr['audio'];
					$one_other_attr['audio_autoplay'] = $other_attr['audio_autoplay'];
					$one_other_attr['share_title_status'] = $other_attr['share_title_status'];
					$one_other_attr['share_title_cont'] = $other_attr['share_title_cont'];
					$one_other_attr['official_account_status'] = $other_attr['official_account_status'];
					$one_other_attr['address_books_status'] = $other_attr['address_books_status'];
					$one_other_attr['recommend_goods_status'] = $other_attr['recommend_goods_status'];
				}
				if (isset($_GPC['share_title_status']))  { $one_other_attr['share_title_status'] = $_GPC['share_title_status']; }
				if (isset($_GPC['share_title_cont']))    { $one_other_attr['share_title_cont']   = $_GPC['share_title_cont']; }
				if (isset($_GPC['sign_show']))           { $one_other_attr['sign_show']          = $_GPC['sign_show']; }
				if (isset($_GPC['sign']))                { $one_other_attr['sign']               = $_GPC['sign']; }
				if (count($one_other_attr)>0) {
					$data['other_attr'] = json_encode($one_other_attr);
				}

				// 个人信息
				$one_attr = array();
				if ($one_card['attr']) {
					$smeta = json_decode($one_card['attr'], true);

					if (isset($_GPC['address']) && $smeta) {
						foreach ($smeta['items'] as $k => $v) {
							// 地址
							if ($v['page_url'] == 'location') {
								$smeta['items'][$k]['content'] = $_GPC['address'];
							}
							if ($v['page_url'] == 'address') {
								$smeta['items'][$k]['content'] = $_GPC['address'];
							}
						}

						$data['attr'] = json_encode($smeta);
					}
				}

				$rst = pdo_update('slwl_aicard_card', $data, array('uniacid'=>$_W['uniacid'], 'userid' => $userid));

				$result = array();
				$result['userid'] = $userid;
				$result['data'] = $data;
				$result['rst'] = $rst;
				@putlog('AI端-修改名片信息', $result);

				if ($rst !== false) {
					return $this->result(0, '保存成功');
				} else {
					@putlog('AI端-修改名片信息-保存失败', $result);
					return $this->result(1, '保存失败');
				}
				exit;
			} else {
				@putlog('AI端-修改名片信息-非法请求');
				return $this->result(1, '非法请求');
			}

		} else {
			@putlog('AI端-修改名片信息-名片不存在');
			return $this->result(1, '名片不存在');
		}
	}

	// AI端-获取鸡血海报
	public function doPageSmk_ai_get_custom_poster()
	{
		global $_GPC, $_W;

		$data_bak = array();

		$condition_cusposter = " AND uniacid=:uniacid AND enabled='1' ";
		$params_cusposter = array(':uniacid' => $_W['uniacid']);
		$pindex_cusposter = max(1, intval($_GPC['page']));
		$psize_cusposter = 100;
		$sql_cusposter = "SELECT * FROM " . tablename('slwl_aicard_custom_poster') . ' WHERE 1 '
			. $condition_cusposter . " ORDER BY id DESC LIMIT "
			. ($pindex_cusposter - 1) * $psize_cusposter . ',' .$psize_cusposter;
		$list_cusposter = pdo_fetchall($sql_cusposter, $params_cusposter);

		if (empty($list_cusposter)) {
			return $this->result(1, '鸡血海报不存在');
		}

		load()->func('file');

		foreach ($list_cusposter as $k => $v) {
			$list_cusposter[$k]['thumb_url'] = tomedia($v['thumb']);
		}

		$data_bak['poster'] = $list_cusposter;

		return $this->result(0, 'ok', $data_bak);
	}



	// 新方法.start

	// 点赞-名片
	public function doPageSL_islike()
	{
		global $_GPC, $_W;
		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];
		$pid = intval($_GPC['pid']);

		$curr_datatime = $_W['slwl']['datetime']['now'];

		$islike = $_GPC['like'] == 'true' ? '1' : '0'; // 点赞状态

		// 用户信息
		$condition_user = " AND uniacid=:uniacid AND id=:id ";
		$params_user = array(':uniacid' => $_W['uniacid'], ':id' => $uid);
		$one_user = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_users') . ' WHERE 1 ' . $condition_user, $params_user);

		if (empty($one_user)) { return $this->result(1, '用户ID不能为空'); }

		// 查询名片记录
		$condition_card = " AND uniacid=:uniacid AND enabled='1' AND id=:id ";
		$params_card = array(':uniacid' => $_W['uniacid'], ':id' => $pid);
		$one_card = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition_card, $params_card);

		if (empty($one_card)) { return $this->result(1, '名片不能为空'); }

		// 查询点赞记录
		$condition = " AND uniacid=:uniacid AND user_id=:user_id AND card_id=:card_id ";
		$params = array(':uniacid' => $_W['uniacid'], ':user_id' => $uid, ':card_id' => $pid);
		$one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_like') . ' WHERE 1 ' . $condition, $params);

		if ($islike == '1') {
			if (empty($one)) {
				$data_like = array(
					'uniacid' => $_W['uniacid'],
					'user_id' => $uid,
					'card_id' => $pid,
					'addtime' => $curr_datatime,
				);
				$rst = pdo_insert('slwl_aicard_like', $data_like);
				if ($rst !== false) {
					$rst_card = pdo_query("UPDATE " . tablename('slwl_aicard_card') . " set `like`=`like`+1 WHERE id=:id ", array(':id'=>$pid));

					if ($rst_card !== false) {
						return $this->result(0, '成功');
					} else {
						return $this->result(2, '失败');
					}
				} else {
					return $this->result(1, '失败');
				}

			} else {
				return $this->result(0, '没有取消操作1');
			}
		} else {
			if ($one) {
				$rst_card = pdo_query("UPDATE " . tablename('slwl_aicard_card') . " set `like`=`like`-1 WHERE id=:id ", array(':id'=>$pid));

				if ($rst !== false) {
					$rst_card = pdo_delete('slwl_aicard_like', array('id' => $one['id']));

					if ($rst_card !== false) {
						return $this->result(0, '成功');
					} else {
						return $this->result(2, '失败');
					}
				} else {
					return $this->result(1, '失败');
				}
			} else {
				return $this->result(0, '没有取消操作2');
			}
		}
	}

	// 点赞-动态
	public function doPageSmk_islike_dy()
	{
		global $_GPC, $_W;
		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];
		$pid = intval($_GPC['pid']);

		$dy_id = intval($_GPC['id']); // 动态ID
		$islike = $_GPC['like'] == 'true' ? '1' : '0'; // 点赞状态

		$curr_datatime = $_W['slwl']['datetime']['now'];

		// 用户信息
		$condition_user = " AND uniacid=:uniacid AND id=:id ";
		$params_user = array(':uniacid' => $_W['uniacid'], ':id' => $uid);
		$one_user = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_users') . ' WHERE 1 ' . $condition_user, $params_user);

		if (empty($one_user)) { return $this->result(1, '用户ID不能为空'); }

		// 卡片信息
		$condition_card = " AND uniacid=:uniacid AND enabled='1' AND id=:id ";
		$params_card = array(':uniacid' => $_W['uniacid'], ':id' => $pid);
		$one_card = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition_card, $params_card);

		if (empty($one_card)) { return $this->result(1, '名片不能为空'); }

		// 获取-动态记录
		$condition_dy = " AND uniacid=:uniacid AND enabled='1' AND id=:id ";
		$params_dy = array(':uniacid' => $_W['uniacid'], ':id' => $dy_id);
		$one_dy = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_dynamic_act') . ' WHERE 1 ' . $condition_dy, $params_dy);

		if (empty($one_card)) { return $this->result(1, '动态不存在'); }

		// 查询-动态点赞记录
		$condition_islike = " AND uniacid=:uniacid AND user_id=:user_id AND dy_id=:dy_id ";
		$params_islike = array(':uniacid' => $_W['uniacid'], ':user_id' => $uid, ':dy_id' => $dy_id);
		$one_islike = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_dynamic_islike') . ' WHERE 1 ' . $condition_islike, $params_islike);


		if ($islike == '1') {
			if (empty($one)) {
				$data_like_dy = array(
					'uniacid' => $_W['uniacid'],
					'openid' => $one_user['openid'],
					'user_id' => $uid,
					'nicename' => $one_user['nicename'],
					'dy_id' => $dy_id,
					'addtime' => $curr_datatime,
				);
				$rst = pdo_insert('slwl_aicard_dynamic_islike', $data_like_dy);

				if ($rst !== false) {
					$rst_card = pdo_query("UPDATE " . tablename('slwl_aicard_dynamic_act')
						. " set like_count=like_count+1 WHERE id=:id ", array(':id'=>$dy_id));

					if ($rst_card !== false) {
						return $this->result(0, '成功');
					} else {
						return $this->result(2, '失败');
					}
				} else {
					return $this->result(1, '失败');
				}

			} else {
				return $this->result(0, '没有取消操作1');
			}
		} else {
			if ($one_islike) {
				$rst_card = pdo_query("UPDATE " . tablename('slwl_aicard_dynamic_act')
					. " set like_count=like_count-1 WHERE id=:id ", array(':id'=>$dy_id));

				if ($rst !== false) {
					$rst_card = pdo_delete('slwl_aicard_dynamic_islike', array('id' => $one_islike['id']));

					if ($rst_card !== false) {
						return $this->result(0, '成功');
					} else {
						return $this->result(2, '失败');
					}
				} else {
					return $this->result(1, '失败');
				}
			} else {
				return $this->result(0, '没有取消操作2');
			}
		}
	}

	// 操作-通用收集form_id
	public function doPageSL_save_form_id()
	{
		global $_GPC, $_W;
		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];
		$pid = intval($_GPC['pid']);

		$form_id_json = $_GPC['__input']; // 参数

		if ($form_id_json) {
			// formIDs
			$form_ids = isset($form_id_json['formIDs']) ? $form_id_json['formIDs'] : '';
		}

		if (empty($uid)) {
			@putlog('通用收集form_id-用户ID为空');
			return result(1, '用户ID为空');
		}
		if (empty($form_ids)) {
			@putlog('通用收集form_id-formID为空');
			return result(1, 'formID为空');
		}

		// 用户信息
		$condition_user = " AND uniacid=:uniacid AND id=:id ";
		$params_user = array(':uniacid' => $_W['uniacid'], ':id' => $uid);
		$one_user = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_users') . ' WHERE 1 ' . $condition_user, $params_user);

		if ($one_user) {
			$ids = 0;
			foreach ($form_ids as $k => $v) {
				if ($v != 'the formId is a mock one') {
					$formid_data = array(
						'uniacid' => $_W['uniacid'],
						'user_id' => $uid,
						'openid' => $one_user['openid'],
						'form_id' => $v,
						'op_code' => 'slwl-000000',
						'op_text' => '通用收取form_id',
						'addtime' => $_W['slwl']['datetime']['now'],
					);

					$res = pdo_insert('slwl_aicard_formid', $formid_data);

					$ids += $res;
				}
			}
			if ($res >= 0) {
				@putlog('通用收集form_id', $formid_data);
				return $this->result(0, 'ok');
			} else {
				@putlog('通用收集form_id-添加记录操作失败');
				return $this->result(1, '操作失败');
			}
		} else {
			@putlog('通用收集form_id-用户不存在');
			return $this->result(1, '用户不存在');
		}
	}

	// 通用-AI操作记录
	public function doPageSL_send_operation()
	{
		global $_GPC, $_W;

		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];
		$card_id = $_GPC['pid']; // 卡片ID

		$param_json = $_GPC['__input']; // 参数
		if ($param_json) {
			// 版本
			// $ver = isset($param_json['ver']) ? $param_json['ver'] : '';
			// 用户ID
			// $uid = isset($param_json['uid']) ? $param_json['uid'] : '';
			// 名片ID
			// $card_id = isset($param_json['pid']) ? $param_json['pid'] : '';
			// 资源ID
			$id_resource = isset($param_json['id']) ? $param_json['id'] : '';
			// 操作代码
			$op_code = isset($param_json['code']) ? $param_json['code'] : '';
		}

		// dump($op_code);exit;

		if (empty($ver)) { return $this->result(1, '版本号为空'); }
		if (empty($uid)) { return $this->result(1, '用户为空'); }
		if (empty($card_id)) { return $this->result(1, '名片为空'); }

		// 用户信息
		$condition_user = " AND uniacid=:uniacid AND id=:id ";
		$params_user = array(':uniacid' => $_W['uniacid'], ':id' => $uid);
		$one_user = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_users') . ' WHERE 1 ' . $condition_user, $params_user);

		if (empty($one_user)) { return $this->result(1, '用户不存在'); }

		// 卡片信息
		$condition_card = " AND uniacid=:uniacid AND enabled='1' AND id=:id ";
		$params_card = array(':uniacid' => $_W['uniacid'], ':id' => $card_id);
		$one_card = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition_card, $params_card);

		if (empty($one_card)) { return $this->result(1, '名片不存在'); }

		// 没使用
		// slwl-000028 = '复制微信';
		// slwl-000029 = '名片置顶';
		// slwl-000024 = '取消点赞';
		// slwl-000027 = '打开商城我的';
		// slwl-000032 = '动态点赞';
		// slwl-000014 = '浏览带分类文章列表-页数';
		// slwl-000015 = '浏览带分类文章列表(更多)-页数';

		$op_txt = '未知操作';
		switch ($op_code) {
			case 'slwl-000001':
				$op_txt = '转发名片';
				break;
			case 'slwl-000002':
				$op_txt = '点赞';
				break;
			case 'slwl-000003':
				$op_txt = '复制个人信息';
				break;
			case 'slwl-000004':
				$op_txt = '查看名片';
				break;
			case 'slwl-000005':
				$op_txt = '同步通信录';
				break;
			case 'slwl-000006':
				$op_txt = '拨打公司电话';
				break;
			case 'slwl-000007':
				$op_txt = '连接到别小程序';
				break;
			case 'slwl-000008':
				$op_txt = '打开官网';
				break;
			case 'slwl-000009':
				$op_txt = '拨打个人电话';
				break;
			case 'slwl-000010':
				$op_txt = '打开导航';
				break;
			case 'slwl-000011':
				$condition = " AND uniacid=:uniacid AND id=:id ";
				$params = array(':uniacid' => $_W['uniacid'], 'id' => $id_resource);
				$one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_website_act_news') . ' WHERE 1 ' . $condition, $params);

				$op_txt = '浏览官网文章-'.$one['title'];
				break;
			case 'slwl-000012':
				$condition = " AND uniacid=:uniacid AND id=:id ";
				$params = array(':uniacid' => $_W['uniacid'], 'id' => $id_resource);
				$one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_adact') . ' WHERE 1 ' . $condition, $params);

				$op_txt = '浏览单页面-'.$one['title'];
				break;
			case 'slwl-000013':
				$op_txt = '浏览官网文章列表';
				break;
			case 'slwl-000016':
				$op_txt = '打开产品中心';
				break;
			case 'slwl-000017':
				$condition = " AND uniacid=:uniacid AND id=:id ";
				$params = array(':uniacid' => $_W['uniacid'], 'id' => $id_resource);
				$one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_product_list') . ' WHERE 1 ' . $condition, $params);

				$op_txt = '浏览产品-'.$one['title'];
				break;
			case 'slwl-000018':
				$op_txt = '打开商城首页';
				break;
			case 'slwl-000019':
				$condition = " AND uniacid=:uniacid AND id=:id ";
				$params = array(':uniacid' => $_W['uniacid'], 'id' => $id_resource);
				$one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_store_goods') . ' WHERE 1 ' . $condition, $params);

				$op_txt = '浏览商品详情-'.$one['title'];
				break;
			case 'slwl-000020':
				$condition_collect_goods = " AND uniacid=:uniacid AND from_user=:from_user AND id=:id ";
				$params_collect_goods = array(':uniacid' => $_W['uniacid'], ':from_user'=>$uid, ':id'=>$id_resource);
				$one_collect = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_store_collect') . ' WHERE 1 '
					. $condition_collect_goods, $params_collect_goods);

				$condition_goods = " AND uniacid=:uniacid AND id=:id ";
				$params_goods = array(':uniacid' => $_W['uniacid'], ':id'=>$one_collect['goodsid']);
				$one = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_store_goods') . ' WHERE 1 '
					. $condition_goods, $params_goods);

				$op_txt = '收藏商品-'.$one['title'];
				break;
			case 'slwl-000021':
				$condition_collect_goods = " AND uniacid=:uniacid AND from_user=:from_user AND id=:id ";
				$params_collect_goods = array(':uniacid' => $_W['uniacid'], ':from_user'=>$uid, ':id'=>$id_resource);
				$one_collect = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_store_collect') . ' WHERE 1 '
					. $condition_collect_goods, $params_collect_goods);

				$condition_goods = " AND uniacid=:uniacid AND id=:id ";
				$params_goods = array(':uniacid' => $_W['uniacid'], ':id'=>$one_collect['goodsid']);
				$one = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_store_goods') . ' WHERE 1 '
					. $condition_goods, $params_goods);

				$op_txt = '取消收藏商品-'.$one['title'];
				break;
			case 'slwl-000022':
				$op_txt = '创建订单';
				break;
			case 'slwl-000023':
				$condition = " AND uniacid=:uniacid AND id=:id ";
				$params = array(':uniacid'=>$_W['uniacid'], ':id'=>$id_resource);
				$one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_store_order') . ' WHERE 1 ' . $condition, $params);

				$op_txt = '订单已付款-'.$one['ordersn'];
				break;
			case 'slwl-000025':
				$op_txt = '打开商城分类列表';
				break;
			case 'slwl-000026':
				$op_txt = '打开商城购物车';
				break;
			case 'slwl-000030':
				$op_txt = '评论动态留言';
				break;
			case 'slwl-000031':
				$op_txt = '打开动态';
				break;
			case 'slwl-000033':
				$condition = " AND uniacid=:uniacid AND id=:id ";
				$params = array(':uniacid' => $_W['uniacid'], 'id' => $id_resource);
				$one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_dynamic_act') . ' WHERE 1 ' . $condition, $params);

				$op_txt = '浏览动态文章-'.$one['title'];
				break;
			default:
				$op_txt = '未知操作';
				break;
		}

		$s_data = array(
			'op_user'=>$one_user['openid'],
			'op_avatar'=>$one_user['avatar'],
			'op_user_name'=>$one_user['nicename'],
			'openid'=>$one_user['openid'],
			'verwxapp'=>$ver,

			'opid'=>$op_code,
			'optxt'=>$op_txt,
			'op_obj'=>$one_card['userid'],
			'op_obj_name'=>$one_card['last_name'].$one_card['first_name'],
		);
		$rst = send_op_msg($s_data);

		$s_data['rst'] = $rst;
		@putlog('发送操作', $s_data);

		$acc_data = array(
			'last_time'=>$_W['slwl']['datetime']['now'],
		);
		$rst_acc = @pdo_update('slwl_aicard_users', $acc_data, ['id'=>$one_user['id']]);

		if ($rst['errcode'] == '0') {
			return $this->result(0, '发送成功');
		} else {
			return $this->result(1, '发送失败');
		}
	}

	// 反向代理img
	public function doPageSL_proxy_img()
	{
		global $_GPC, $_W;

		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];
		$url = $_GPC['url'];

		$url = urldecode($url);
		$rst = get_proxy_img($url);
		if ($rst) {
			return $this->result(1, $rst);
		}
		exit;
	}

	// 点赞-印象
	public function doPageSL_impression_islike()
	{
		global $_GPC, $_W;
		$ver = $_GPC['ver'];
		$uid = $_GPC['uid'];
		$pid = intval($_GPC['pid']);
		$im_id = intval($_GPC['im_id']); // 印象ID

		$curr_datatime = $_W['slwl']['datetime']['now'];

		$islike = $_GPC['like'] == 'true' ? '1' : '0'; // 点赞状态

		// 用户信息
		$condition_user = " AND uniacid=:uniacid AND id=:id ";
		$params_user = array(':uniacid' => $_W['uniacid'], ':id' => $uid);
		$one_user = pdo_fetch("SELECT * FROM " . tablename('slwl_aicard_users') . ' WHERE 1 ' . $condition_user, $params_user);

		if (empty($one_user)) { return $this->result(1, '用户ID不能为空'); }

		// 查询名片记录
		$condition_card = " AND uniacid=:uniacid AND enabled='1' AND id=:id ";
		$params_card = array(':uniacid' => $_W['uniacid'], ':id' => $pid);
		$one_card = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_card') . ' WHERE 1 ' . $condition_card, $params_card);

		if (empty($one_card)) { return $this->result(1, '名片不能为空'); }

		// 查询点赞记录
		$condition = " AND uniacid=:uniacid AND user_id=:user_id AND card_id=:card_id AND impression_id=:impression_id ";
		$params = array(':uniacid' => $_W['uniacid'], ':user_id' => $uid, ':card_id' => $pid, ':impression_id' => $im_id);
		$one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_impression_like') . ' WHERE 1 ' . $condition, $params);

		if ($islike == '1') {
			if (empty($one)) {
				$data_like = array(
					'uniacid' => $_W['uniacid'],
					'user_id' => $uid,
					'card_id' => $pid,
					'impression_id' => $im_id,
					'addtime' => $curr_datatime,
				);
				$rst = pdo_insert('slwl_aicard_impression_like', $data_like);
				if ($rst !== false) {
					$rst_impression = pdo_query("UPDATE " . tablename('slwl_aicard_impression')
						. " set `like_count`=`like_count`+1 WHERE id=:id ", array(':id'=>$im_id));

					if ($rst_impression !== false) {
						return $this->result(0, '成功');
					} else {
						return $this->result(2, '失败');
					}
				} else {
					return $this->result(1, '失败');
				}

			} else {
				return $this->result(0, '没有取消操作1');
			}
		} else {
			if ($one) {
				$rst_card = pdo_query("UPDATE " . tablename('slwl_aicard_impression')
					. " set `like_count`=`like_count`-1 WHERE id=:id ", array(':id'=>$pid));

				if ($rst !== false) {
					$rst_card = pdo_delete('slwl_aicard_impression_like', array('id'=>$one['id']));

					if ($rst_card !== false) {
						return $this->result(0, '成功');
					} else {
						return $this->result(2, '失败');
					}
				} else {
					return $this->result(1, '失败');
				}
			} else {
				return $this->result(0, '没有取消操作2');
			}
		}
	}

	// 新方法.end



	// 新版商城.start

	// 测试方法
	public function doPageStore_test()
	{
		store_test();
	}

	// 新版商城-首页
	public function doPageStore_index_data()
	{
		store_index_data();
	}

	// 新版商城-商品详情
	public function doPageStore_good_detail()
	{
		store_good_detail();
	}

	// 新版商城-返回所有一级分类
	public function doPageStore_category_top()
	{
		store_category_top();
	}

	// 新版商城-返回指定分类下的子分类
	public function doPageStore_category_sub()
	{
		store_category_sub();
	}

	// 新版商城-获取指定分类下的商品
	public function doPageStore_goods_list()
	{
		store_goods_list();
	}

	// 新版商城-搜索
	public function doPageStore_search()
	{
		store_search();
	}

	// // 新版商城-支付
	// public function doPageStore_pay()
	// {
	//     store_pay();
	// }

	// 新版商城-收藏
	public function doPageStore_collect()
	{
		store_collect();
	}

	// 新版商城-地址
	public function doPageStore_address()
	{
		store_address();
	}

	// 新版商城-优惠券，列表
	public function doPageStore_coupon()
	{
		store_coupon();
	}

	// 新版商城-我的优惠券，列表
	public function doPageStore_coupon_my()
	{
		store_coupon_my();
	}

	// 新版商城-我的购物车
	public function doPageStore_cart()
	{
		store_cart();
	}

	// 新版商城-品牌商
	public function doPageStore_brand()
	{
		store_brand();
	}

	// 新版商城-品牌商-只获取一条
	public function doPageStore_brand_one()
	{
		store_brand_one();
	}

	// 新版商城-获取指定品牌商的商品
	public function doPageStore_brand_one_goods()
	{
		store_brand_one_goods();
	}

	// 新版商城-获取商品规格-价格
	public function doPageStore_spec_price()
	{
		store_spec_price();
	}
	// 新版商城-订单详情
	public function doPageStore_order()
	{
		store_order();
	}
	// 新版商城.end


	// 商城分销.start
	// 分销中心
	public function doPageSL_store_com_center()
	{
		sl_store_commission_center();
	}

	// 分销佣金
	public function doPageSL_store_com_brokerage()
	{
		sl_store_commission_brokerage();
	}
	// 分销佣金-明细
	public function doPageSL_store_com_brokerage_log()
	{
		sl_store_commission_brokerage_log();
	}
	// 提现-明细
	public function doPageSL_store_com_withdraw_log()
	{
		sl_store_commission_withdraw_log();
	}
	// 我的下线列表
	public function doPageSL_store_my_downline()
	{
		sl_store_commission_my_downline();
	}
	// 提现-post
	public function doPageSL_store_withdraw_post()
	{
		sl_store_withdraw_post();
	}
	// 商城分销.end

















	// 品牌，商品
	public function doPageSmk_brand_goods()
	{
		global $_GPC, $_W;

		$list = array();
		if ($_GPC['id']) {
			$id = intval($_GPC['id']);

			$condition = " AND weid=:weid AND brandid=:brandid ";
			$params = array(':weid' => $_W['uniacid'], ':brandid'=>$id);
			$pindex = max(1, intval($_GPC['page']));
			$psize = 10;
			$sql = "SELECT id,title,thumb,price FROM " . tablename('slwl_aicard_shop_goods'). ' WHERE 1 '
				. $condition . " ORDER BY displayorder DESC, id ASC LIMIT " . ($pindex - 1) * $psize .',' .$psize;
			$list = pdo_fetchall($sql, $params);

			foreach ($list as $k => $v) {
				$list[$k]['thumb_url'] = tomedia($v['thumb']);
			}
		}

		return $this->result(0, 'ok', $list);
	}
	// brand，只获取一条
	public function doPageSmk_brand_one()
	{
		global $_GPC, $_W;
		$id = intval($_GPC['id']);

		$condition = " AND uniacid=:uniacid AND enabled='1' AND id=:id ";
		$params = array(':uniacid' => $_W['uniacid'], ':id'=>$id);
		$one = pdo_fetch('SELECT * FROM ' . tablename('slwl_aicard_shop_brand') . ' WHERE 1 '
			. $condition . '  ORDER BY displayorder DESC, id DESC', $params);

		if ($one) {
			$one['image_brand_url'] = tomedia($one['thumb_brand']);
		}

		$res = array(
			'one'=>$one,
		);

		return $this->result(0, 'ok', $res);
	}

}

?>
