<?php
			global $_GPC, $_W;
			file_put_contents(IA_ROOT."/addons/tiger_wxdaili/inc/mobile/log1.txt","\n dddo1ld:".json_encode($_GPC),FILE_APPEND); 
			//任务分享注册
			$cfg=$this->module['config'];
			$uid=$_GPC['uid'];
			if(empty($uid)){
				$result = array("errcode" => 1, "errmsg" => '用户信息不存在1');
				die(json_encode($result));
			}
			$member=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$uid}'");
			//结束
			$price=$_GPC['price'];
			if (empty($member)) {
					$result = array("errcode" => 1, "errmsg" => '用户信息不存在2');
					die(json_encode($result));
			}
			$usernames =$_GPC['tname'];
			$tel = $_GPC['tel'];
			$weixin = $_GPC['weixin'];
			$dlmsg = $_GPC['dlmsg'];
			$dlgetpay=$_GPC['day3'];
			$desc = $member['nickname'].$_GPC['tname'].'团长费用';//说明
			$bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
			
			$appset= pdo_fetch("SELECT * FROM " . tablename("tiger_app_tuanzhangset") . " WHERE weid='{$_W['uniacid']}' order by px desc ");
			
			//$fee = floatval($appset['rmb']);//付款金额
			$fee = floatval($_GPC['rmb']);//付款金额
			
			//支付
			$system = $this->module['config'];
			$url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
			$random = random(8);
			$orderno = $this->randorder();
			$trade_type = 'JSAPI';
			$thisappid = $_W['account']['key'];
			//Return $result = array("errcode" => 1, "errmsg" =>'aaaa');
			$post = array('appid' => $system['appid'], 'mch_id' => $system['mchid'], 'nonce_str' => $random, 'body' => $desc, 'out_trade_no' => $orderno, 'total_fee' => $fee * 100, 'spbill_create_ip' => $system['ip'], 'notify_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/payment/wechat/pay.php', 'trade_type' => $trade_type, 'openid' => $member['from_user']);
			ksort($post);
			$string = $this->ToUrlParams($post);
			$string .= "&key={$system['apikey']}";
			$sign = md5($string);
			$post['sign'] = strtoupper($sign);
			$resp = $this->postXmlCurl($this->ToXml($post), $url);
			libxml_disable_entity_loader(true);
			$resp = json_decode(json_encode(simplexml_load_string($resp, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
			if ($resp['result_code'] != 'SUCCESS') {
					$result=array('errcode' => 1, 'errmsg' => $resp['return_msg']);
			} else {
				      //插入订单
							//$orderid = addOrder($member, $post, $goods_id);//返回订单号
							$fee = $post['total_fee'] / 100;
							$data = array(
									'weid' => $_W['uniacid'], 
									'ddtype'=>1,//团长支付订单
									'tzday'=>$dlgetpay,//团长支付天数
									'orderno' => $post['out_trade_no'], 
									'goods_id' => $goods_id, 
									'price' => $fee, 
									'memberid' => $member['id'], 
									'openid' => $member['from_user'], 
									'nickname' => $member['nickname'], 
									'avatar' => $member['avatar'],
									'tel'=>$member['tel'],
									'cengji'=>0,
									'usernames'=>$member['nickname'],
									'msg'=>$member['nickname'].'团长费用',
									'createtime' =>time()
							 );
							//file_put_contents(IA_ROOT."/addons/tiger_wxdaili/log.txt","\n dddo1ld:".json_encode($data),FILE_APPEND); 
							pdo_insert($this->modulename."_order", $data);
							$orderid = pdo_insertid();
							//插入订单结束
							
							$params = $this->getWxPayJsParams($resp['prepay_id']);
							$result = array("errcode" => 0, "auth" => 0, "timeStamp" => $params['timeStamp'], "nonceStr" => $params['nonceStr'], "package" => $params['package'], "signType" => $params['signType'], "paySign" => $params['paySign'], "orderno" => $orderno, "orderid" => $orderid);
					//return $result;
			}
			die(json_encode($result));

			
?>