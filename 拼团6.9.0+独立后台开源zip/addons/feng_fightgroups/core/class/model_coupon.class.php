<?php
	class model_coupon {
		
		static function activity_enable($activity_name){
			$activities = array('reward','present','coupon');
			return in_array($activity_name, $activities);
		}
		
		 static function coupon_template_all() {
			global $_W;
			$coupon_template_all = pdo_fetchall("SELECT * FROM ".tablename('tg_coupon_template')."WHERE uniacid = {$_W['uniacid']} ORDER BY id DESC");
			
			cache_write($cache_key, $coupon_template_all);
			return $coupon_template_all;
		}
		
		 static function coupon_template($coupon_template_id) {
			$coupon_template = pdo_fetch("SELECT * FROM ".tablename('tg_coupon')."WHERE id = {$coupon_template_id}");
			return $coupon_template;
		}
		 static function coupon_templates($coupon_template_id) {
			$coupon_template = pdo_fetch("SELECT * FROM ".tablename('tg_coupon_template')."WHERE id = {$coupon_template_id}");
			return $coupon_template;
		}
		
		 static function coupon_check($openid, $coupon_template_id){
			global $_W;
			$tatal1 = pdo_fetchall("SELECT coupon_template_id FROM ".tablename('tg_coupon')."WHERE openid = '{$openid}' and  coupon_template_id = '{$coupon_template_id}' and  uniacid= '{$_W['uniacid']}'");
			$tatal = count($tatal1);
			return $tatal;
		}
		
		 static function coupon_canuse($openid, $payprice,$goodsid){
			global $_W;
			$where3 = "SELECT * FROM ".tablename('tg_coupon').' WHERE `openid` = :openid AND `use_time` = :use_time AND `start_time` < :now1 AND `end_time` > :now2  ORDER BY `end_time` DESC ';
			$params3 = array(
				':openid' => $openid,
				':use_time' => 0,
				':now1' => TIMESTAMP,
				':now2' => TIMESTAMP
			);
			$coupon3 = pdo_fetchall($where3, $params3);
			
			if(empty($coupon3)){
				return;
			}
			foreach ($coupon3 as $key3 => $value3) {
				$congoodid = pdo_getcolumn('tg_coupon_template',array('id'=>$value3['coupon_template_id']),'goodsid');
				if($congoodid && $congoodid != $goodsid){
					unset($coupon3[$key3]);
					continue;
				}
				if($value3['cash'] > $payprice){
					unset($coupon3[$key3]);
					continue;
				}
				if($value3['is_at_least'] == 2 && $value3['at_least'] > $payprice){
				
					unset($coupon3[$key3]);
					continue;
				}
				$coupon3[$key3]['end_time'] = date('Y-m-d', $value3['end_time']);
			}
			if($coupon3){
				$i=0;
				foreach($coupon3 as $key=>$value){
					$coupon[$i] = $value;
					$i+=1;
				}
			}
			
			return $coupon;
		}
		
		 static function coupon_grant($openid, $coupon_template_id){
			global $_W;
			
			$flag = self::activity_enable('coupon');
			if (!$flag) {
				return error(1, '优惠券未开启');
			}
			$coupon_template = self::coupon_templates($coupon_template_id);
			$tatal =  self::coupon_check($openid, $coupon_template_id);
			if (empty($coupon_template)) {
				return error(1, '优惠券不存在或已删除');
			}
			if ($coupon_template['quota'] > 0 && $tatal >= $coupon_template['quota']) {
				return error(1, '超过领取数量，小调皮不要贪心哦');
			}
			if ($coupon_template['total'] <= $coupon_template['quantity_issue']) {
				return error(1, '优惠券已发完');
			}
			if ($coupon_template['enable'] != 1) {
				return error(1, '商家停止发放优惠券');
			}
			if ($coupon_template['is_random'] == 2) {
				$cash = rand($coupon_template['value']*100, $coupon_template['value_to']*100);
				$cash = $cash/100;
			} else {
				$cash = $coupon_template['value'];
			}
			$coupon_data = array(
				'uniacid' => $_W['uniacid'],
				'coupon_template_id' => $coupon_template['id'],
				'name' => $coupon_template['name'],
				'cash' => $cash,
				'is_at_least' => $coupon_template['is_at_least'],
				'at_least' => $coupon_template['at_least'],
				'description' => $coupon_template['description'],
				'start_time' => $coupon_template['start_time'],
				'end_time' => $coupon_template['end_time'],
				'use_time' => 0,
				'openid' => $openid,
				'createtime' => TIMESTAMP
			);
			pdo_insert('tg_coupon', $coupon_data);
			$coupon_data['id'] = pdo_insertid();
			
			self::coupon_quantity_issue_increase($coupon_template['id'], 1);
			return $coupon_data;
		}
		
		
		 static function coupon($coupon_id){
			$coupon = pdo_fetch("SELECT * FROM ".tablename('tg_coupon')."WHERE id = {$coupon_id}");
			return $coupon;
		}
		
		
		 static function coupon_quantity_issue_increase($coupon_template_id, $quantity) {
			$sql = 'UPDATE '.tablename('tg_coupon_template').' SET `quantity_issue` = `quantity_issue` + :quantity WHERE id=:id';
			$params = array(
				':id' => $coupon_template_id,
				':quantity' => $quantity
			);
			pdo_query($sql, $params);
			
			return true;
		}
		
		
		 static function coupon_quantity_used_increase($coupon_template_id, $quantity) {
			$sql = 'UPDATE '.tablename('tg_coupon_template').' SET `quantity_used`=`quantity_used`+:quantity WHERE id=:id';
			$params = array(
				':id' => $coupon_template_id,
				':quantity' => $quantity
			);
			pdo_query($sql, $params);
			
			return true;
		}
		
		
		 static function coupon_handle($openid, $coupon_id, $payprice) {
			$errmsg = '无法使用优惠券: ';
			$flag = self::activity_enable('coupon');
			if (!$flag) {
				return error(1, $errmsg.'优惠券功能未启用');
			}
			$coupon = self::coupon($coupon_id);
			if (empty($coupon) || $coupon['openid'] != $openid) {
				return error(1, $errmsg.'不存在或已删除');
			}
			if ($coupon['start_time'] > TIMESTAMP ) {
				return error(1, $errmsg.'未生效');
			}
			if ($coupon['end_time'] < TIMESTAMP) {
				return error(1, $errmsg.'已失效');
			}
			if ($coupon['use_time'] != 0) {
				return error(1, $errmsg.'已使用');
			}
			if ($coupon['is_at_least'] == 2 && $payprice < $coupon['at_least']) {
				return error(1, $errmsg.'不满足使用条件,商品总价应达到'.currency_format($coupon['at_least']).'元');
			}
			return $coupon['cash'];
		}
		
}
