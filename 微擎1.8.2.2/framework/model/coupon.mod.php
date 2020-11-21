<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
function coupon_colors($name, $value = 'Color082', $options = array()) {
	empty($name) && ($name = 'coupon_color');
	if (!defined('TPL_INIT_COUPON_COLOR')) {
		$html .= '
		<script type="text/javascript">
			function showCouponColor(eml) {
				var dropdown = $(eml).parent().parent().next();
				dropdown.show();
				$(document).click(function(){
					dropdown.hide();
				});
				$(".coupon-color").click(function(e){
					e.stopPropagation();
				});
				$(".dropdown-menu li").click(function(){
					$(eml).parent().prev().css("background", $(this).attr("data-color"));
					$(eml).parent().prev().css("border-color", $(this).attr("data-color"));
					$(eml).parent().prev().prev().prev().val($(this).attr("data-name"));
					$(eml).parent().prev().prev().val($(this).attr("data-color"));
					dropdown.hide();
					$(document).unbind("click");
					$(".dropdown-menu li, .coupon-color").unbind("click");
				});
			}

		</script>';
		define('TPL_INIT_COUPON_COLOR', true);
	}

	$html .= '
		<div class="col-sm-9 col-xs-12 coupon-color" style="position: relative;width:200px;">
			<div class="input-group" style="width:200px;">
				<input type="text" class="form-control" name="'.$name.'" value="'.$value.'"/>
				<input type="hidden" name="'.$name.'-value" class="form-control" value="'.$value.'"/>
				<span class="input-group-addon" style="width:35px;background:'.$options[$value]['value'].'"></span>
				<span class="input-group-btn">
					<button class="btn btn-default" type="button" onclick="showCouponColor(this);">选择颜色</button>
				</span>
			</div>
			<div class="dropdown-menu" style="display:none;padding:6px 0 0 6px;width:185px;position: absolute;top:35px;left:15px">
				<ul style="padding:0">
			';
	if(!empty($options)) {
		foreach($options as $option) {
			$html .= '<li data-name="'.$option['name'].'" data-color="'.$option['value'].'" style="padding: 0;margin-right:5px;margin-bottom:5px;width:30px;height:30px;background:'.$option['value'].';float:left;list-style: none;"></li>';
		}
	}
	$html .= '
				</ul>
			</div>
		</div>
		';
	return $html;
}

function  url_name_type(){
	$url_name_type = array(
		'URL_NAME_TYPE_TAKE_AWAY' => '外卖',
		'URL_NAME_TYPE_RESERVATION' => '在线预定',
		'URL_NAME_TYPE_USE_IMMEDIATELY' => '立即使用',
		'URL_NAME_TYPE_APPOINTMENT' => '在线预约',
		'URL_NAME_TYPE_EXCHANGE' => '在线兑换',
		'URL_NAME_TYPE_VIP_SERVICE' => '会员服务 (仅会员卡 类型可用)',
	);
	return $url_name_type;
}

function coupon_fetch($id, $format = true) {
	global $_W;
	$id = intval($id);
	$item = pdo_fetch('SELECT * FROM ' . tablename('coupon') . ' WHERE uniacid = :aid AND id = :id', array(':aid' => $_W['uniacid'], ':id' => $id));
	if(empty($item)) {
		return error(-1, '卡券不存在或已删除');
	}
		if(!$format) {
		return $item;
	} else {
		$item['location-select'] = '';
		$item['location_count'] = 0;
		if(!empty($item['location_id_list'])) {
			$item['location_id_list'] = @iunserializer($item['location_id_list']);
			foreach($item['location_id_list'] as $lic) {
				$item['location_data'][] = pdo_fetch('SELECT business_name, address, location_id FROM ' . tablename('activity_stores') . ' WHERE uniacid = :aid AND location_id = :lid', array(':aid' => $_W['uniacid'], ':lid' => $lic), 'location_id');
			}
			$item['location_count'] = count($item['location_id_list']);
			if(!empty($item['location_id_list'])) {
				$item['location-select'] = implode('-', $item['location_id_list']);
			}
		}
		$item['date_info'] = iunserializer($item['date_info']);
		$item['logo_url'] = media2local($item['logo_url']);
		$item['discount_f'] = (100 - $item['discount']) / 10;
		if($item['type'] == 'cash') {
			$item['extra'] = iunserializer($item['extra']);
			$item['least_cost'] = $item['extra']['least_cost'];
			$item['reduce_cost'] = $item['extra']['reduce_cost'];
		}
		if($item['type'] == 'discount' || $item['type'] == 'cash') {
			$item['modules'] = pdo_fetchall('SELECT a.*, b.title FROM ' . tablename('coupon_modules') . ' AS a LEFT JOIN ' . tablename('modules') . ' AS b ON a.module = b.name WHERE a.cid = :id', array(':id' => $id));
		}
	}
	return $item;
}

