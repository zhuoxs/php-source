<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

class StoreModuleSite extends WeModuleSite {
	public $modulename = 'store';
	private $left_menus;

	public function __construct() {
		global $_W, $_GPC;
		if ($_GPC['c'] == 'site') {
			checklogin();
		}
		load()->model('store');
		load()->model('user');
		$this->store_setting = (array)$_W['setting']['store'];
		$this->left_menus = $this->leftMenu();
	}

	public function storeIsOpen() {
		global $_W;
		if (user_is_founder($_W['uid'], true)) {
			return true;
		}
		if ($this->store_setting['status'] == 1) {
			message('商城已被创始人关闭！', referer(), 'error');
		}
		if (!empty($_W['username']) && !empty($this->store_setting['permission_status']) && empty($this->store_setting['permission_status']['close'])) {
			if (!in_array($_W['username'], (array)$this->store_setting['whitelist']) && !empty($this->store_setting['permission_status']['whitelist']) ||
				in_array($_W['username'], (array)$this->store_setting['blacklist']) && !empty($this->store_setting['permission_status']['blacklist'])) {
				message('您无权限进入商城，请联系管理员！', referer(), 'error');
			}
		}
		return true;
	}

	public function getTypeName($type) {
		$sign = array(
			STORE_TYPE_MODULE => '公众号应用',
			STORE_TYPE_ACCOUNT => '公众号个数',
			STORE_TYPE_WXAPP => '小程序个数',
			STORE_TYPE_WXAPP_MODULE => '小程序应用',
			STORE_TYPE_PACKAGE => '应用权限组',
			STORE_TYPE_API => '应用访问流量(API)',
			STORE_TYPE_ACCOUNT_RENEW => '公众号续费',
			STORE_TYPE_WXAPP_RENEW => '小程序续费',
			STORE_TYPE_USER_PACKAGE => '用户权限组',
			STORE_TYPE_ACCOUNT_PACKAGE => '账号权限组',
		);
		return $sign[$type];
	}

	public function payResult($params) {
		global $_W;
		if($params['result'] == 'success' && $params['from'] == 'notify') {
			$order = pdo_get('site_store_order', array('id' => $params['tid'], 'type' => 1));
			if(!empty($order)) {
				$goods = pdo_get('site_store_goods', array('id' => $order['goodsid']));
				$history_order_endtime = pdo_getcolumn('site_store_order', array('goodsid' => $goods['id'], 'buyerid' => $order['buyerid'], 'uniacid' => $order['uniacid'], 'type' => STORE_ORDER_FINISH), 'max(endtime)');
				$endtime = strtotime('+' . $order['duration'] . $goods['unit'], max($history_order_endtime, time()));
				pdo_update('site_store_order', array('type' => 3, 'endtime' => $endtime), array('id' => $params['tid']));
				if (in_array($goods['type'], array(STORE_TYPE_ACCOUNT_RENEW, STORE_TYPE_WXAPP_RENEW))) {
					$account_type = $goods['type'] == STORE_TYPE_ACCOUNT_RENEW ? 'uniacid' : 'wxapp';
					$account_num = $goods['type'] == STORE_TYPE_ACCOUNT_RENEW ? $goods['account_num'] : $goods['wxapp_num'];
					$account_info = uni_fetch($order[$account_type]);
					$account_endtime = strtotime('+' . $order['duration'] * $account_num . $goods['unit'], max(TIMESTAMP, $account_info['endtime']));
					pdo_update('account', array('endtime' => $account_endtime), array('uniacid' => $order[$account_type]));
					$store_create_account_info = table('store')->StoreCreateAccountInfo($order[$account_type]);
					if (!empty($store_create_account_info)) {
						$endtime = strtotime('+' . $order['duration'] * $account_num . $goods['unit'], max(TIMESTAMP, $store_create_account_info['endtime']));
						pdo_update('site_store_create_account', array('endtime' => $endtime), array('uniacid' => $order[$account_type]));
					}
					pdo_update('account', array('endtime' => $account_endtime), array('uniacid' => $order[$account_type]));
					cache_delete(cache_system_key('uniaccount_type', array('account_type' => $order[$account_type])));
				}
				cache_delete(cache_system_key('site_store_buy', array('type' => $goods['type'], 'uniacid' => $order['uniacid'])));
				if ($goods['type'] == STORE_TYPE_USER_PACKAGE) {
					cache_delete(cache_system_key('system_frame', array('uniacid' => $_W['uniacid'])));
				}
				cache_build_account_modules($order['uniacid']);

				store_add_cash_order($order['id']);
			}
		}
		if($params['result'] == 'success' && $params['from'] == 'return') {
			header('Location: ' . $_W['siteroot'] . $this->createWebUrl('orders', array('direct' => 1)));
		}
	}

	public function doWebPaySetting() {
		$this->storeIsOpen();
		global $_W, $_GPC;
		if (!user_is_founder($_W['uid'], true)) {
			itoast('', referer(), 'info');
		}
		$operate = $_GPC['operate'];
		$operates = array('alipay', 'wechat');
		$operate = in_array($operate, $operates) ? $operate : 'alipay';

		$_W['page']['title'] = '支付设置 - 商城';
		$settings = $_W['setting']['store_pay'];

		if (checksubmit('submit')) {
			if ($operate == 'alipay') {
				$settings['alipay'] = array(
					'switch' => intval($_GPC['switch']),
					'account' => trim($_GPC['account']),
					'partner' => trim($_GPC['partner']),
					'secret' => trim($_GPC['secret']),
				);
			} elseif ($operate == 'wechat') {
				if ($_GPC['switch'] == 1 && (empty($_GPC['appid']) || empty($_GPC['mchid']) || empty($_GPC['signkey']))) {
					itoast('请完善支付设置。', referer(), 'info');
				}
				$settings['wechat'] = array(
					'switch' => intval($_GPC['switch']),
					'appid' => $_GPC['appid'],
					'mchid' => $_GPC['mchid'],
					'signkey' => $_GPC['signkey'],
				);
			}
			setting_save($settings, 'store_pay');
			itoast('设置成功！', referer(), 'success');
		}
		if ($operate == 'alipay') {
			$alipay = $settings['alipay'];
		} elseif ($operate == 'wechat') {
			$wechat = $settings['wechat'];
		}
		include $this->template('paysetting');
	}

