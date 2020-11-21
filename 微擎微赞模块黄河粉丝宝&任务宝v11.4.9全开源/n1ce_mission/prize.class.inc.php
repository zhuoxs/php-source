<?php
/**
* 奖品信息获取
*/
include 'youzan_function.php';
//
class Prize
{
	private static $t_prize = 'n1ce_mission_prize';
	private static $t_user = 'n1ce_mission_user';
	private static $t_code = 'n1ce_mission_code';
	private static $t_member = 'n1ce_mission_member';

	public function getPrizeByNumber($uniacid, $rid, $number){
		$achieve = pdo_fetch("select * from " .tablename(self::$t_prize). " where uniacid=:uniacid and rid=:rid and miss_num=:miss_num",array(':uniacid'=>$uniacid,':rid'=>$rid,':miss_num'=>$number));
		WeUtility::logging("结果",$achieve);
		if(empty($achieve)){
			$need_number = pdo_fetch("select * from " .tablename(self::$t_prize). " where uniacid=:uniacid and rid=:rid and miss_num>:miss_num order by miss_num asc limit 1",array(':uniacid'=>$uniacid,':rid'=>$rid,':miss_num'=>$number));
			if($need_number){
				return array('code'=>102,'data'=>$need_number);
			}else{
				return array('code'=>103,'data'=>'');
			}
		}else{
			return array('code'=>101,'data'=>$achieve);
		}
	}
	public function getNextByNumber($uniacid, $rid, $number){
		$number = $number + 1;
		$need_number = pdo_fetch("select * from " .tablename(self::$t_prize). " where uniacid=:uniacid and rid=:rid and miss_num>=:miss_num order by miss_num asc limit 1",array(':uniacid'=>$uniacid,':rid'=>$rid,':miss_num'=>$number));
		if($need_number){
			return array('code'=>102,'data'=>$need_number);
		}else{
			return array('code'=>103,'data'=>'');
		}
	}
	public function sendPrize($prize,$number,$leader,$follower,$reply){
		yload()->classs('n1ce_mission','wechatapi');
		yload()->classs('n1ce_mission','wechatutil');
		$remark_on = str_replace('#奖品#', $prize['prize_name'], $reply['remark_end']);
		$postdata = array(
  			'first' => array(
  				'value' => "成功啦!又一位小伙伴[".$follower['nickname']."]认可你的人气啦,人气值 +1,总人气值(".$number.")",
  				'color' => '#FF0000',
  			),
  			'keyword1' => array(
  				'value' => "系统会员编号[".$follower['uid']."]",
  				'color' => '#173177',
  			),
  			'keyword2' => array(
  				'value' => date("Y-m-d H:i:s",time()),
  				'color' => '#173177',
  			),
  			'remark' => array(
  				'value' => $remark_on,
  				'color' => '#FF0000',
  			),
  		);
  		$news[] = array(
  			'title' => urlencode('任务完成通知'),
  			'description' => $postdata['first']['value'].'\n会员ID：'.$postdata['keyword1']['value'].'\n完成时间：'.$postdata['keyword2']['value'].'\n',
  			'picurl' => '',
  			'url' => '',
  		);
		if($prize['prizesum'] <= 0){
			$remark_end = "抱歉通知你,当前任务奖品被领光了";
			//模板提示
			if($reply['msgtype'] == 2){
				$news[0]['description'] = urlencode($news[0]['description'].$remark_end);
				WechatAPI::sendNews($news,$leader['openid']);
				exit(0);
			}
			$postdata['remark']['value'] = $remark_end;
			WechatAPI::sendTempMsg($leader['openid'], $reply['temp_join'], $postdata, $url = '', $topcolor = '#FF683F');
			exit(0);
		}
		//判断是不是有取消关注再次关注的
		$unsub = pdo_get('n1ce_mission_user',array('uniacid'=>$reply['uniacid'],'rid'=>$reply['rid'],'openid'=>$leader['openid'],'allnumber'=>$number),array('id'));
		if($unsub['id']){
			if($prize['type'] == 1 || $prize['type'] == 2 || $prize['type'] == 4 || $prize['type'] == 7){

				$remark_end = "抱歉通知你,当前任务奖品你已经领取过了";
				if($reply['msgtype'] == 2){
					$news[0]['description'] = urlencode($news[0]['description'].$remark_end);
					WechatAPI::sendNews($news,$leader['openid']);
					exit(0);
				}
				//模板提示
				$postdata['remark']['value'] = $remark_end;
				WechatAPI::sendTempMsg($leader['openid'], $reply['temp_join'], $postdata, $url = '', $topcolor = '#FF683F');
				exit(0);
			}
			if($reply['msgtype'] == 2){
				$news[0]['description'] = urlencode($news[0]['description'].$remark_end);
				WechatAPI::sendNews($news,$leader['openid']);
				exit(0);
			}
			if($prize['type'] == 8){
				$re_url = WechatUtil::createMobileUrl('goods', 'n1ce_mission', array('rid'=>$reply['rid'],'gid'=>$prize['gid']));
			}else{
				$re_url = $prize['url'];
			}
			WechatAPI::sendTempMsg($leader['openid'], $reply['temp_join'], $postdata, $re_url, $topcolor = '#FF683F');
			exit(0);
		}
		WeUtility::logging('insertUser');
		$ret = $this->insertUser($reply['uniacid'],$reply['rid'],$leader,$number);
		WeUtility::logging('insertUser2',$ret);
		if($ret){
			if($prize['type'] !== '8'){
				//更新奖品库存
				pdo_update(self::$t_prize,array('prizesum -='=>1),array('id'=>$prize['id']));
			}
		}else{
			//刷子
			exit(0);
		}
		switch ($prize['type']) {
			case '1':
				//微信红包
				if($reply['msgtype'] == 2){
					$news[0]['description'] = urlencode($news[0]['description'].$remark_on);
					WechatAPI::sendNews($news,$leader['openid']);
				}
				WechatAPI::sendTempMsg($leader['openid'], $reply['temp_join'], $postdata, $url = '', $topcolor = '#FF683F');
				$money = rand($prize['min_money'], $prize['max_money']);
				$cfg = WechatUtil::getOtherSettings('n1ce_mission');
				if($cfg['affiliate'] == 2){
					$action = WechatAPI::sendSubRedPacket($leader['openid'], $money);
				}elseif($cfg['borrow'] == 2){
					WeUtility::logging('借权发红包开始');
					$borrow_openid = $this->getBorrowUid($leader['openid'],$reply['uniacid'],$reply['rid']);
					$action = WechatAPI::sendRedPacket($borrow_openid, $money,$cfg);
					WeUtility::logging('借权发红包结束',$action);
				}else{
					WeUtility::logging('发红包开始');
					$action = WechatAPI::sendRedPacket($leader['openid'], $money,$cfg);
					WeUtility::logging('发红包结束',$action);
				}
				if($action === true){
					$this->updateUser('1','1',$ret,$money,'',$borrow_openid);
				}else{
					$this->updateUser('1','2',$ret,$money,'',$borrow_openid);
					$actions = "微信红包发送失败,请截图失败原因联系客服！\n失败原因：".$action;
					WechatAPI::sendText($leader['openid'],$actions);
				}
				
				break;
			
			case '2':
				//微信卡券
				$status = WechatAPI::sendCard($leader['openid'],$prize['cardid']);
				if(is_error($status)){
					//客服消息发卡券失败
					$url = WechatUtil::createMobileUrl('cardurl','n1ce_mission',array('card_id'=>$prize['cardid']));
				}
				$this->updateUser('2','1',$ret,'','','');
				if($reply['msgtype'] == 2){
					$news[0]['description'] = urlencode($news[0]['description'].$remark_on);
					$news[0]['url'] = $url;
					WechatAPI::sendNews($news,$leader['openid']);
				}
				WechatAPI::sendTempMsg($leader['openid'], $reply['temp_join'], $postdata, $url, $topcolor = '#FF683F');
				break;

			case '3':
				//有赞商品
				$res = he_youzan_addtags(WechatUtil::youzan_access_token(),$leader['openid'],$prize['lable']);
				$this->updateUser('3','1',$ret,'','','');
				if($res['response']){
		    		if($reply['msgtype'] == 2){
						$news[0]['description'] = urlencode($news[0]['description'].$remark_on);
						$news[0]['url'] = $prize['url'];
						WechatAPI::sendNews($news,$leader['openid']);
					}
					WechatAPI::sendTempMsg($leader['openid'], $reply['temp_join'], $postdata, $prize['url'], $topcolor = '#FF683F');
			    }else{
			    	WechatAPI::sendText($leader['openid'],'请联系管理员手动处理！');
			    }
				break;
            
			case '4':
				// 微擎积分
				load()->model('mc');
				WeUtility::logging('积分开始');
				$res = mc_credit_update($leader['uid'], 'credit1', $prize['credit'], array(0, '粉丝宝积分'.$prize['credit'].'积分'));
				WeUtility::logging('积分结束',$res);
				$this->updateUser('4','1',$ret,'','','');
				if($reply['msgtype'] == 2){
					$news[0]['description'] = urlencode($news[0]['description'].$remark_on);
					WechatAPI::sendNews($news,$leader['openid']);
				}
				WechatAPI::sendTempMsg($leader['openid'], $reply['temp_join'], $postdata, '', $topcolor = '#FF683F');
				break;

			case '5':
				//自定义链接 鸡肋奖品可去掉
				$this->updateUser('5','1',$ret,'','','');
				if($reply['msgtype'] == 2){
					$news[0]['description'] = urlencode($news[0]['description'].$remark_on);
					$news[0]['url'] = $prize['url'];
					WechatAPI::sendNews($news,$leader['openid']);
				}
				WechatAPI::sendTempMsg($leader['openid'], $reply['temp_join'], $postdata, $prize['url'], $topcolor = '#FF683F');
				break;

		    case '6':
		    	// 有赞抽奖   可以和有赞商品兼并


		    	$res = he_youzan_addtags(WechatUtil::youzan_access_token(),$leader['openid'],$prize['lable']);

				$this->updateUser('6','1',$ret,'','','');
				if($res['response']){
		    		if($reply['msgtype'] == 2){
						$news[0]['description'] = urlencode($news[0]['description'].$remark_on);
						$news[0]['url'] = $prize['url'];
						WechatAPI::sendNews($news,$leader['openid']);
					}
					WechatAPI::sendTempMsg($leader['openid'], $reply['temp_join'], $postdata, $prize['url'], $topcolor = '#FF683F');
			    }else{
			    	WechatAPI::sendText($leader['openid'],'请联系管理员手动处理！');
			    }
				
		    	break;

		    case '7':
		    	//兑换码
		    	$codeinfo = $this->getCodeById($reply['uniacid'],$reply['rid'],$prize['id']);
		    	$remark_on = str_replace('#兑换码#', $codeinfo['code'], $remark_on);
		    	$text = str_replace('#兑换码#', $codeinfo['code'], $reply['temp_code']);
		    	$text = str_replace('#奖品#', $prize['prize_name'], $text);
				//模板提示
				$postdata['remark']['value'] = $remark_on;
				$this->updateUser('7','1',$ret,'',$codeinfo['code'],'');
				if($prize['url']){
					$code_url = $prize['url'];
				}else{
					$code_url= '';
				}
				if($reply['msgtype'] == 2){
					$news[0]['description'] = urlencode($news[0]['description'].$remark_on);
					$news[0]['url'] = $code_url;
					WechatAPI::sendNews($news,$leader['openid']);
				}
				WechatAPI::sendTempMsg($leader['openid'], $reply['temp_join'], $postdata, $code_url, $topcolor = '#FF683F');
				WechatAPI::sendText($leader['openid'],$text);
				$this->updateCodeById($codeinfo['id']);
		    	break;

		    case '8':
		    	//实物奖品
		    	$g_url = WechatUtil::createMobileUrl('goods', 'n1ce_mission', array('rid'=>$reply['rid'],'gid'=>$prize['gid']));
		    	$this->updateUser('8','1',$ret,'','','');
		    	if($reply['msgtype'] == 2){
					$news[0]['description'] = urlencode($news[0]['description'].$remark_on);
					$news[0]['url'] = $g_url;
					WechatAPI::sendNews($news,$leader['openid']);
				}
				WechatAPI::sendTempMsg($leader['openid'], $reply['temp_join'], $postdata, $g_url, $topcolor = '#FF683F');
		    	break;

			default:
				# code...
				break;
		}
	}
	public function sendPrizeMsg($prize,$number,$leader,$follower,$reply){
		yload()->classs('n1ce_mission','wechatapi');
		yload()->classs('n1ce_mission','wechatutil');
		if($prize['prizesum'] <= 0){
			$remark_end = "抱歉通知你,当前任务奖品被领光了";
			//模板提示
			WechatAPI::sendText($leader['openid'],$remark_end);
			exit(0);
		}
		$miss_finish = str_replace('#奖品#', $prize['prize_name'], $reply['miss_finish']);
		$miss_finish = str_replace('#昵称#', $follower['nickname'], $miss_finish);
		$miss_finish = str_replace('#人气值#', $number, $miss_finish);
		$miss_finish = str_replace('#库存#', $prize['prizesum'], $miss_finish);
		//判断是不是有取消关注再次关注的
		$unsub = pdo_get('n1ce_mission_user',array('uniacid'=>$reply['uniacid'],'rid'=>$reply['rid'],'openid'=>$leader['openid'],'allnumber'=>$number),array('id'));
		if($unsub['id']){
			if($prize['type'] == 5 || $prize['type'] == 8){
				
				WechatAPI::sendText($leader['openid'],$miss_finish);
				exit(0);
			}
			$remark_end = "抱歉通知你,当前任务奖品你已经领取过了";
			//模板提示
			WechatAPI::sendText($leader['openid'],$remark_end);
			exit(0);
		}
		WeUtility::logging('insertUser');
		$ret = $this->insertUser($reply['uniacid'],$reply['rid'],$leader,$number);
		WeUtility::logging('insertUser2',$ret);
		if($ret){
			//更新奖品库存
			pdo_update(self::$t_prize,array('prizesum -='=>1),array('id'=>$prize['id']));
		}else{
			//刷子
			exit(0);
		}
		switch ($prize['type']) {
			case '1':
				//微信红包
				WechatAPI::sendText($leader['openid'],$miss_finish);
				$money = rand($prize['min_money'], $prize['max_money']);
				$cfg = WechatUtil::getOtherSettings('n1ce_mission');
				if($cfg['affiliate'] == 2){
					$action = WechatAPI::sendSubRedPacket($leader['openid'], $money);
				}elseif($cfg['borrow'] == 2){
					WeUtility::logging('借权发红包开始');
					$borrow_openid = $this->getBorrowUid($leader['openid'],$reply['uniacid'],$reply['rid']);
					$action = WechatAPI::sendRedPacket($borrow_openid, $money,$cfg);
					WeUtility::logging('借权发红包结束',$action);
				}
				if($action === true){
					$this->updateUser('1','1',$ret,$money,'',$borrow_openid);
				}else{
					$this->updateUser('1','2',$ret,$money,'',$borrow_openid);
					$actions = "微信红包发送失败,请截图失败原因联系客服！\n失败原因：".$action;
					WechatAPI::sendText($leader['openid'],$actions);
				}
				
				break;
			
			case '2':
				//微信卡券
				$status = WechatAPI::sendCard($leader['openid'],$prize['cardid']);
				$this->updateUser('2','1',$ret,'','','');
				WechatAPI::sendText($leader['openid'],$miss_finish);
				break;
            
			case '4':
				// 微擎积分
				load()->model('mc');
				WeUtility::logging('积分开始');
				$res = mc_credit_update($leader['uid'], 'credit1', $prize['credit'], array(0, '粉丝宝积分'.$prize['credit'].'积分'));
				WeUtility::logging('积分结束',$res);
				$this->updateUser('4','1',$ret,'','','');
				WechatAPI::sendText($leader['openid'],$miss_finish);
				break;

			case '5':
				//自定义链接
				$miss_finish = str_replace('#链接#', $prize['url'], $miss_finish);
				$this->updateUser('4','1',$ret,'','','');
				WechatAPI::sendText($leader['openid'],$miss_finish);
				break;

		    case '7':
		    	//兑换码
		    	$codeinfo = $this->getCodeById($reply['uniacid'],$reply['rid'],$prize['id']);
		    	$miss_finish = str_replace('#兑换码#', $codeinfo['code'], $miss_finish);
				//模板提示
				$this->updateUser('7','1',$ret,'',$codeinfo['code'],'');
				WechatAPI::sendText($leader['openid'],$miss_finish);
				$this->updateCodeById($codeinfo['id']);
		    	break;

		    case '8':
		    	//实物奖品
		    	$g_url = WechatUtil::createMobileUrl('goods', 'n1ce_mission', array('rid'=>$reply['rid'],'gid'=>$prize['gid']));
		    	$miss_finish = str_replace('#实物链接#', $g_url, $miss_finish);
		    	$this->updateUser('8','1',$ret,'','','');
				WechatAPI::sendText($leader['openid'],$miss_finish);
		    	break;

			default:
				# code...
				break;
		}
	}
	private function getBorrowUid($from_user,$uniacid,$rid){
		$member = pdo_fetch("select brrow_openid from " .tablename(self::$t_member). " where uniacid=:uniacid and rid=:rid and from_user=:from_user",array(':uniacid'=>$uniacid,':rid'=>$rid,':from_user'=>$from_user));
		return $member['brrow_openid'];
	}
	private function insertUser($uniacid,$rid,$leader,$number){
		pdo_insert(self::$t_user,array('uniacid'=>$uniacid,'rid'=>$rid,'openid'=>$leader['openid'],'nickname'=>$leader['nickname'],'allnumber'=>$number,'headimgurl'=>$leader['avatar'],'time'=>time(),'check_sign'=>$leader['openid'].time()));
		return pdo_insertid();
	}
	private function updateUser($type,$status,$id,$money='',$code='',$borrow_openid=''){
		pdo_update(self::$t_user,array('type'=>$type,'status'=>$status,'money'=>$money,'code'=>$code,'brrow_openid'=>$borrow_openid),array('id'=>$id));
	}
	private function getCodeById($uniacid,$rid,$pid){
		$sql = "SELECT * FROM ".tablename(self::$t_code)." WHERE uniacid=:uniacid AND rid=:rid AND codeid=:pid AND status=1 ORDER BY RAND() LIMIT 1";
		$codeinfo = pdo_fetch($sql,array(':uniacid'=>$uniacid,':rid'=>$rid,':pid'=>$pid));
		return $codeinfo;
	}
	private function updateCodeById($id){
		pdo_update(self::$t_code,array('status'=>2),array('id'=>$id));
	}
}