function coupon_delete($id) {
	global $_W;
	$id = intval($id);
	$item = pdo_fetch('SELECT acid,id,card_id FROM ' . tablename('coupon') . ' WHERE uniacid = :aid AND id = :id', array(':aid' => $_W['uniacid'], ':id' => $id));
	if(empty($item)) {
		return error(-1, '卡券不存在或已经删除');
	}
	if(empty($item['card_id'])) {
		pdo_delete('coupon', array('id' => $id, 'uniacid' => $_W['uniacid']));
		return true;
	}
		$coupon = new coupon($item['acid']);
	$return = $coupon->DeleteCard($item['card_id']);
	if(is_error($return)) {
		return $return;
	}
	pdo_delete('coupon', array('id' => $id, 'uniacid' => $_W['uniacid']));
	return true;
}

function coupon_modifystock($id, $num) {
	global $_W;
	$id = intval($id);
	$num = intval($num);
	$item = pdo_fetch('SELECT acid,id,card_id,quantity FROM ' . tablename('coupon') . ' WHERE uniacid = :aid AND id = :id', array(':aid' => $_W['uniacid'], ':id' => $id));
	if(empty($item)) {
		return error(-1, '卡券不存在或已经删除');
	}
	if(empty($item['card_id'])) {
		return error(-1, '卡券id出错');
	}
		$num_tmp = $num - $item['quantity'];
	$coupon = new coupon($item['acid']);
	$return = $coupon->ModifyStockCard($item['card_id'], $num_tmp);
	if(is_error($return)) {
		return $return;
	}
	pdo_update('coupon', array('quantity' => $num), array('id' => $id, 'uniacid' => $_W['uniacid']));
	return true;
}

function coupon_qr($data) {
	global $_W;
	$id = intval($data['id']);
	$item = pdo_fetch('SELECT acid,id,card_id FROM ' . tablename('coupon') . ' WHERE uniacid = :aid AND id = :id', array(':aid' => $_W['uniacid'], ':id' => $id));
	if(empty($item)) {
		return error(-1, '卡券不存在或已经删除');
	}
	if(empty($item['card_id'])) {
		return error(-1, '卡券id出错');
	}
	$coupon = new coupon($item['acid']);
	$qrcode = array(
		'action_name' => 'QR_CARD',
		'expire_seconds' => "{$data['expire_seconds']}",
		'action_info' => array(
			'card' => array(
				'card_id' => $item['card_id'],
				'code' => '',
				'openid' => '',
				'is_unique_code' => false,
				'outer_id' => $data['outer_id']
			)
		)
	);
	$return = $coupon->QrCard($qrcode);
	return $return;
}

function coupon_status() {
	return array(
		'CARD_STATUS_NOT_VERIFY' => 1, 		'CARD_STATUS_VERIFY_FAIL' => 2, 		'CARD_STATUS_VERIFY_OK' => 3, 		'CARD_STATUS_USER_DELETE' => 4,
		'CARD_STATUS_DELETE' => 4,		'CARD_STATUS_USER_DISPATCH' => 5, 		'CARD_STATUS_DISPATCH' => 5, 	);
}