	public function doWebOrders() {
		$this->storeIsOpen();
		global $_GPC, $_W;
		load()->model('module');
		load()->model('message');

		$operates = array('display', 'change_price', 'delete');
		$operate = $_GPC['operate'];
		$operate = in_array($operate, $operates) ? $operate : 'display';

		$_W['page']['title'] = '订单管理 - 商城';
		if (user_is_vice_founder()) {
			$role = 'buyer';
		} elseif (!empty($_W['isfounder'])) {
			$role = 'seller';
		} else {
			$role = 'buyer';
		}

		if ($operate == 'display') {
			if (user_is_founder($_W['uid']) && !user_is_vice_founder($_W['uid'])) {
				$message_id = $_GPC['message_id'];
				message_notice_read($message_id);
			}

			$pindex = max(1, intval($_GPC['page']));
			$psize = 15;

			$store_table = table('store');
			if (isset($_GPC['type']) && intval($_GPC['type']) > 0) {
				$order_type = intval($_GPC['type']);
				$store_table->searchOrderType($order_type);
			}

			$store_table->searchWithOrderid($_GPC['orderid']);
			if (empty($_W['isfounder']) || user_is_vice_founder()) {
				$store_table->searchOrderWithUid($_W['uid']);
			}
			$order_list = $store_table->searchOrderList($pindex, $psize);
			$total = $store_table->getLastQueryTotal();
			$pager = pagination($total, $pindex, $psize);
			if (!empty($order_list)) {
				foreach ($order_list as $key => &$order) {
					if (empty($_W['isfounder']) && $order['type'] == 2) {
						unset($order_list[$key]);
						continue;
					}
					if (!empty($order['uniacid'])) {
						$order['account'] = uni_fetch($order['uniacid']);
					}
					$order['createtime'] = date('Y-m-d H:i:s', $order['createtime']);
					$order['abstract_amount'] = $order['duration'] * $order['goods_info']['price'];
					$order['goods_info'] = store_goods_info($order['goodsid']);
					if (!empty($order['goods_info'])) {
						if ($order['goods_info']['type'] == STORE_TYPE_MODULE || $order['goods_info']['type'] == STORE_TYPE_WXAPP_MODULE) {
							$order['goods_info']['module_info'] = module_fetch($order['goods_info']['module']);

						} elseif ($order['goods_info']['type'] == STORE_TYPE_USER_PACKAGE) {
							$group_info = table('users_group')->getById($order['goods_info']['user_group']);
							$order['goods_info']['group_name'] = $group_info['name'];
						} elseif ($order['goods_info']['type'] == STORE_TYPE_ACCOUNT_PACKAGE) {
							$group_info = table('users_create_group')->getById($order['goods_info']['account_group']);
							$order['goods_info']['group_name'] = $group_info['group_name'];
						} elseif ($order['goods_info']['type'] == STORE_TYPE_PACKAGE) {
							$group_info = table('uni_group')->getById($order['goods_info']['module_group']);
							$order['goods_info']['group_name'] = $group_info['name'];
						}
					}
				}
				unset($order);
			}
		}

		if ($operate == 'change_price' || $operate == 'delete') {
			if (!user_is_founder($_W['uid'], true)) {
				iajax(-1, '无权限更改！');
			}
			$id = intval($_GPC['id']);
			if (empty($id)) {
				itoast('订单错误，请刷新后重试！');
			}
			$order_info = store_order_info($id);
			if (empty($order_info)) {
				itoast('订单不存在！');
			}
		}
		if ($operate == 'change_price') {
			$price = floatval($_GPC['price']);
			$result = store_order_change_price($id, $price);
			if (!empty($result)) {
				iajax(0, '修改成功！');
			} else {
				iajax(-1, '修改失败！');
			}
		}

		if ($operate == 'delete') {
			if ($order_info['type'] != STORE_ORDER_PLACE) {
				itoast('只可删除未完成交易的订单！');
			}
			$result = store_order_delete($id);
			if (!empty($result)) {
				itoast('删除成功！', referer(), 'success');
			} else {
				itoast('删除失败，请稍候重试！', referer(), 'error');
			}
		}
		include $this->template('orders');
	}

	public function doWebSetting() {
		$this->storeIsOpen();
		global $_GPC, $_W;
		if (!user_is_founder($_W['uid'], true)) {
			itoast('', referer(), 'info');
		}
		$operate = $_GPC['operate'];
		$operates = array('store_status', 'menu');
		$operate = in_array($operate, $operates) ? $operate : 'store_status';

		$_W['page']['title'] = '商城设置 - 商城';
		$settings = $this->store_setting;
		if ($operate == 'store_status') {
			if (checksubmit('submit')) {
				$status = intval($_GPC['status']) > 0 ? 1 : 0;
				$settings['status'] = $status;
				setting_save($settings, 'store');
				itoast('更新设置成功！', referer(), 'success');
			}
		}
		if ($operate == 'menu') {
			$left_menu = $this->leftMenu();
			$goods_menu = !empty($left_menu['store_goods']) ? $left_menu['store_goods']['menu'] : array();
			if (checksubmit('submit')) {
				foreach ($goods_menu as $key => $menu) {
					$settings[$key] = intval($_GPC['hide'][$key]) > 0 ? 1 : 0;
				}
				setting_save($settings, 'store');
				itoast('更新设置成功！', referer(), 'success');
			}
		}
		include $this->template('storesetting');
	}

	public function doWebCashSetting() {
		$this->storeIsOpen();
		global $_GPC, $_W;
		if (!user_is_founder($_W['uid'], true)) {
			itoast('', referer(), 'info');
		}
		$_W['page']['title'] = '分销设置 - 商城';
		$settings = $this->store_setting;

		if (checksubmit('submit')) {
			$settings['cash_status'] = empty($_GPC['status']) ? 0 : 1;
			$settings['cash_ratio'] = max(0, min(100, intval($_GPC['ratio'])));
			setting_save($settings, 'store');
			itoast('设置成功！', $this->createWebUrl('cashsetting', array('m' => 'store', 'direct' => 1)), 'success');
		}
		include $this->template('cash');
	}

