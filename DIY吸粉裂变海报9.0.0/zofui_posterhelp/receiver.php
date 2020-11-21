<?php
/**
 * 助力抢商品模块订阅器
 *
 * @author 众惠
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
define('POSETERH_ROOT', IA_ROOT.'/addons/zofui_posterhelp/');
require_once(IA_ROOT.'/addons/zofui_posterhelp/class/autoload.php');

class Zofui_posterhelpModuleReceiver extends WeModuleReceiver {

	public function receive() {
		global $_W;
		//$type = $this->message['type'];
//file_put_contents(POSETERH_ROOT."/params.log", var_export(POSETERH_ROOT, true).PHP_EOL, FILE_APPEND);				
		$content = $this->message;
//file_put_contents(POSETERH_ROOT."/params.log", var_export($content, true).PHP_EOL, FILE_APPEND);           
		if( $content['event'] == 'subscribe' || $content['event'] == 'SCAN' ){

            $flag = Util::getCache('doing',$content['from'],1);
            $now = self::toMicTime();
            if( $flag >= $now ){
                $this->sendText($content['from'], '请不要频繁扫码二维码...');
                return false;
            }
            Util::setCache('doing',$content['from'], $now+2000 ,1);

            // 新粉丝记录
            /*$isnew = pdo_get('zofui_posterhelp_uu',array('uniacid'=>$_W['uniacid'],'openid'=>$content['from']),array('id'));
            if( empty($isnew['id']) ){
                pdo_insert('zofui_posterhelp_uu',array('uniacid'=>$_W['uniacid'],'openid'=>$content['from']));
            }*/
            
            if( $_W['account']['level'] == 4 ){
                $qr = pdo_get('zofui_posterhelp_qrcode',array('uniacid'=>$_W['uniacid'],'sence'=>$content['scene']));
                
                if( empty( $qr ) ) return false;
                $this->sendText($content['from'], '请稍候，处理中...');

                $user = pdo_get('zofui_posterhelp_user',array('actid'=>$qr['actid'],'openid'=>$qr['openid'],'uniacid'=>$_W['uniacid']));
                $act = model_act::getAct( $user['actid'] );
                $act['creditname'] = empty( $act['creditname'] ) ? '花花' : $act['creditname'];

                // 验证
                $checkres = model_help::checkHelp($act,$user,$content['from'],$this->module['config']);
                if( $checkres != '200' )  return $this->sendText($content['from'], $checkres);

                // 再验证一次 防止多次扫码触发
                $flag = Util::getCache('doing',$content['from'],1);
                if(  $flag != ($now+2000) ){
                    return false;
                }

                $res = model_help::helpSuccess($act,$user,$content['from']);
                
                $set = $this->module['config'];
                $set['font2font'] = empty( $set['font2font'] ) ? '{a}点我参与活动，赢取大奖{/a}' : $set['font2font'];

                if( $set['font2'] == 0 || $set['font2'] == 1 ){
                    if( $set['font2'] == 0 ){
                        $url = Util::createModuleUrl('index',array('actid'=>$act['id']));
                        //$url =  $this->buildSiteUrl($url);

                        $urlstr = $set['font2font'];

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
            
            }elseif( $_W['account']['level'] == 3 ){

                $account_api = WeAccount::create();

                if( is_object( $account_api ) ){
                    $token = $account_api->getAccessToken();
                    
                    $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $token . "&openid=" . $content['from'] . "&lang=zh_CN";
                    $userArr = json_decode($this->httpGet($url), true);
                    $unionid = $userArr['unionid'];

                    if( $_W['siteroot'] == 'http://127.0.0.4/' ){
                        $unionid = '11';
                    }

                    if( !empty($unionid) ){
                        $isinvite = pdo_get('zofui_posterhelp_invite',array('uniacid'=>$_W['uniacid'],'unionid'=>$unionid,'status'=>0));
                        $act = model_act::getAct( $isinvite['actid'] );
                        $act['creditname'] = empty( $act['creditname'] ) ? '花花' : $act['creditname'];

                        $user = pdo_get('zofui_posterhelp_user',array('id'=>$isinvite['uid'],'uniacid'=>$_W['uniacid']));

                        if( !empty($isinvite) && !empty($act) ) {

                            $checkres = model_help::checkHelp($act,$user,$content['from'],$this->module['config']); 
                                                    
                            if( $checkres != '200' )  {
                                return $this->sendText($content['from'], $checkres);
                            }else{

                                pdo_update('zofui_posterhelp_invite',array('status'=>1),array('id'=>$isinvite['id']));
                                
                                $res = model_help::helpSuccess($act,$user,$content['from']);
                                
                                $set = $this->module['config'];
                                $set['font2font'] = empty( $set['font2font'] ) ? '{a}点我参与活动，赢取大奖{/a}' : $set['font2font'];

                                if( $set['font2'] == 0 || $set['font2'] == 1 ){
                                    if( $set['font2'] == 0 ){
                                        $url = Util::createModuleUrl('index',array('actid'=>$act['id']));
                                        //$url =  $this->buildSiteUrl($url);

                                        $urlstr = $set['font2font'];

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

                            }
                        }
                    }
                }

            }
            




            // 发图文
            /*$url = Util::createModuleUrl('index',array('actid'=>$act['id']));
            //$url =  $this->buildSiteUrl($url);
            $urlstr = '<a href=\"'.$url.'\">点我参与活动，赢取大奖</a>';
            Message::sendText( $content['from'],$urlstr );*/
		}elseif( $content['event'] == 'unsubscribe' ){
            
            $allhelp = pdo_getall('zofui_posterhelp_helplist',array('uniacid'=>$_W['uniacid'],'helper'=>$content['from'],'isminus'=>0));
//file_put_contents(POSETERH_ROOT."/params.log", var_export($allhelp, true).PHP_EOL, FILE_APPEND);
            if( !empty( $allhelp ) ){
                foreach ($allhelp as $v) {
                    $act = model_act::getAct( $v['actid'] );
                    if( empty( $act ) ) continue;
                    if( $act['status'] == 1 ) continue;
                    if( $act['start'] > TIMESTAMP ) continue;
                    if( $act['end'] < TIMESTAMP ) continue;
                    if( $act['isminus'] == 0 ) continue;

                    $act['creditname'] = empty( $act['creditname'] ) ? '花花' : $act['creditname'];

                    $user = pdo_get('zofui_posterhelp_user',array('actid'=>$v['actid'],'openid'=>$v['helped'],'uniacid'=>$_W['uniacid']));
                    if( $user['credit'] <= 0 ) continue;

                    $minus = $v['credit'];
					
					if( empty($act['jftype']) ){
						if( $user['credit'] < $v['credit'] ) $minus = $user['credit'];
						$res = Util::addOrMinusOrUpdateData('zofui_posterhelp_user',array('credit'=>-$minus),$user['id']);
					}elseif( $act['jftype'] == 1 ){
						
						$carr = model_user::getUserCredit($user['openid']);
						
						if( $carr['credit1'] < $v['credit'] ) $minus = $carr['credit1'];
						$res = model_user::updateUserCredit($user['openid'],-$minus,1,'助力海报');
					}
					
                    //if( $user['credit'] < $v['credit'] ) $minus = $user['credit'];
                    //$res = Util::addOrMinusOrUpdateData('zofui_posterhelp_user',array('credit'=>-$minus),$user['id']);

                    if( $res ){
                        pdo_update('zofui_posterhelp_helplist',array('isminus'=>1),array('id'=>$v['id']));
                        // 发消息
                        $helper = pdo_get('mc_mapping_fans',array('openid'=>$content['from']),array('nickname'));
                        Message::unsubMessage($user['openid'],$act['creditname'],$helper['nickname'],$minus,$user['actid']);

                        Util::deleteCache('u',$user['openid'],$user['actid']);
                    }

                }
            }

        }

        //unset( $_SESSION['___dotime'] );
        Util::deleteCache('doing',$content['from'],1);
        return;
	}


    public function sendText($openid, $text)
    {
        $post = '{"touser":"' . $openid . '","msgtype":"text","text":{"content":"' . $text . '"}}';
        $ret = $this->sendRes($this->getAccessToken(), $post);
        return $ret;
    }
    public function sendNews($openid, $response)
    {
        $data = array("touser" => $openid, "msgtype" => "news", "news" => array("articles" => $response));
        $ret = $this->sendRes($this->getAccessToken(), $this->json_encode2($data));
        return $ret;
    }
    private function json_encode2($arr)
    {
        array_walk_recursive($arr, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_encode_numericentity($item, array(0x80, 0xffff, 0, 0xffff), 'UTF-8');
            }
        });
        return mb_decode_numericentity(json_encode($arr), array(0x80, 0xffff, 0, 0xffff), 'UTF-8');
    }
    public function sendImage($openid, $media_id)
    {
        $data = array("touser" => $openid, "msgtype" => "image", "image" => array("media_id" => $media_id));
        $ret = $this->sendRes($this->getAccessToken(), json_encode($data));
        return $ret;
    }
    private function sendRes($access_token, $data)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
        load()->func('communication');
        $ret = ihttp_request($url, $data);

        $content = @json_decode($ret['content'], true);
        return $content['errmsg'];
    }
    private function uploadImage($img)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=" . $this->getAccessToken() . "&type=image";
        $post = array('media' => '@'.$img);
        load()->func('communication');
        $ret = ihttp_request($url, $post);       
        $content = @json_decode($ret['content'], true);
        return $content['media_id'];
    }
    private function getAccessToken()
    {
        global $_W;
        load()->model('account');
        $acid = $_W['acid'];
        if (empty($acid)) {
            $acid = $_W['uniacid'];
        }
        $account = WeAccount::create($acid);
        $token = $account->fetch_available_token();
        return $token;
    }

    static function toMicTime(){
        $time = microtime();
        $list = explode(' ', $time);
        return $list[1].intval( $list[0]*1000 );
    }

    private function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }


}