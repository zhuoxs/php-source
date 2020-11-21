<?php

class Message 
{
	
	static private $actoken;
	
	
    static function sendText($openid, $text)
    {
        $post = '{"touser":"' . $openid . '","msgtype":"text","text":{"content":"' . $text . '"}}';
        $ret = self::sendRes(self::getAccessToken(), $post);
        return $ret;
    }
    
     static function sendVoice($openid, $mid)
    {
        $post = '{"touser":"' . $openid . '","msgtype":"voice","voice":{"media_id":"' . $mid . '"}}';
        $ret = self::sendRes(self::getAccessToken(), $post);
        return $ret;
    }   

	static function sendNews($openid, $news) {
		$post = '{"touser":"' . $openid . '","msgtype":"news","news":{"articles":[{"title":"' . $news['title'] . '","description":"' . $news['description'] . '","url":"' . $news['url'] . '","picurl":"' . $news['picurl'] . '"}]}}';
		$ret = self::sendRes(self::getAccessToken(), $post);
		return $ret;
	}
    static function json_encode2($arr)
    {
        array_walk_recursive($arr, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_encode_numericentity($item, array(0x80, 0xffff, 0, 0xffff), 'UTF-8');
            }
        });
        return mb_decode_numericentity(json_encode($arr), array(0x80, 0xffff, 0, 0xffff), 'UTF-8');
    }
    static function sendImage($openid, $media_id,$time=60)
    {
        $data = array("touser" => $openid, "msgtype" => "image", "image" => array("media_id" => $media_id));
        $ret = self::sendRes(self::getAccessToken(), json_encode($data),$time);
        return $ret;
    }

    static function sendRes($access_token, $data,$time=60)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
        load()->func('communication');
        $ret = ihttp_request($url, $data,array(),$time);

        $content = @json_decode($ret['content'], true);
     	if( $content['errcode'] == 0 ){
     		return array('res'=>true);
     	}else{
     		return array('res'=>false,'msg'=>$content['errmsg']);
     	}
    }
    static function uploadImage($img)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=" . self::getAccessToken() . "&type=image";
        $post = array('media' => '@'.$img);
        load()->func('communication');
        $ret = ihttp_request($url, $post);
        $content = @json_decode($ret['content'], true);
        return $content['media_id'];
    }
    static function uploadVoice($img)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=" . self::getAccessToken() . "&type=voice";
        $post = array('media' => '@'.$img);
        load()->func('communication');
        $ret = ihttp_request($url, $post);
        $content = @json_decode($ret['content'], true);

        // CURL_SSLVERSION_TLSv1 define('CURL_SSLVERSION_TLSv1',3);
  //file_put_contents(POSETERH_ROOT."/params.log", var_export($ret, true).PHP_EOL, FILE_APPEND);        
        return $content['media_id'];
    }    
    static function getAccessToken()
    {
        global $_W;

        if( self::$actoken ) return self::$actoken;

        load()->model('account');
        $acid = $_W['acid'];
        if (empty($acid)) {
            $acid = $_W['uniacid'];
        }
        $account = WeAccount::create($acid);
        $token = $account->fetch_available_token();
        self::$actoken = $token;
        return $token;
    }





	
	/*
	待办事项通知
	
	{{first.DATA}}
	事项名称：{{keyword1.DATA}}
	时间：{{keyword2.DATA}}
	{{remark.DATA}}
	编号：OPENTM401202033[标题：待办事项通知]
	*/
	public static function smessage($openid,$url,$name,$messagestr,$time=1) {
		global $_W;
		$setting = Util::getModuleConfig();

		$msg_json = '{
           	"touser":"' . $openid . '",
           	"template_id":"' . $setting['mid'] . '",
           	"url":"' . $url . '",
           	"topcolor":"#173177",
           	"data":{
               	"first":{
                   "value":"' . $messagestr .'",
                   "color":"#777777"
               	},
               	"keyword1":{
					"value":"'.$name.'",
               		"color":"#000000"
				},				
               	"keyword2":{
					"value":"' . date('Y-m-d H:i:s',time()) .'",
               		"color":"#777777"
				}			
           	}
        }';
		
		return self::commonPostMessage($msg_json,$time);
	}	
	
	
	//组合字符串
	static function structMessage($array){
		$str = '';
		if(is_array($array)){
			foreach($array as $k => $v){
				$v = cutstr($v,30, false);
				$str .= $k.'：'.$v.'\n';
			}
		}
	
		return trim($str,'\\n');
	}
	
	
	// 帮助成功提示
	static function helpMessage($openid,$name,$nick,$credit,$actid){
		global $_W;
		//$url = Util::createModuleUrl('index',array('actid'=>$actid));
		$array = array(
			'赠送数量' => $credit.$name,
		);
		if( $nick ) $array['赠送好友'] = $nick;

		$str = '您的朋友'.$nick.'给你赠送了'.$credit.$name.'\n' .self::structMessage($array);
		if( $_W['account']['level'] == 4 ){
			return self::smessage($openid,$url,'好友赠送',$str);
		}elseif( $_W['account']['level'] == 3 ){
			return self::sendText($openid,$str);
		}
	}
	
	// 取关扣积分提示
	static function unsubMessage($openid,$name,$nick,$credit,$actid){
		global $_W;
		//$url = Util::createModuleUrl('index',array('actid'=>$actid));
		$array = array(
			'取关好友' => $nick,
			'扣除数量' => $credit.$name,
		);
		$str = '您的朋友'.$nick.'取消关注公众号，扣除您'.$credit.$name.'\n' .self::structMessage($array);
		if( $_W['account']['level'] == 4 ){
			return self::smessage($openid,$url,'扣除'.$name,$str);
		}elseif( $_W['account']['level'] == 3 ){
			return self::sendText($openid,$str);
		}
	}

	// 发货提示
	static function sendPrize($openid,$prizename,$name,$number,$actid){
		global $_W;
		$url = Util::createModuleUrl('prize',array('actid'=>$actid));
		$array = array(
			'奖品名称' => $prizename,			
			'快递名称' => $name,
			'快递编号' => $number,
		);
		$str = '您兑换的奖品已发奖\n' .self::structMessage($array);
		if( $_W['account']['level'] == 4 ){
			return self::smessage($openid,$url,'发奖通知',$str);
		}elseif( $_W['account']['level'] == 3 ){
			return self::sendText($openid,$str);
		}
	}
	
	// 帮助成功提示
	static function linkmess($openid,$mess,$link=''){
		global $_W;
		
		$array = array(
			'消息内容' => $mess,
		);
		$str = self::structMessage($array);
		if( $_W['account']['level'] == 4 ){
			return self::smessage($openid,$link,'通知',$str,30);
		}elseif( $_W['account']['level'] == 3 ){
			
			if( !empty( $link ) ){
				$str .= '\n<a href=\"'.$link.'\">查看详情</a>';
			}
			return self::sendText($openid,$mess);
		}
	}


	//模板消息url
	static function getUrl1(){
		global $_W;
		load() -> model('account');
		$account = WeAccount::create($_W['account']['oauth']['acid']);
		$access_token = $account->getAccessToken();
		$url1 = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token . "";		
		return $url1;
	}
	
	static function commonPostMessage($msg_json,$time=1){
		$url1 = self::getUrl1();
		$res = Util::httpPost($url1, $msg_json,$time);
		$res = json_decode((string)$res,true);	
			
		if($res['errmsg'] == 'ok') {
			return array('res'=>true);
		}else{
			return array('res'=>false,'msg'=>$res['errmsg']);
		}
	}	
	



/*************以下是发消息******************/	

	//增加待发消息
	/*static public function addMessage($type,$str,$openid=''){
		global $_W;
		$data = array(
			'uniacid' => $_W['uniacid'],
			'type' => $type,
			'str' => $str,
			'openid' => $openid,
		);
		$res = pdo_insert('zofui_posterhelp_message',$data);
		return $res;
	}*/
	



	
}