	public function doWebGoodsSeller() {
		$this->storeIsOpen();
		global $_GPC, $_W;
		load()->model('module');
		if (!user_is_founder($_W['uid'], true)) {
			itoast('', referer(), 'info');
		}
		$operate = $_GPC['operate'];
		$operates = array('display', 'delete', 'changestatus');
		$operate = in_array($operate, $operates) ? $operate : 'display';
		$type = intval($_GPC['type']) > 0 ? intval($_GPC['type']) : STORE_TYPE_MODULE;

		$_W['page']['title'] = '商品列表 - 商城管理 - 商城';
		if ($operate == 'display') {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 15;

			$store_table = table('store');
			$keyword = trim($_GPC['keyword']);
			if (!empty($keyword)) {
				$store_table->searchWithKeyword($keyword);
			}
			$status = isset($_GPC['online']) && $_GPC['online'] == 0 ? 0 : 1;
			$store_table->searchWithStatus($status);
			if(isset($_GPC['letter']) && strlen($_GPC['letter']) == 1) {
				$store_table->searchWithLetter($_GPC['letter']);
			}
			$search_type = $type;
			if ($type == STORE_TYPE_MODULE) {
				$search_type = array(STORE_TYPE_MODULE, STORE_TYPE_WXAPP_MODULE);
			} elseif ($type == STORE_TYPE_ACCOUNT) {
				$search_type = array(STORE_TYPE_ACCOUNT, STORE_TYPE_WXAPP);
			} elseif ($type == STORE_TYPE_ACCOUNT_RENEW) {
				$search_type = array(STORE_TYPE_ACCOUNT_RENEW, STORE_TYPE_WXAPP_RENEW);
			}
			$goods_list = $store_table->searchGoodsList($search_type, $pindex, $psize);
			$total = $goods_list['total'];
			$goods_list = $goods_list['goods_list'];
			$pager = pagination($total, $pindex, $psize);
			if (!empty($goods_list)) {
				foreach ($goods_list as &$good) {
					$good['module_info'] = module_fetch($good['module']);
				}
				unset($good);
			}
			$module_list = array();
			if (in_array($type, array(STORE_TYPE_MODULE, STORE_TYPE_WXAPP_MODULE))) {				$modules = user_modules($_W['uid']);
				$modules = array_filter($modules, function($module) {
					return empty($module['issystem']);
				});
				if (!empty($modules)) {
					$have_module_goods = array();
					$have_goods = $store_table->searchHaveModule($search_type);
					if (!empty($have_goods)) {
						foreach ($have_goods as $item) {
							$have_module_goods[$item['module']][] = $item['type'];
						}
					}
					foreach ($modules as $name => $module) {
						if (!empty($have_module_goods[$name])) {
							if (in_array(STORE_TYPE_MODULE, $have_module_goods[$name])) {
								$module[MODULE_SUPPORT_ACCOUNT_NAME] = 1;
							}
							if (in_array(STORE_TYPE_WXAPP_MODULE, $have_module_goods[$name])) {
								$module[MODULE_SUPPORT_WXAPP_NAME] = 1;
							}
						}
						if ($module[MODULE_SUPPORT_ACCOUNT_NAME] != 2 && $module[MODULE_SUPPORT_WXAPP_NAME] != 2) {
							continue;
						}
						$module_list[] = $module;
					}
				}
			} elseif ($type == STORE_TYPE_PACKAGE) {
				$groups = uni_groups();
			} elseif ($type == STORE_TYPE_USER_PACKAGE) {
				$user_groups = pdo_fetchall("SELECT * FROM " . tablename('users_group'), array(), 'id');
				$user_groups = user_group_format($user_groups);
			} elseif ($_GPC['type'] == STORE_TYPE_ACCOUNT_PACKAGE) {
				$account_groups = table('users_create_group')->getall('id');
			}
		}

		if ($operate == 'changestatus' || $operate == 'delete') {
			$id = intval($_GPC['id']);
			$if_exist = store_goods_info($id);
			if (empty($if_exist)) {
				itoast('商品不存在，请刷新后重试！', referer(), 'error');
			}
		}
		if ($operate == 'changestatus') {
			$result = store_goods_changestatus($id);
			if (!empty($result)) {
				itoast('更新成功！', referer(), 'success');
			} else {
				itoast('更新失败！', referer(), 'error');
			}
		}

		if ($operate == 'delete') {
			$result = store_goods_delete($id);
			if (!empty($result)) {
				itoast('删除成功！', referer(), 'success');
			} else {
				itoast('删除失败！', referer(), 'error');
			}
		}
		include $this->template('goodsseller');
	}

	public function doWebGoodsPost() {
		$this->storeIsOpen();
		global $_GPC, $_W;
		if (!user_is_founder($_W['uid'], true)) {
			itoast('', referer(), 'info');
		}
		$operate = $_GPC['operate'];
		$operates = array('post', 'add');
		$operate = in_array($operate, $operates) ? $operate : 'post';
		$type = max(intval($_GPC['type']), STORE_TYPE_MODULE);
		$_W['page']['title'] = '编辑商品 - 商城管理 - 商城';

        $user_groups = pdo_getall('users_group');

		if ($operate == 'post') {
			$id = intval($_GPC['id']);
			if (checksubmit('submit')) {
				if (!empty($_GPC['price']) && !is_numeric($_GPC['price'])) {
					itoast('价格有误，请填写有效数字！', referer(), 'error');
				}
				$user_group_price = array();
				if (!empty($_GPC['user_group_price']) && !empty($_GPC['user_group_id']) && count($_GPC['user_group_price']) == count($_GPC['user_group_id'])) {
				    foreach ($_GPC['user_group_price'] as $k => $value) {
				        if (empty($value) || empty($_GPC['user_group_id'][$k])) {
				            continue;
                        }
                        $value = trim($value);
                        if (!is_numeric($value)) {
                            itoast('价格有误，请填写有效数字！', referer(), 'error');
                        }
                        $user_group_price[intval($_GPC['user_group_id'][$k])] = array(
                            'group_id' => $_GPC['user_group_id'][$k],
                            'group_name' => $_GPC['user_group_name'][$k],
                            'price' => $value,
                        );
                    }
                }
				$type_title = $this->getTypeName($type);
				$data = array(
					'unit' => safe_gpc_string($_GPC['unit']),
					'account_num' => intval($_GPC['account_num']),
					'wxapp_num' => intval($_GPC['wxapp_num']),
					'module_group' => intval($_GPC['module_group']),
					'account_group' => intval($_GPC['account_group']),
					'user_group' => intval($_GPC['user_group']),
					'type' => $type,
					'title' => empty($_GPC['title']) ? $type_title : safe_gpc_string($_GPC['title']),
					'price' => floatval($_GPC['price']),
					'user_group_price' => iserializer($user_group_price),
					'slide' => !empty($_GPC['slide']) ? iserializer($_GPC['slide']) : '',
					'api_num' => intval($_GPC['api_num']),
					'description' => safe_gpc_html(htmlspecialchars_decode($_GPC['description'])),
				);
				if ($type == STORE_TYPE_API) {
					$data['title'] = '应用访问流量(API)';
				}
				if ($type == STORE_TYPE_PACKAGE) {
					$data['title'] = '应用权限组';
				}
				if ($type == STORE_TYPE_USER_PACKAGE) {
					$data['title'] = '用户权限组';
				}
				if ($_GPC['submit'] == '保存并上架') {
					$data['status'] = 1;
				}
				if (!empty($id)) {
					$data['id'] = $id;
				}

				$result = store_goods_post($data);
				if (!empty($result)) {
					$redirect_type = $type;
					if ($type == STORE_TYPE_WXAPP) {
						$redirect_type = STORE_TYPE_ACCOUNT;
					} elseif ($type == STORE_TYPE_WXAPP_MODULE) {
						$redirect_type = STORE_TYPE_MODULE;
					} elseif ($type == STORE_TYPE_WXAPP_RENEW) {
						$redirect_type = STORE_TYPE_ACCOUNT_RENEW;
					}
					if (!empty($id)) {
						itoast('编辑成功！', $this->createWebUrl('goodsseller', array('direct' =>1, 'type' => $redirect_type, 'online' => $data['status'])), 'success');
					} else {
						itoast('添加成功！', $this->createWebUrl('goodsSeller', array('direct' =>1, 'type' => $redirect_type)), 'success');
					}
				} else {
					itoast('未作任何更改或编辑/添加失败！', referer(), 'error');
				}
			}

			if (!empty($id)) {
				$goods_info = store_goods_info($id);
				$goods_info['slide'] = !empty($goods_info['slide']) ? (array)iunserializer($goods_info['slide']) : array();
				$goods_info['price'] = floatval($goods_info['price']);
                $goods_info['user_group_price'] = empty($goods_info['user_group_price']) ?  array() : iunserializer($goods_info['user_group_price']);
			}
			if ($type == STORE_TYPE_PACKAGE) {
				$module_groups = uni_groups();
			}
			if ($type == STORE_TYPE_USER_PACKAGE) {
				$user_groups = user_group_format($user_groups);
			}
			if ($type == STORE_TYPE_ACCOUNT_PACKAGE) {
				$account_groups = table('users_create_group')->getall('id');
			}
		}
		if ($operate == 'add') {
			if (empty($_GPC['module']) && $type == STORE_TYPE_MODULE) {
				iajax(-1, '请选择一个模块！');
			}
			$data = array(
				'type' => $type,
				'title' => !empty($_GPC['module']['title']) ? trim($_GPC['module']['title']) : trim($_GPC['title']),
				'module' => !empty($_GPC['module']['name']) ? trim($_GPC['module']['name']) : '',
				'synopsis' => !empty($_GPC['module']['ability']) ? trim($_GPC['module']['ability']) : '',
				'description' => !empty($_GPC['module']['description']) ? trim($_GPC['module']['description']) : '',
				'api_num' => is_numeric($_GPC['visit_times']) ? intval($_GPC['visit_times']) : 0,
				'price' => is_numeric($_GPC['price']) ? floatval($_GPC['price']) : 0,
				'status' => !empty($_GPC['online']) ? STATUS_ON : STATUS_OFF,
			);
			$result = store_goods_post($data);
			if (!empty($result)) {
				if (isset($_GPC['toedit']) && !empty($_GPC['toedit'])) {
					$id = pdo_insertid();
					iajax(0, $id);
				} else {
					iajax(0, '添加成功！');
				}
			} else {
				iajax(-1, '添加失败！');
			}
		}
		include $this->template('goodspost');
	}

