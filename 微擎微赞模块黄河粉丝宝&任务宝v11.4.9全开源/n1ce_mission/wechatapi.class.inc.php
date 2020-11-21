<?php
/* encapsulate Wechat APIs */

class WechatAPI
{
  public function sendNews($news,$from_user){
    global $_W;
    $account_api = WeAccount::create();
    $message = array(
      'touser' => $from_user,
      'msgtype' => 'news',
      'news' => array('articles' => $news),
    );
    $status = $account_api->sendCustomNotice($message);
    return $status;
  }
  public function sendText($openid,$info){
    global $_W;
    $message = array(
      'msgtype' => 'text',
      'text' => array('content' => urlencode($info)),
      'touser' => $openid,
    );
    $account_api = WeAccount::create();
    $status = $account_api->sendCustomNotice($message);
    return $status;
  }
  public function sendImage($openid, $media_id)
  {
    global $_W;
    $message = array(
      'msgtype' => 'image',
      'image' => array('media_id' => $media_id),
      'touser' => $openid,
    );
    $account_api = WeAccount::create();
    $status = $account_api->sendCustomNotice($message);
    return $status;
  }
  public function sendCard($openid,$card_id){
    global $_W;
    $message = array(
      'touser' => $openid,
      'msgtype' => 'wxcard',
      'wxcard' => array('card_id'=> $card_id),
    );
    $account_api = WeAccount::create();
    $status = $account_api->sendCustomNotice($message);
    return $status;
  }
  public function sendTempMsg($openid, $template_id, $postdata, $url = '', $topcolor = '#FF683F'){
    global $_W;
    $postdata['first']['value'] = $postdata['first']['value']."\n";
    $postdata['remark']['value'] = "\n".$postdata['remark']['value'];
    $account_api = WeAccount::create();
    $result = $account_api->sendTplNotice($openid, $template_id, $postdata, $url, $topcolor = '#FF683F');
    return $result;
  }
  public function uploadImage($img)
  {
    $url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=" . $this->getAccessToken() . "&type=image";
    $post = array('media' => '@' . $img);
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
    $token = $account->getAccessToken();
    return $token;
  }
  public function getLimitQR($scene_id,$type,$from_user,$rid,$expire){
    global $_W;
    yload()->classs('n1ce_mission','wechatutil');
    if($type == 2){
      $qr_url = WechatUtil::createMobileUrl('subpost','n1ce_mission',array('scene_id' => $scene_id,'rid'=>$rid));
    }else{
      $barcode = array(
          'expire_seconds' => $expire,//30天
          'action_name' => 'QR_SCENE',
          'action_info' => array(
              'scene' => array(
                  'scene_id' => $scene_id
              ),
          ),
      );
      $account_api = WeAccount::create();
      $result = $account_api->barCodeCreateDisposable($barcode);
      $qr_url = $this->getQRImage($result['ticket']);
    }
    return $qr_url;
  }
  public function getQRImage($ticket) {
    $url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket="
      . urlencode($ticket);
    return $url;
  }
  public function sendRedPacket($openid,$money,$cfg){
    global $_W,$_GPC;
    yload()->classs('n1ce_mission','wechatutil');
    $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
    load()->func('communication');
    $pars = array();
    $pars['nonce_str'] = random(32);
    $pars['mch_billno'] = $cfg['pay_mchid'] . date('YmdHis') . rand( 100, 999 );
    $pars['mch_id'] = $cfg['pay_mchid'];
    $pars['wxappid'] = $cfg['appid'];
    //$pars['nick_name'] = $cfg['nick_name'];
    if(!empty($cfg['scene_id'])){
      $pars['scene_id'] = $cfg['scene_id'];
    }
    $pars['send_name'] = $cfg['send_name'];
    $pars['re_openid'] = $openid;
    $pars['total_amount'] = $money;
    $pars['total_num'] = 1;
    $pars['wishing'] = $cfg['wishing'];
    $pars['client_ip'] = $_W['clientip'];
    $pars['act_name'] = $cfg['act_name'];
    $pars['remark'] = $cfg['remark'];
    ksort($pars, SORT_STRING);
    $string1 = '';
    foreach($pars as $k => $v) {
      $string1 .= "{$k}={$v}&";
    }
    $string1 .= "key={$cfg['pay_signkey']}";
    $pars['sign'] = strtoupper(md5($string1));
    $xml = array2xml($pars);
    $extras = array();
    if($cfg['rootca']){
      $extras['CURLOPT_CAINFO'] = IA_ROOT .'/attachment/n1ce_mission/cert_2/' . $_W['uniacid'] . '/' . $cfg['rootca'];
    }
    $extras['CURLOPT_SSLCERT'] = IA_ROOT .'/attachment/n1ce_mission/cert_2/' . $_W['uniacid'] . '/' . $cfg['apiclient_cert'];
    $extras['CURLOPT_SSLKEY'] = IA_ROOT .'/attachment/n1ce_mission/cert_2/' . $_W['uniacid'] . '/' . $cfg['apiclient_key'];
    $procResult = false;
    $resp = ihttp_request($url, $xml, $extras);
    if(is_error($resp)) {
      $procResult = $resp['message'];
    } else {
      $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
      $dom = new DOMDocument();
      if($dom->loadXML($xml)) {
        $xpath = new DOMXPath($dom);
        $code = $xpath->evaluate('string(//xml/return_code)');
        $ret = $xpath->evaluate('string(//xml/result_code)');
        if(strtolower($code) == 'success' && strtolower($ret) == 'success') {
          $procResult = true;
        } else {
          $error = $xpath->evaluate('string(//xml/err_code_des)');
          $procResult = $error;
        }
      } else {
        $procResult = 'error response';
      }
    }
    return $procResult;
  }
  /**
  * 服务商红包
  * by：黄河  QQ：541535641
  **/
  public function sendSubRedPacket($openid,$money){
    global $_W,$_GPC;
    yload()->classs('n1ce_mission','wechatutil');
    $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
    load()->func('communication');
    $pars = array();
    $cfg = WechatUtil::getOtherSettings('n1ce_redcode_plugin_affiliate');
    $pars['nonce_str'] = random(32);
    $pars['mch_billno'] = $cfg['mch_id'] . date('YmdHis') . rand( 100, 999 );
    $pars['mch_id'] = $cfg['mch_id'];
    $pars['sub_mch_id'] = $cfg['sub_mch_id'];
    $pars['wxappid'] = $cfg['wxappid'];
    $pars['msgappid'] = $cfg['msgappid'];
    if(!empty($cfg['scene_id'])){
      $pars['scene_id'] = $cfg['scene_id'];
    }
    $pars['send_name'] = $cfg['send_name'];
    $pars['re_openid'] = $openid;
    $pars['total_amount'] = $money;
    $pars['total_num'] = 1;
    $pars['wishing'] = $cfg['wishing'];
    $pars['client_ip'] = $_W['clientip'];
    $pars['act_name'] = $cfg['act_name'];
    $pars['remark'] = $cfg['remark'];
    if($cfg['consume_mch_id'] == 2){
      $pars['consume_mch_id'] = $cfg['mch_id'];
    }
    ksort($pars, SORT_STRING);
    $string1 = '';
    foreach($pars as $k => $v) {
      $string1 .= "{$k}={$v}&";
    }
    $string1 .= "key={$cfg['pay_signkey']}";
    $pars['sign'] = strtoupper(md5($string1));
    $xml = array2xml($pars);
    $extras = array();
    if($cfg['rootca']){
      $extras['CURLOPT_CAINFO'] = IA_ROOT .'/attachment/n1ce_affiliate/cert_2/' . $_W['uniacid'] . '/' . $cfg['rootca'];
    }
    
    $extras['CURLOPT_SSLCERT'] = IA_ROOT .'/attachment/n1ce_affiliate/cert_2/' . $_W['uniacid'] . '/' . $cfg['apiclient_cert'];
    $extras['CURLOPT_SSLKEY'] = IA_ROOT .'/attachment/n1ce_affiliate/cert_2/' . $_W['uniacid'] . '/' . $cfg['apiclient_key'];
    $procResult = false;
    $resp = ihttp_request($url, $xml, $extras);
    if(is_error($resp)) {
      $procResult = $resp['message'];
    } else {
      $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
      $dom = new DOMDocument();
      if($dom->loadXML($xml)) {
        $xpath = new DOMXPath($dom);
        $code = $xpath->evaluate('string(//xml/return_code)');
        $ret = $xpath->evaluate('string(//xml/result_code)');
        if(strtolower($code) == 'success' && strtolower($ret) == 'success') {
          $procResult = true;
        } else {
          $error = $xpath->evaluate('string(//xml/err_code_des)');
          $procResult = $error;
        }
      } else {
        $procResult = 'error response';
      }
    }
    return $procResult;
  }

  function array2xml($arr, $level = 1) {
    $s = $level == 1 ? "<xml>" : '';
    foreach ($arr as $tagname => $value) {
      if (is_numeric($tagname)) {
        $tagname = $value['TagName'];
        unset($value['TagName']);
      }
      if (!is_array($value)) {
        $s .= "<{$tagname}>" . (!is_numeric($value) ? '<![CDATA[' : '') . $value . (!is_numeric($value) ? ']]>' : '') . "</{$tagname}>";
      } else {
        $s .= "<{$tagname}>" . array2xml($value, $level + 1) . "</{$tagname}>";
      }
    }
    $s = preg_replace("/([\x01-\x08\x0b-\x0c\x0e-\x1f])+/", ' ', $s);
    return $level == 1 ? $s . "</xml>" : $s;
  }
}
