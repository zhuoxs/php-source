<?php
global $_GPC,$_W;
		$cfg=$this->module['config'];
        $uid=$_GPC['uid'];
        if(empty($uid)){
        	$result = array("errno" => 1, "errmsg" => '用户信息不存在1',"data"=>"");
        	die(json_encode($result));
        }
        $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$uid}'");
        $appset=pdo_fetch("select * from ".tablename('tiger_newhu_appset')." where weid='{$_W['uniacid']}'");
				$bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
        //结束
				
				
				
				
				
        $price=$_GPC['price'];
        if (empty($share)) {
            $result = array("errno" => 1, "errmsg" => '用户信息不存在2',"data"=>"");
            die(json_encode($result));
        }
        $usernames =$_GPC['tname'];
        $tel = $_GPC['tel'];
        $weixin = $_GPC['weixin'];
        $dlmsg = $_GPC['dlmsg'];
        $desc = $share['nickname'].$_GPC['tname'].'代理费用';
        $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");
        $fee = floatval($bl['dlffprice']);
       
			 //------------------------------------------------------------------------------
			$appId=trim($appset['appid']);
			$mchId=trim($appset['mchid']);
			$appkey=trim($appset['appkey']);
			$body= $share['nickname'].$_GPC['tname'].'代理费用';
			$attach='app:545';
			$totalFee=$fee*100;//金额 100=1元
			$url=$_W['siteroot'].'addons/tiger_newhu/appapi.php';
			$cIp=trim($appset['appzfip']);
			$dataArr = array(
			 'appid' => $appId,
			    'mch_id' => $mchId,
			    'nonce_str' => getNonceStr(),
			    'body' => $body,
			    'attach' => $attach,
			    'out_trade_no' => getNonceStr(),
			    'total_fee' => $totalFee,
			    'spbill_create_ip' => $cIp,
			    'notify_url' => $url,
			    'trade_type' => 'APP'
			);		
			
			
			
			//转XML格式
			function createXML($rootNode, $arr)
			{
			    //创建一个文档，文档时xml的，版本号为1.0，编码格式utf-8
			    $xmlObj = new DOMDocument('1.0', 'UTF-8');
			    //创建根节点
			    $Node = $xmlObj->createElement($rootNode);
			    //把创建好的节点加到文档中
			    $root = $xmlObj->appendChild($Node);
			    //开始把数组中的数据加入文档
			    foreach ($arr as $key => $value) {
			        //如果是$value是一个数组
			        if (is_array($value)) {
			            //先创建一个节点
			            $childNode = $xmlObj->createElement($key);
			            //将节点添加到$root中
			            $root->appendChild($childNode);
			            //循环添加数据
			            foreach ($value as $key2 => $val2) {
			                //创建节点的同时添加数据
			                $childNode2 = $xmlObj->createElement($key2, $val2);
			                //将节点添加到$childNode
			                $childNode->appendChild($childNode2);
			            }
			        } else {
			            //创建一个节点，根据键和值
			            $childNode = $xmlObj->createElement($key, $value);
			            //把节点加到根节点
			            $root->appendChild($childNode);
			        }
			    }
			    //把创建好的xml保存到本地
			 //   $xmlObj->save('xml/log.xml');
			    $str = $xmlObj->saveXML();
			//        echo $str;
			    //返回xml字符串
			    return $str;
			}
			
			
			//封装签名算法
			function MakeSign($arr,$appkey)
			{
				$key=$appkey;//'d8II1vTHlp584sdEJkyyYQVL0ks64k0d';
				
			    //签名步骤一：按字典序排序参数
			    ksort($arr);
			    $string = ToUrlParams($arr);
			    //签名步骤二：在string后加入KEY
			    $string = $string . "&key=" . $key;
			    //签名步骤三：MD5加密
			    $string = md5($string);
			    //签名步骤四：所有字符转为大写
			    $result = strtoupper($string);
			    return $result;
			}
			
			/**
			* 格式化参数格式化成url参数
			*/
			function ToUrlParams($arr)
			{
			    $buff = "";
			    foreach ($arr as $k => $v) {
			        if ($k != "sign" && $v != "" && !is_array($v)) {
			            $buff .= $k . "=" . $v . "&";
			        }
			    }
			
			    $buff = trim($buff, "&");
			    return $buff;
			}
			
			
			//随机字符串(不长于32位)
			function getNonceStr($length = 32)
			{
			    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
			    $str = "";
			    for ($i = 0; $i < $length; $i++) {
			        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			    }
			    return $str;
			}
			
			
			function curl($url, $post_data)
			{
			
			
			    $headerArray = array(
			        'Accept:application/json, text/javascript, */*',
			        'Content-Type:application/x-www-form-urlencoded',
			        'Referer:https://mp.weixin.qq.com/'
			    );
			
			    $ch = curl_init();
			    curl_setopt($ch, CURLOPT_URL, $url);
			    // 对认证证书来源的检查，0表示阻止对证书的合法性的检查。
			    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			    // 从证书中检查SSL加密算法是否存在
			    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//关闭直接输出
			    curl_setopt($ch, CURLOPT_POST, 1);//使用post提交数据
			    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);//设置 post提交的数据
			    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36');//设置用户代理
			    curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);//设置头信息
			
			
			    $loginData = curl_exec($ch);//这里会返回token，需要处理一下。
			
			
			    return $loginData;
			
			    $token = array_pop($token);
			    curl_close($ch);
			
			
			}
			
			/**
			* 解析xml文档，转化为对象
			* @param  String $xmlStr xml文档
			* @return Object         返回Obj对象
			*/
			function xmlToObject($xmlStr)
			{
			    if (!is_string($xmlStr) || empty($xmlStr)) {
			        return false;
			    }
			    // 由于解析xml的时候，即使被解析的变量为空，依然不会报错，会返回一个空的对象，所以，我们这里做了处理，当被解析的变量不是字符串，或者该变量为空，直接返回false
			    libxml_disable_entity_loader(true);
			    $postObj = json_decode(json_encode(simplexml_load_string($xmlStr, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
			    //将xml数据转换成对象返回
			    return $postObj;
			}
			
			
			
			
			//=====================执行=======================
			$sign = MakeSign($dataArr,$appkey);//签名生成
			$dataArr['sign'] = $sign;
			
			$xmlStr = createXML('xml', $dataArr);//统一下单xml数据生成
			$reArr = explode('?>', $xmlStr);
			$reArr = end($reArr);
			
			$xml = curl('https://api.mch.weixin.qq.com/pay/unifiedorder', $reArr);//发送请求 统一下单数据
			
			//解析返回的xml字符串
			$re = xmlToObject($xml);
			
			//判断统一下单是否成功
			if ($re['result_code'] == 'SUCCESS') {
			
			    //支付请求数据
			    $payData = array(
			        'appid' => $re['appid'],
			        'partnerid' => $re['mch_id'],
			        'prepayid' => $re['prepay_id'],
			        'noncestr' => getNonceStr(),
			        'package' => 'Sign=WXPay',
			        'timestamp' => time()
			    );
			
			
			    //生成支付请求的签名
			    $paySign = MakeSign($payData,$appkey);
			
			    $payData['sign'] = $paySign;
			
			    //拼接成APICLOUD所需要支付数据请求
			    $payDatas = array(
			        'apiKey' => $re['appid'],
			        'orderId' => $re['prepay_id'],
			        'mchId' => $re['mch_id'],
			        'nonceStr' => $payData['noncestr'],
			        'package' => 'Sign=WXPay',
			        'timeStamp' => $payData['timestamp'],
			        'sign' => $paySign
			    );
					
					addOrder($share,$payDatas,$totalFee,'55555555');//插入订单
					
			
			    //返回支付请求数据
			    //echo json_encode($payDatas);
					$result = array("errno" =>0, "errmsg" => 'OK',"data"=>$payDatas);
					die(json_encode($result));
			} else {
			   // $re['payData'] = "error";
			    //echo json_encode($re);
					$result = array("errno" =>1, "errmsg" => 'error',"data"=>$re);
					die(json_encode($result));
			}
			
			function addOrder($member, $post,$totalFee, $goods_id)//插入订单
			{
					global $_W;
					$fee = $totalFee / 100;
					$data = array('weid' => $_W['uniacid'], 'orderno' => $post['orderId'], 'goods_id' => $goods_id, 'price' => $fee, 'memberid' => $member['id'], 'openid' => $member['from_user'],'ffqdtype'=>2, 'nickname' => $member['nickname'], 'avatar' => $member['avatar'],'tel'=>$member['tel'],'cengji'=>0,'usernames'=>$member['nickname'],'msg'=>$member['nickname'].'代理费用','createtime' =>time());
					//file_put_contents(IA_ROOT."/addons/tiger_wxdaili/log.txt","\n dddo1ld:".json_encode($data),FILE_APPEND); 
					pdo_insert("tiger_wxdaili_order", $data);
					$orderid = pdo_insertid();
					//file_put_contents(IA_ROOT."/addons/tiger_wxdaili/log.txt","\n dddo2ld:".json_encode($orderid),FILE_APPEND); 
					return $orderid;
			}
			
			
			

		//include $this->template ( 'tbgoods/style99/c1111' );  
?>