	public function doWebGoodsBuyer() {
		$this->storeIsOpen();
		global $_GPC, $_W;
		load()->model('module');
		load()->model('payment');
		load()->model('message');
		load()->func('communication');
		load()->library('qrcode');
		$operate = $_GPC['operate'];
		$operates = array ('display', 'goods_info', 'get_expiretime', 'submit_order', 'pay_order');
		$operate = in_array($operate, $operates) ? $operate : 'display';
		$_W['page']['title'] = '商品列表 - 商城';

		if ($operate == 'display') {
			$store_table = table('store');
			$pageindex = max(intval($_GPC['page']), 1);
			$pagesize = 24;
			$type = intval($_GPC['type']);
			if (!in_array($type, array(STORE_TYPE_MODULE, STORE_TYPE_ACCOUNT, STORE_TYPE_WXAPP, STORE_TYPE_WXAPP_MODULE, STORE_TYPE_PACKAGE, STORE_TYPE_API, STORE_TYPE_ACCOUNT_RENEW, STORE_TYPE_WXAPP_RENEW, STORE_TYPE_USER_PACKAGE, STORE_TYPE_ACCOUNT_PACKAGE))) {
				$type = STORE_TYPE_MODULE;
			}
			$search_type = $type;
			if ($type == STORE_TYPE_MODULE) {
				$module_name = safe_gpc_string($_GPC['module_name']);
				if (!empty($module_name)) {
					$store_table->searchWithKeyword($module_name);
				}

				$module_type = intval($_GPC['module_type']);
				if (empty($module_type)) {
					$search_type = array(STORE_TYPE_MODULE, STORE_TYPE_WXAPP_MODULE);
				} else {
					$search_type = $module_type;
				}
			} elseif ($type == STORE_TYPE_ACCOUNT) {
				$search_type = array(STORE_TYPE_ACCOUNT, STORE_TYPE_WXAPP);
			} elseif ($type == STORE_TYPE_ACCOUNT_RENEW) {
				$search_type = array(STORE_TYPE_ACCOUNT_RENEW, STORE_TYPE_WXAPP_RENEW);
			}

			$store_table->searchWithStatus(1);
			$store_table = $store_table->searchGoodsList($search_type, $pageindex, $pagesize);
			$store_goods = $store_table['goods_list'];
						if (!user_is_founder($_W['uid']) && !empty($_W['user']['groupid'])) {
                foreach ($store_goods as $key => &$goods) {
                    $goods['user_group_price'] = iunserializer($goods['user_group_price']);
                    if (!empty($goods['user_group_price'][$_W['user']['groupid']]['price'])) {
                        $goods['price'] = $goods['user_group_price'][$_W['user']['groupid']]['price'];
                    }
                }
                unset($goods);
            }
			if (in_array($type, array(STORE_TYPE_MODULE, STORE_TYPE_WXAPP_MODULE)) && is_array($store_goods)) {
				foreach ($store_goods as $key => &$goods) {
					if (empty($goods) || !in_array($goods['type'], array(STORE_TYPE_MODULE, STORE_TYPE_WXAPP_MODULE))) {
						continue;
					}
					$goods['module'] = module_fetch($goods['module']);
				}
				unset($goods);
			} elseif ($type == STORE_TYPE_PACKAGE) {
				$module_groups = uni_groups();
			} elseif ($type == STORE_TYPE_USER_PACKAGE) {
				$user_groups = pdo_fetchall("SELECT * FROM " . tablename('users_group'), array(), 'id');
				$user_groups = user_group_format($user_groups);
			} elseif ($type == STORE_TYPE_ACCOUNT_PACKAGE) {
				$account_groups = table('users_create_group')->getall('id');
			}
            $pager = pagination ($store_table['total'], $pageindex, $pagesize);
		}

		if ($operate == 'goods_info') {
			$goods = intval ($_GPC['goods']);
			if (empty($goods)) {
				itoast ('商品不存在', '', 'info');
			}
			$goods = pdo_get('site_store_goods', array ('id' => $goods));
                        if (!user_is_founder($_W['uid']) && !empty($_W['user']['groupid'])) {
                $goods['user_group_price'] = iunserializer($goods['user_group_price']);
                if (!empty($goods['user_group_price'][$_W['user']['groupid']]['price'])) {
                    $goods['price'] = $goods['user_group_price'][$_W['user']['groupid']]['price'];
                }
            }
			if (in_array($goods['type'], array(STORE_TYPE_MODULE, STORE_TYPE_WXAPP_MODULE, STORE_TYPE_API))) {
				$goods['module'] = module_fetch ($goods['module']);
				$goods['slide'] = iunserializer ($goods['slide']);
			} elseif (in_array($goods['type'], array(STORE_TYPE_ACCOUNT, STORE_TYPE_WXAPP))) {
				$goods['title'] = $goods['type'] == STORE_TYPE_ACCOUNT ? '公众号' : '小程序';
				$goods['num'] = $goods['type'] == STORE_TYPE_ACCOUNT ? $goods['account_num'] : $goods['wxapp_num'];
			} elseif ($goods['type'] == STORE_TYPE_PACKAGE) {
				$module_groups = uni_groups();
			} elseif ($goods['type'] == STORE_TYPE_USER_PACKAGE) {
				$group_info = pdo_fetch("SELECT * FROM ".tablename('users_group') . " WHERE id = :id", array(':id' => $goods['user_group']));
				$group_info['package'] = iunserializer($group_info['package']);
				if (!empty($group_info['package']) && in_array(-1, $group_info['package'])) {
					$group_info['package_all'] = true;
				}
				$module_groups = uni_groups();
				if (!empty($module_groups)) {
					foreach ($module_groups as $key => &$module) {
						if (!empty($group_info['package']) && in_array($key, $group_info['package'])) {
							$group_info['package_info'][] = $module;
						}
					}
				}
			} elseif ($goods['type'] == STORE_TYPE_ACCOUNT_PACKAGE) {
				$group_info = table('users_create_group')->searchWithId($goods['account_group'])->get();
			}
			$account_table = table ('account');
			$user_account = $account_table->userOwnedAccount();
			$wxapp_account_list = array();
			if (!empty($user_account) && is_array($user_account)) {
				foreach ($user_account as $key => $account) {
					$default_account = uni_fetch($account['uniacid']);
					if (in_array($goods['type'],  array(STORE_TYPE_MODULE, STORE_TYPE_ACCOUNT_RENEW)) && !in_array($default_account['type'], array(ACCOUNT_TYPE_OFFCIAL_NORMAL, ACCOUNT_TYPE_OFFCIAL_AUTH)) || in_array($goods['type'], array(STORE_TYPE_WXAPP_MODULE, STORE_TYPE_WXAPP_RENEW)) && !in_array($default_account['type'], array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH))) {
						unset($user_account[$key]);
					}
					if (in_array($goods['type'], array(STORE_TYPE_ACCOUNT_RENEW, STORE_TYPE_WXAPP_RENEW)) && $default_account['endtime'] <= 0) {
						unset($user_account[$key]);
					}
					if ($goods['type'] == STORE_TYPE_PACKAGE && !empty($module_groups[$goods['module_group']]['wxapp']) && $default_account['type'] == 4) {
						$wxapp_account_list[] = array('uniacid' => $default_account['uniacid'], 'name' => $default_account['name']);
						unset($user_account[$key]);
					}
				}
			}
			reset($user_account);
			reset($wxapp_account_list);
			$default_account = current($user_account);
			$default_account = !empty($_GPC['uniacid']) ? $_GPC['uniacid'] : $default_account['uniacid'];
			$default_wxapp = current($wxapp_account_list);
			$default_wxapp = !empty($_GPC['wxapp']) ? $_GPC['wxapp'] : $default_wxapp['uniacid'];
			if (in_array($goods['type'], array(STORE_TYPE_MODULE, STORE_TYPE_WXAPP_MODULE)) && empty($user_account)) {
				$type_name = $goods['type'] == STORE_TYPE_MODULE ? '公众号' : '小程序';
				itoast("您没有可操作的{$type_name}，请先创建{$type_name}后购买模块.", referer(), 'info');
			}
			$pay_way = array();
			if (!empty($_W['setting']['store_pay']) && is_array($_W['setting']['store_pay']) && ($_W['setting']['store_pay']['alipay']['switch'] == 1 || $_W['setting']['store_pay']['wechat']['switch'] == 1)) {
				foreach ($_W['setting']['store_pay'] as $way =>  $setting) {
					if ($setting['switch'] == 1) {
						$pay_way[$way] = $setting;
						if ($way == 'alipay') {
							$pay_way[$way]['title'] = '支付宝';
						} elseif ($way == 'wechat') {
							$pay_way[$way]['title'] = '微信';
						}
					}
				}
			} else {
				itoast('没有有效的支付方式.', referer(), 'info');
			}
		}

