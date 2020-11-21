<?php
/**
 * 海报助力吸粉模块处理程序
 *
 * @author 众惠科技
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
define('POSETERH_ROOT', IA_ROOT.'/addons/zofui_posterhelp/');
require_once(IA_ROOT.'/addons/zofui_posterhelp/class/autoload.php');

class Zofui_posterhelpModuleProcessor extends WeModuleProcessor {
	public function respond() {
		global $_W;
		$content = $this->message;
	
		if( ( $content['msgtype'] == 'event' && $content['event'] == 'CLICK' )  || $content['event'] == 'SCAN' || $content['msgtype'] == 'text' || $content['event'] == 'subscribe' ){
			$key = pdo_get('zofui_posterhelp_key',array('uniacid'=>$_W['uniacid'],'word'=>$content['content']));
			if( !empty( $key ) ){
				$act = model_act::getAct( $key['actid'] );
				$act['creditname'] = empty( $act['creditname'] ) ? '花花' : $act['creditname'];
			}
			$set = self::initset( $this->module['config'] ,$act['creditname']);
//file_put_contents(POSETERH_ROOT."params.log", var_export($key, true).PHP_EOL, FILE_APPEND);
			// 海报
			if( $key['type'] == 3 ){
				
				if( $_SESSION['___posttime'] > TIMESTAMP ) {
					return $this->respText('请'.($_SESSION['___posttime'] - TIMESTAMP).'秒后再试...');
				}
				$_SESSION['___posttime'] = TIMESTAMP + 20;
				Message::sendText($content['from'], $set['ingfont']);
				
				$user = pdo_get('zofui_posterhelp_user',array('uniacid'=>$_W['uniacid'],'openid'=>$content['from'],'actid'=>$key['actid']));

				// 验证
				if( $act['status'] == 1 )  return $this->respText('您参与的活动已经下架，不能生成海报。');
				if( $act['start'] > TIMESTAMP )  return $this->respText('您参与的活动还没开始，不能生成海报。');
				if( $act['end'] < TIMESTAMP )  return $this->respText('您参与的活动已结束，不能生成海报。');

				if( $user['status'] == 1 ) return $this->respText('您不能参与活动');

				if( empty( $user ) && $act['arealimit'] == 0 && $act['isform'] == 0 ) {
					if( empty( $act ) || $act['status'] == 1 )	return $this->respText('活动不存在');
					if( $act['start'] > time() ) return $this->respText('活动还没开始');
					if( $act['end'] < time() ) return $this->respText('活动已结束了');
					
					$fans = pdo_get('mc_mapping_fans',array('openid'=>$content['from'],'uniacid'=>$_W['uniacid']));
					$tag = iunserializer( base64_decode( $fans['tag'] ) );

					$data = array(
						'uniacid' => $_W['uniacid'],
						'actid' => $key['actid'],
						'openid' => $content['from'],
						'nickname' => $fans['nickname'],
						'headimgurl' => $tag['headimgurl'],
						'logintime' => TIMESTAMP,
						'credit' => $act['free'],
						'isstart' => 1,
					);

					if( $_W['account']['level'] == 3 ){
						$account_api = WeAccount::create();
		                if( is_object( $account_api ) ){
		                    $token = $account_api->getAccessToken();
		                    
		                    $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $token . "&openid=" . $content['from'] . "&lang=zh_CN";
		                    $userArr = json_decode(Util::httpGet($url), true);
		                    $data['unionid'] = $userArr['unionid'];
						}
					}

					pdo_insert('zofui_posterhelp_user', $data);
					$id = pdo_insertid();
					pdo_update('zofui_posterhelp_user',array('code'=>$id.rand(11,99)),array('id'=>$id));

					$user = pdo_get('zofui_posterhelp_user',array('id'=>$id));

				}elseif( !empty( $user ) && $user['isstart'] == 0 ){

					pdo_update('zofui_posterhelp_user',array('isstart'=>1),array('id'=>$user['id']));
					Util::deleteCache('u',$user['openid'],$user['actid']);
				}else{

					if( $user['isstart'] != 1 ){
						Message::sendText($content['from'], '您还没参与活动，点击下方图文进入参与活动。');
						$this->showIndex($key['actid'],$content['from']);
						return $this->respText('');
					}

				}

				/*$img = model_poster::getPoster($user);
				$media = Message::uploadImage($img['dir']);
				$res = Message::sendImage($content['from'], $media);*/

				$purl = Util::createModuleUrl('sendimg');
				$code = md5( $set['sendmessauth'].$_W['authkey'] );

				$pdata = array( 'actid'=>$key['actid'],'openid'=>$content['from'],'code'=>$code  );
				$aaa = Util::httpPost($purl, $pdata, '', 1);
				
				$url = $this->createMobileUrl('getprize',array('actid'=>$act['id']));
				$url =  $this->buildSiteUrl($url);

        		$urlstr = htmlspecialchars_decode( $set['getposterfont'] );
        		$urlstr = str_replace('{creditname}', $act['creditname'], $urlstr);
        		$urlstr = str_replace(array('{a}','{/a}'),array('<a href="'.$url.'">','</a>'), $urlstr);
     			
				return $this->respText($urlstr);

				//return $this->respText('生成海报失败...');
			}

			// 兑换奖品页
			if( $key['type'] == 4 ){
				if( $_SESSION['___indextime'] > TIMESTAMP ) {
					return $this->respText('请'.($_SESSION['___indextime'] - TIMESTAMP).'秒后再试...');
				}
				$_SESSION['___indextime'] = TIMESTAMP + 20;

				$url =  $this->createMobileUrl('getprize',array('actid'=>$key['actid']));
				$url =  $this->buildSiteUrl($url);

				$news = array(
					'title' => $key['title'],
					'description' => $key['desc'],
					'picurl' => tomedia( $key['thumb'] ),
					'url' => $url,
				);
				return $this->respNews($news);
			}


			// 活动入口
			if( $key['type'] == 1 ){
				if( $_SESSION['___indextime'] > TIMESTAMP ) {
					return $this->respText('请'.($_SESSION['___indextime'] - TIMESTAMP).'秒后再试...');
				}
				$_SESSION['___indextime'] = TIMESTAMP + 20;

				$url =  $this->createMobileUrl('index',array('actid'=>$key['actid']));
				$url =  $this->buildSiteUrl($url);

				$news = array(
					'title' => $key['title'],
					'description' => $key['desc'],
					'picurl' => tomedia( $key['thumb'] ),
					'url' => $url,
				);
				return $this->respNews($news);
			}

			// 我的奖品
			if( $key['type'] == 2 ){
				if( $_SESSION['___prizetime'] > TIMESTAMP ) {
					return $this->respText('请'.($_SESSION['___prizetime'] - TIMESTAMP).'秒后再试...');
				}
				$_SESSION['___prizetime'] = TIMESTAMP + 20;

				$url =  $this->createMobileUrl('prize',array('actid'=>$key['actid']));
				$url =  $this->buildSiteUrl($url);

				$news = array(
					'title' => $key['title'],
					'description' => $key['desc'],
					'picurl' => tomedia( $key['thumb']  ),
					'url' => $url,
				);
				return $this->respNews($news);
			}

			$content['content'] = strtolower( $content['content'] );
			$set['head'] = strtolower( $set['head'] );
			
			if( is_numeric( $content['content'] ) || @strpos($content['content'],$set['head']) === 0 ){
					
				if( $_SESSION['___dealhelptime'] > TIMESTAMP ) {
					return $this->respText('请'.($_SESSION['___dealhelptime'] - TIMESTAMP).'秒后再试...');
				}
				$_SESSION['___dealhelptime'] = TIMESTAMP + 10;
				Message::sendText($content['from'], $set['ingfont']);

				$code = trim( $content['content'] );
				$code = ltrim($content['content'],$set['head']);

				$user = pdo_get('zofui_posterhelp_user',array('uniacid'=>$_W['uniacid'],'code'=>$code));

				$act = model_act::getAct( $user['actid'] );
				$act['creditname'] = empty( $act['creditname'] ) ? '花花' : $act['creditname'];

				if( empty( $user ) || $user['isstart'] != 1 ){
					return $this->respText('没有找到参与记录,请输入正确的邀请码。');
				}
//file_put_contents(POSETERH_ROOT."params.log", var_export($act, true).PHP_EOL, FILE_APPEND);
           	 	// 验证
            	$checkres = model_help::checkHelp($act,$user,$content['from'],$this->module['config']);
            	if( $checkres != '200' )  return $this->respText($checkres);

 				 
            	$res = model_help::helpSuccess($act,$user,$content['from']);

				unset( $_SESSION['___dealhelptime'] );


	            if( $set['font2'] == 0 || $set['font2'] == 1 ){
	            	if( $set['font2'] == 0 ){
						$url = $this->createMobileUrl('index',array('actid'=>$act['id']));
						$url =  $this->buildSiteUrl($url);

	            		$urlstr = htmlspecialchars_decode( $set['font2font'] );
	            		
	            		$urlstr = str_replace(array('{a}','{/a}'),array('<a href=\"'.$url.'\">','</a>'), $urlstr);
	            		Message::sendText( $content['from'],$urlstr );
	            	}else{
	            		$file = IA_ROOT.'/attachment/'.$set['font2voice'];
	            		if( file_exists( $file ) ){
							$media = Message::uploadVoice( $file );
							Message::sendVoice($content['from'], $media);
	            		}
	            	}
	            }

				/*$url = $this->createMobileUrl('index',array('actid'=>$act['id']));
				$url =  $this->buildSiteUrl($url);
				$urlstr = '<a href=\"'.$url.'\">'.$set['font2font'].'</a>';
				Message::sendText( $content['from'],$urlstr );*/
				
				return $this->respText('');
			}

		}

		
		//file_put_contents(MODULE_ROOT."params.log", var_export($_W['account'], true).PHP_EOL, FILE_APPEND);
		//return $this->respText('没有查询到任何数据。');
	}

	public function showIndex($actid,$openid){
		global $_W;
		$url =  $this->createMobileUrl('index',array('actid'=>$actid));
		$url =  $this->buildSiteUrl($url);
		$info = pdo_get('zofui_posterhelp_key',array('uniacid'=>$_W['uniacid'],'actid'=>$actid,'type'=>1));
		$news = array(
			'title' => $info['title'],
			'description' => $info['desc'],
			'picurl' => tomedia( $info['thumb']  ),
			'url' => $url,
		);

		$res = Message::sendNews($openid, $news);		
	}

	static function initset($set,$name){
		$set['ingfont'] = empty( $set['ingfont'] ) ? '处理中，请稍候...' : $set['ingfont'];

		$set['sendpostfont'] = empty( $set['sendpostfont'] ) ? '海报已发送，您可以将海报发送给您的朋友搜集'.$name : $set['sendpostfont'];

		$set['indexfont'] = empty( $set['indexfont'] ) ? '点击参与活动' : $set['indexfont'];
		$set['addsuccfont'] = empty( $set['addsuccfont'] ) ? '成功帮{nick}加油，您也可以点击菜单栏参与活动。' : $set['addsuccfont'];
		$set['addedfont'] = empty( $set['addedfont'] ) ? '{nick}帮你加油，增加一点能量值。' : $set['addedfont'];
		$set['addsuccendfont'] = empty( $set['addsuccendfont'] ) ? '您的好友{nick}已经完成任务，感谢您的支持，可邀朋友帮他加油，助您的好友取得更好的名次。' : $set['addsuccendfont'];
		$set['addsuccendfont2'] = empty( $set['addsuccendfont2'] ) ? '您帮{nick}加油成功。' : $set['addsuccendfont2'];
		$set['addsuccendfont3'] = empty( $set['addsuccendfont3'] ) ? '您的好友{nick}已经完成任务，继续加油可增加活动排名。' : $set['addsuccendfont3'];

		$set['getposterfont'] = empty( $set['getposterfont'] ) ? '海报已发送，您可以将海报发送给您的朋友搜集{creditname}，{a}点击此处查看和兑换奖品{/a}' : $set['getposterfont'];
		//$set['fonturl'] = empty( $set['fonturl'] ) ? '点我参与活动，赢取大奖' : $set['fonturl'];

		$set['font2font'] = empty( $set['font2font'] ) ? '{a}点我参与活动，赢取大奖{/a}' : $set['font2font'];	
		return $set;
	}

}