<?php
class templateMessage
{
    function __construct()
    {

    }

    /** Bowen 的模板消息发送 */
    function mysendTplNotice($touser, $template_id, $postdata, $url = '', $topcolor = '#FF683F', $miniprogram = array()) {
        $account_api = WeAccount::create();
		if(empty($account_api->account['key']) || $account_api->account['level'] != ACCOUNT_SERVICE_VERIFY) {
			return error(-1, '你的公众号没有发送模板消息的权限');
		}
		if(empty($touser)) {
			return error(-1, '参数错误,粉丝openid不能为空');
		}
		if(empty($template_id)) {
			return error(-1, '参数错误,模板标示不能为空');
		}
		if(empty($postdata) || !is_array($postdata)) {
			return error(-1, '参数错误,请根据模板规则完善消息内容');
		}
		$token = $account_api->getAccessToken();
		if (is_error($token)) {
			return $token;
		}
		
		$data = array();
		$data['touser'] = $touser;
		$data['template_id'] = trim($template_id);
		$data['url'] = trim($url);
		$data['topcolor'] = trim($topcolor);
		$data['data'] = $postdata;
        if(!empty($miniprogram)){
            $data['miniprogram'] = $miniprogram;
        }
		$data = json_encode($data);
		$post_url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$token}";
		$response = ihttp_request($post_url, $data);
		if(is_error($response)) {
			return error(-1, "访问公众平台接口失败, 错误: {$response['message']}");
		}
		$result = @json_decode($response['content'], true);
		if(empty($result)) {
			return error(-1, "接口调用失败, 元数据: {$response['meta']}");
		} elseif(!empty($result['errcode'])) {
			return error(-1, "访问微信接口错误, 错误代码: {$result['errcode']}, 错误信息: {$result['errmsg']},信息详情：{$account_api->errorCode($result['errcode'])}");
		}
		return true;
	}

    public function send_template_message($touser, $template_id, $postdata, $access_token = '', $url = '', $topcolor = '#FF683F')
    {
        /**
        $data = array();
        $data['touser'] = $touser;
        $data['template_id'] = trim($template_id);
        $data['url'] = trim($url);
        $data['topcolor'] = trim($topcolor);
        $data['data'] = $postdata;
        $data = json_encode($data);
        $posturl = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
        $res = $this->https_request($posturl, $data);
        return json_decode($res, true);
        */
        return $this->mysendTplNotice($touser, $template_id, $postdata, $url, $topcolor);
    }

    function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}