		if ($operate == 'get_expiretime') {
			$duration = intval ($_GPC['duration']);
			$date = date ('Y-m-d', strtotime ('+' . $duration . $_GPC['unit'], time ()));
			iajax (0, $date);
		}

		if ($operate == 'submit_order') {
			$uniacid = intval ($_GPC['uniacid']);
			$wxapp = intval ($_GPC['wxapp']);
			$goodsid = intval($_GPC['goodsid']);

			if (intval($_GPC['duration']) <= 0) {
				iajax(-1, '购买时长不合法，请重新填写！');
			}

			$pay_type = safe_gpc_string($_GPC['type']);
			if (empty($pay_type)) {
				iajax(-1, '请选择支付方式。');
			}
			if (empty($goodsid)) {
				iajax(-1, '参数错误！');
			}
			$user_account = table('account')->userOwnedAccount();
			$goods_info = store_goods_info($goodsid);
                        if (!user_is_founder($_W['uid']) && !empty($_W['user']['groupid'])) {
                $goods_info['user_group_price'] = iunserializer($goods_info['user_group_price']);
                if (!empty($goods_info['user_group_price'][$_W['user']['groupid']]['price'])) {
                    $goods_info['price'] = $goods_info['user_group_price'][$_W['user']['groupid']]['price'];
                }
            }
			if (in_array($goods_info['type'], array(STORE_TYPE_MODULE, STORE_TYPE_WXAPP_MODULE, STORE_TYPE_API, STORE_TYPE_ACCOUNT_RENEW, STORE_TYPE_WXAPP_RENEW))) {
				if (empty($uniacid)) {
					iajax(-1, '请选择公众号！');
				}
				if (empty($user_account[$uniacid])) {
					iajax(-1, '非法公众号！');
				}
			}
			if ($goods_info['type'] == STORE_TYPE_PACKAGE) {
				if (empty($uniacid) && empty($wxapp)) {
					iajax(-1, '请选择公众号！');
				}
				if (!empty($uniacid) && (empty($user_account[$uniacid]) || in_array($user_account[$uniacid]['type'], array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH, ACCOUNT_TYPE_WXAPP_WORK)))) {
					iajax(-1, '非法公众号！');
				}
				if (!empty($wxapp) && (empty($user_account[$wxapp]) || !in_array($user_account[$wxapp]['type'], array(ACCOUNT_TYPE_APP_NORMAL, ACCOUNT_TYPE_APP_AUTH, ACCOUNT_TYPE_WXAPP_WORK)))) {
					iajax(-1, '非法小程序！');
				}
			}
			if (empty($goods_info)) {
				iajax(-1, '商品不存在！');
			}
			$uid = empty($_W['uid']) ? '000000' : sprintf ("%06d", $_W['uid']);
			$orderid = date ('YmdHis') . $uid . random (8, 1);
			$duration = intval ($_GPC['duration']);
			$order = array (
				'orderid' => $orderid,
				'duration' => $duration,
				'amount' => $goods_info['price'] * $duration,
				'goodsid' => $goodsid,
				'buyer' => $_W['user']['username'],
				'buyerid' => $_W['uid'],
				'type' => STORE_ORDER_PLACE,
				'createtime' => time(),
				'uniacid' => $uniacid,
				'wxapp' => $wxapp
			);
			if (in_array($goods_info['type'], array(STORE_TYPE_WXAPP, STORE_TYPE_WXAPP_RENEW))) {
				$order['wxapp'] = $order['uniacid'];
				$order['uniacid'] = 0;
			}
			if (in_array($goods_info['type'], array(STORE_TYPE_ACCOUNT, STORE_TYPE_WXAPP, STORE_TYPE_USER_PACKAGE, STORE_TYPE_ACCOUNT_PACKAGE))) {
				$order['uniacid'] = $order['wxapp'] = 0;
			}
			if (in_array($goods_info['type'], array(STORE_TYPE_ACCOUNT, STORE_TYPE_WXAPP, STORE_TYPE_MODULE, STORE_TYPE_WXAPP_MODULE, STORE_TYPE_PACKAGE, STORE_TYPE_USER_PACKAGE, STORE_TYPE_ACCOUNT_PACKAGE))) {
				$history_order_endtime = pdo_getcolumn('site_store_order', array('goodsid' => $goodsid, 'buyerid' => $_W['uid'], 'uniacid' => $order['uniacid'], 'type' => STORE_ORDER_FINISH), 'max(endtime)');
				$order['endtime'] = strtotime('+' . $duration . $goods_info['unit'], max($history_order_endtime, time()));
			}

			pdo_insert ('site_store_order', $order);
			$store_orderid = pdo_insertid();

			message_notice_record($_W['config']['setting']['founder'], MESSAGE_ORDER_TYPE, array(
				'orderid' => $orderid,
				'username' => $_W['user']['username'],
				'goods_name' => $this->getTypeName($goods_info['type']),
				'money' => $order['amount']
			));
			pdo_insert('core_paylog', array(
				'type' => $pay_type,
				'uniontid' => $orderid,
				'tid' => $store_orderid,
				'fee' => $order['amount'],
				'card_fee' => $order['amount'],
				'module' => 'store'
			));
			iajax (0, $store_orderid);
		}

		if ($operate == 'pay_order') {
			$orderid = intval ($_GPC['orderid']);
			$order = pdo_get ('site_store_order', array ('id' => $orderid));
			$goods = pdo_get ('site_store_goods', array ('id' => $order['goodsid']));
			if (empty($order)) {
				itoast ('订单不存在', referer (), 'info');
			}
			if ($order['type'] != 1) {
				$message = $order['type'] == 2 ? '订单已删除.' : '订单已付款成功';
				itoast ($message, referer (), 'info');
			} else {
				if ($order['amount'] == 0) {
					$history_order_endtime = pdo_getcolumn('site_store_order', array('goodsid' => $goods['id'], 'buyerid' => $_W['uid'], 'uniacid' => $order['uniacid'], 'type' => STORE_ORDER_FINISH), 'max(endtime)');
					$endtime = strtotime('+' . $order['duration'] . $goods['unit'], max($history_order_endtime, time()));
					pdo_update('site_store_order', array('type' => 3, 'endtime' => $endtime), array('id' => $order['id']));
					pdo_update('core_paylog', array('status' => 1), array('uniontid' => $order['orderid']));
					if (in_array($goods['type'], array(STORE_TYPE_ACCOUNT_RENEW, STORE_TYPE_WXAPP_RENEW))) {
						$account_type = $goods['type'] == STORE_TYPE_ACCOUNT_RENEW ? 'uniacid' : 'wxapp';
						$account_num = $goods['type'] == STORE_TYPE_ACCOUNT_RENEW ? $goods['account_num'] : $goods['wxapp_num'];
						$account_info = uni_fetch($order[$account_type]);
						$account_endtime = strtotime('+' . $order['duration'] * $account_num . $goods['unit'], max(TIMESTAMP, $account_info['endtime']));
						pdo_update('account', array('endtime' => $account_endtime), array('uniacid' => $order[$account_type]));
						cache_delete(cache_system_key('uniaccount_type', array('account_type' => $order[$account_type])));
					}
					if ($goods['type'] == STORE_TYPE_USER_PACKAGE) {
						$data['uid'] = $_W['uid'];
						$user = user_single($data['uid']);
						if ($user['status'] == USER_STATUS_CHECK || $user['status'] == USER_STATUS_BAN) {
							iajax(-1, '访问错误，该用户未审核或者已被禁用，请先修改用户状态！', '');
						}
						$data['groupid'] = $goods['user_group'];
						$data['endtime'] = $order['endtime'];
						cache_delete(cache_system_key('system_frame', array('uniacid' => $_W['uniacid'])));
						if (!user_update($data)) {
							iajax(1, '修改权限失败', '');
						}
					}
					cache_build_account_modules($order['uniacid']);
					message_notice_record($_W['config']['setting']['founder'], MESSAGE_ORDER_PAY_TYPE, array(
						'orderid' => $orderid,
						'username' => $_W['user']['username'],
						'money' => $order['amount']
					));

					itoast('支付成功!', $this->createWebUrl('orders', array('direct' => 1)), 'success');
				}
			}
			$setting = setting_load ('store_pay');
			$core_paylog = pdo_get('core_paylog', array('module' => 'store', 'status' => 0, 'module' => 'store', 'uniontid' => $order['orderid'], 'tid' => $order['id']));
			if ($core_paylog['type'] == 'wechat') {
				$wechat_setting = $setting['store_pay']['wechat'];
				$params = array(
					'pay_way' => 'web',
					'title' => $goods['title'],
					'uniontid' => $order['orderid'],
					'fee' => $order['amount'],
					'goodsid' => $goods['id'],
				);
				$wechat_setting['version'] = 2;
				$wechat_result = wechat_build($params, $wechat_setting);
				if (is_error($wechat_result)) {
					itoast($wechat_result['message'], $this->createWebUrl('goodsBuyer', array('direct' => 1)), 'info');
				}
				file_delete('store_wechat_pay_' . $_W['uid'] . '.png');
				$picture_attach = 'store_wechat_pay_' . $_W['uid'] . '.png';
				$picture = $_W['siteroot'] . 'attachment/' . $picture_attach;
				QRcode::png($wechat_result['code_url'], ATTACHMENT_ROOT . $picture_attach);
				include $this->template('wechat_pay_qrcode');
			} elseif ($core_paylog['type'] == 'alipay') {
				$alipay_setting = $setting['store_pay']['alipay'];
				$alipay_params = array (
					'service' => 'create_direct_pay_by_user',
					'title' => $goods['title'],
					'fee' => $order['amount'],
					'uniontid' => $order['orderid'],
				);
				$alipay_result = alipay_build($alipay_params, $alipay_setting);
				header ('Location: ' . $alipay_result['url']);
			}
			exit();
		}
		include $this->template ('goodsbuyer');
	}

	public function doWebPermission() {
		global $_W, $_GPC;
		$this->storeIsOpen();
		if (!user_is_founder($_W['uid'], true)) {
			itoast('', referer(), 'info');
		}
		$operation = trim($_GPC['operation']);
		$operations = array('display', 'post', 'delete', 'change_status');
		$operation = in_array($operation, $operations) ? $operation : 'display';

		$blacklist = (array)$this->store_setting['blacklist'];
		$whitelist = (array)$this->store_setting['whitelist'];
		$permission_status = (array)$this->store_setting['permission_status'];

		if ($operation == 'display') {
			include $this->template('permission');
		}

		if ($operation == 'post') {
			$username = safe_gpc_string($_GPC['username']);
			$type = in_array($_GPC['type'], array('black', 'white')) ? $_GPC['type'] : '';
			if (empty($type)) {
				message(error(-1, '参数错误！'), referer(), 'ajax');
			}
			$user_exist = pdo_get('users', array('username' => $username));
			if (empty($user_exist)) {
				message(error(-1, '用户不存在！'), $this->createWebUrl('permission', array('type' => $type, 'direct' =>1)), 'ajax');
			}
			if (in_array($username, $blacklist)) {
				message(error(-1, '用户已在黑名单中！'), $this->createWebUrl('permission', array('type' => $type, 'direct' =>1)), 'ajax');
			}
			if (in_array($username, $whitelist)) {
				message(error(-1, '用户已在白名单中！'), $this->createWebUrl('permission', array('type' => $type, 'direct' =>1)), 'ajax');
			}
			if ($type == 'black') {
				array_push($blacklist, $username);
				$this->store_setting['blacklist'] = $blacklist;
			}
			if ($type == 'white') {
				array_push($whitelist, $username);
				$this->store_setting['whitelist'] = $whitelist;
			}
			setting_save($this->store_setting, 'store');
			cache_build_frame_menu();
			message(error(0, '更新成功！'), $this->createWebUrl('permission', array('type' => $type, 'direct' =>1)), 'ajax');
		}

		if ($operation == 'change_status') {
			$status_type = intval($_GPC['status_type']);
			$permission_status = array(
				'blacklist' => false,
				'whitelist' => false,
				'close' => false,
			);
			if ($status_type == 1) {
				$permission_status['close'] = true; 			} elseif ($status_type == 2) {
				$permission_status['whitelist'] = true;
			} else {
				$permission_status['blacklist'] = true;
			}
			$this->store_setting['permission_status'] = $permission_status;
			setting_save($this->store_setting, 'store');
			cache_build_frame_menu();
			itoast('更新成功！', $this->createWebUrl('permission', array('type' => $type, 'direct' => 1)));
		}

		if ($operation == 'delete') {
			$username = safe_gpc_string($_GPC['username']);
			$type = in_array($_GPC['type'], array('black', 'white')) ? $_GPC['type'] : '';
			if (empty($username) || empty($type)) {
				message(error(-1, '参数错误！'), referer(),'ajax');
			}
			if ($type == 'white') {
				if (!in_array($username, $whitelist)) {
					message(error(-1, '用户不在白名单中！'), $this->createWebUrl('permission', array('type' => $type, 'direct' =>1)), 'ajax');
				}
				foreach ($whitelist as $key => $val) {
					if ($val == $username) {
						unset($whitelist[$key]);
					}
				}
				$this->store_setting['whitelist'] = $whitelist;
			}
			if ($type == 'black') {
				if (!in_array($username, $blacklist)) {
					message(error(-1, '用户不在黑名单中！'), $this->createWebUrl('permission', array('type' => $type, 'direct' =>1)), 'ajax');
				}
				foreach ($blacklist as $key => $val) {
					if ($val == $username) {
						unset($blacklist[$key]);
					}
				}
				$this->store_setting['blacklist'] = $blacklist;
			}
			setting_save($this->store_setting, 'store');
			cache_build_frame_menu();
			message(error(0, '删除成功！'), $this->createWebUrl('permission', array('type' => $type, 'direct' =>1)), 'ajax');
		}
	}

	public function leftMenu() {
		$this->storeIsOpen();
		load()->model('system');
		$system_menu = system_menu();
		$menu = $system_menu['store']['section'];
		return $menu;
	}

	public function doWebPay() {
		$this->storeIsOpen();
		global $_GPC, $_W;
		$operate = $_GPC['operate'];
		$operates = array ('check_pay_result');
		$operate = in_array ($operate, $operates) ? $operate : 'check_pay_result';

		if ($operate == 'check_pay_result') {
			$orderid = intval($_GPC['orderid']);
			$pay_type = pdo_getcolumn('site_store_order', array('id' => $orderid), 'type');
			if ($pay_type == STORE_ORDER_FINISH) {
				iajax(1);
			} else {
				iajax(2);
			}
		}
	}

	public function doWebPayments() {
		global $_W, $_GPC;
		$pindex = max(1, $_GPC['page']);
		$pagesize = 20;
		$store_table = table('store');
		$payments_list = $store_table->searchPaymentsOrder();
		$pager = pagination(count($payments_list), $pindex, $pagesize);
		$payments_list = array_slice($payments_list, ($pindex - 1) * $pagesize, $pagesize);
		include $this->template ('goodspayments');
	}

	public function doWebChangeOrderExpire() {
		global $_GPC, $_W;
		$uniacid = intval($_GPC['uniacid']);
		$goodsid = intval($_GPC['goodsid']);
		$duration = intval($_GPC['duration']);
		$unit = safe_gpc_string($_GPC['unit']);
		if (empty($uniacid) || empty($goodsid) && empty($duration) && empty($unit)) {
			iajax(-1, '提交数据不完整!');
		}
		$endtime_old = pdo_getcolumn('site_store_order', array('goodsid' => $goodsid, 'buyerid' => $_W['uid'], 'uniacid' => $uniacid, 'type' => STORE_ORDER_FINISH), 'max(endtime)');
		$endtime_new = strtotime('+' . $duration . $unit, max($endtime_old, time()));
		iajax(0, date('Y-m-d H:i:s', $endtime_new));
	}

	public function doWebDeactivateOrder() {
		global $_GPC;
		$order_id = intval($_GPC['order_id']);
		$goods_id = intval($_GPC['goods_id']);
		$uniacid = intval($_GPC['uniacid']);
		$type = intval($_GPC['type']);

		$condition = array('id' => $order_id, 'goodsid' => $goods_id, 'uniacid' => $uniacid);
		$order_info = pdo_get('site_store_order', $condition, '');

		if (empty($order_info)) {
			itoast('订单信息错误！', '', 'error');
		}

		$res = pdo_update('site_store_order', array('type' => STORE_ORDER_DEACTIVATE), $condition);
		if (!$res) {
			itoast('修改失败！', '', 'error');
		} else{
			$cachekey = cache_system_key('site_store_buy', array('type' => $type, 'uniacid' => $uniacid));
			cache_delete($cachekey);
			itoast('修改成功！', '', 'success');
		}
	}

	public function doWebCash() {
		global $_W, $_GPC;
		if (!user_is_founder($_W['uid'])) {
			message('无访问权限!');
		}
		if (empty($this->store_setting['cash_status'])) {
			message('未开启分销!');
		}
		$operate = $_GPC['operate'];
		$operates = array ('cash_orders', 'order_detail', 'mycash', 'cash_logs', 'log_detail', 'apply_cash', 'consume_order');
		$operate = in_array($operate, $operates) ? $operate : 'cash_orders';
		$_W['page']['title'] = '分销 - 商城';
		$page = max(1, intval($_GPC['page']));
		$psize = 15;

		if (user_is_vice_founder()) {
			if ($operate == 'cash_orders') {
				$_W['page']['title'] = '分销订单 - 商城';
				$condition = array();
				if (!empty($_GPC['number'])) {
					$condition['number'] = safe_gpc_string($_GPC['number']);
				}
				$get_cash_orders = 1;
			}
			if ($operate == 'mycash') {
				$_W['page']['title'] = '我的佣金 - 商城';
				$condition = array('status' => array(1, 3));
				$can_cash_amount = store_get_founder_can_cash_amount($_W['uid'], true);
				$get_cash_orders = 1;
			}

			if (!empty($get_cash_orders)) {
				$condition['founder_uid'] = $_W['uid'];
				$data = store_get_cash_orders($condition, $page, $psize);
				$cash_orders = $data['list'];
				$pager = pagination($data['total'], $page, $psize);
			}

			if ($operate == 'order_detail') {
				$_W['page']['title'] = '订单详情 - 商城';
				$id = intval($_GPC['id']);
				$cash_order = pdo_get('site_store_cash_order', array('id' => $id));
				$cash_order['goods'] = store_goods_info($cash_order['goods_id']);
				if (in_array($cash_order['goods']['type'], array(STORE_TYPE_MODULE, STORE_TYPE_WXAPP_MODULE))) {
					$cash_order['goods']['goods'] = module_fetch($cash_order['goods']['module']);
					$cash_order['goods']['type'] = $cash_order['goods']['type'];
				}
				$cash_order['order'] = store_order_info($cash_order['order_id']);
			}

			if ($operate == 'apply_cash') {
				$result = store_add_cash_log($_W['uid']);
				if (is_error($result)) {
					itoast($result['message'], '', 'error');
				}
				itoast('申请成功', $this->createWebUrl('cash', array('direct' => 1, 'm' => 'store', 'operate' => 'cash_logs')), 'success');
			}

			if ($operate == 'cash_logs') {
				$_W['page']['title'] = '提现记录 - 商城';
				$data = store_get_cash_logs(array('founder_uid' => $_W['uid']), $page, $psize);
				$cash_logs = $data['list'];
				$pager = pagination($data['total'], $page, $psize);
			}
		} else {
			if ($operate == 'consume_order') {
				$_W['page']['title'] = '提现审核 - 商城';
				if (checksubmit('check_result')) {
					$ids = safe_gpc_array($_GPC['ids']);
					if (empty($ids)) {
						itoast('参数不能为空');
					}
					if (!in_array($_GPC['check_result'], array(2, 3))) {
						itoast('参数有误');
					}
					if (intval($_GPC['check_result']) == 2) {
						$log_status = 2;
						$order_status = 4;
					} else {
						$log_status = $order_status = 3;
					}
					foreach ($ids as $id) {
						pdo_update('site_store_cash_log', array('status' => $log_status), array('id' => $id, 'status' => 1));
						pdo_update('site_store_cash_order', array('status' => $order_status), array('cash_log_id' => $id, 'status' => 2));
					}
					itoast('操作成功');
				}
				$condition = array();
				if (!empty($_GPC['status'])) {
					$condition['status'] = intval($_GPC['status']);
				}
				if (!empty($_GPC['number'])) {
					$condition['number'] = safe_gpc_string($_GPC['number']);
				}
				$data = store_get_cash_logs($condition, $page, $psize);
				$cash_logs = $data['list'];
				$pager = pagination($data['total'], $page, $psize);
			}
		}
		if ($operate == 'log_detail') {
			$_W['page']['title'] = '提现详情 - 商城';
			$id = intval($_GPC['id']);
			$log = pdo_get('site_store_cash_log', array('id' => $id));
			if ($log['founder_uid'] == $_W['uid']) {
				$founder = $_W['user'];
			} else {
				$founder = table('users')->getById($log['founder_uid']);
			}
			$data = store_get_cash_orders(array('cash_log_id' => $id), $page, $psize);
			$cash_orders = $data['list'];
			$pager = pagination($data['total'], $page, $psize);
		}
		include $this->template('cash');
	}
}