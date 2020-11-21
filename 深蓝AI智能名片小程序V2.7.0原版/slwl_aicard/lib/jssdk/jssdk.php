<?php
class JSSDK {
	private $appId;
	private $appSecret;
	private $tokens;

	public function __construct($appId, $appSecret,$token) {
		$this->appId = $appId;
		$this->appSecret = $appSecret;
		$this->tokens = $token;

		$this->at_path = '../data/tpl/tmp/';
		$this->checkdir($this->at_path);
	}

	public function getAccessToken() {
		$file = $this->at_path . $this->tokens . ".json";
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appId}&secret={$this->appSecret}";

		if (!file_exists($file)) {
			$this->fileWriteJson($file, '');
		}

		$data = json_decode(file_get_contents($file));
		if(!property_exists($data, 'expire_time') || $data->expire_time < time()){
			$res = json_decode($this->httpGet($url));
			$access_token = $res->access_token;
			if ($access_token) {
				$data = new stdClass();
				$data->expire_time = time() + 7000;
				$data->access_token = $access_token;

				$this->fileWriteJson($file, $data);
			}
		} else {
			$access_token = $data->access_token;
		}
		return $access_token;
	}

	// 废用
	// public function pushTemplateMsg($openid, $template_id, $formid) {
	//     $access_token = $this->getAccessToken();

	//     $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token={$access_token}";

	//     $curr_date = date('Y-m-d H:i:s', time());

	//     $data = array();
	//     $data['touser'] = $openid;
	//     $data['template_id'] = $template_id;
	//     $data['form_id'] = $formid;
	//     $data['data'] = array(
	//         'first' => array('value'=>'报告老板，有新的预约，请及时处理', 'color'=>'#173177', 'font-size'=>'20px'),
	//         'keyword1' => array('value'=>'13579246810', 'color'=>'#173177'),
	//         'keyword2' => array('value'=>'金夫人，多少钱了', 'color'=>'#173177'),
	//         'keyword3' => array('value'=> $curr_date, 'color'=>'#173177'),
	//         'remark' => array('value'=>'预计在1-2个工作日内给您绑定的银行卡存入 99 元，请您注意查收。', 'color'=>'#173177')
	//     );

	//     $json_data = json_encode($data);

	//     $res = json_decode($this->httpPost($url, $json_data));

	//     return $res;
	// }

	// 发送模板消息
	public function templates_send_client($ds) {
		$access_token = $this->getAccessToken();

		$url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token={$access_token}";

		$curr_date = date('Y-m-d H:i:s', time());

		$data = array();
		$data['touser'] = $ds['openid'];
		$data['template_id'] = $ds['template_id'];
		$data['form_id'] = $ds['form_id'];
		$data['page'] = 'pages/chat/chat?cuid='.$ds['uid'];
		$data['data'] = array(
			'keyword1' => array('value'=>$ds['username']),
			'keyword2' => array('value'=>$ds['datetime']),
			'keyword3' => array('value'=> '你有未读消息。'),
		);
		// 'keyword4' => array('value'=>'报告老板，有新的预约，请及时处理！', 'color'=>'#173177'),

		$json_data = json_encode($data);

		$res = json_decode($this->httpPost($url, $json_data));

		return $res;
	}

	// 添加模板，小程序模板消息
	public function templates_add() {
		$access_token = $this->getAccessToken();

		$url = "https://api.weixin.qq.com/cgi-bin/wxopen/template/add?access_token={$access_token}";

		// 从1开始
		$post_data = array(
			'id' => 'AT0782',
			'keyword_id_list' => [5,8,9],
		);

		$json_data = json_encode($post_data);

		$res = json_decode($this->httpPost($url, $json_data));

		return $res;
	}

	// 删除模板，小程序模板消息
	public function templates_delete($template_id) {
		$access_token = $this->getAccessToken();

		$url = "https://api.weixin.qq.com/cgi-bin/wxopen/template/del?access_token={$access_token}";

		$post_data = array(
			'template_id' => $template_id,
		);

		$json_data = json_encode($post_data);

		$res = json_decode($this->httpPost($url, $json_data));

		return $res;
	}

	// 生成二维码
	public function qrcode_create($id) {
		$access_token = $this->getAccessToken();

		$url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token={$access_token}&is_hyaline=true";

		$post_data = array(
			'scene' => $id,
			'page' => 'pages/index/index',
		);

		$json_data = json_encode($post_data);

		$stream_data = $this->httpPost($url, $json_data);

		if (!(empty($stream_data))) {
			$json_stream = json_decode($stream_data, true);

			if ($json_stream) {
				$return_data = array(
					'errcode'=>'1',
					'errmsg'=>'生成失败',
					'data'=>$json_stream['errcode'].'-'.$json_stream['errmsg'],
				);
				return $return_data;
			}

			$file = $this->get_file_name();
			$file_path = ATTACHMENT_ROOT . $file;

			$this->fileWrite($file_path, $stream_data);

			//图片是否存在
			if(file_exists($file_path))
			{
				$return_data = array(
					'errcode'=>'0',
					'errmsg'=>'生成成功',
					'data'=>$file,
				);
				return $return_data;
			} else {
				$return_data = array(
					'errcode'=>'1',
					'errmsg'=>'生成失败',
					'data'=>$stream_data,
				);
				return $return_data;
			}
		} else {
			$return_data = array(
				'errcode'=>'2',
				'errmsg'=>'生成失败或写入失败',
				'data'=>$stream_data,
			);
			return $return_data;
		}
	}

	// 获取文件名
	protected function get_file_name()
	{
		global $_W;

		$uniacid = $_W['uniacid'];
		$curr_y = date("Y", time());
		$curr_m = date("m", time());

		$qrcode = "qrcode/";
		$tmppath = ATTACHMENT_ROOT . $qrcode;
		$u       = $tmppath . $uniacid . "/";
		$y       = $u . $curr_y . "/";
		$m       = $y . $curr_m . "/";
		$this->checkdir($tmppath);
		$this->checkdir($u);
		$this->checkdir($y);
		$this->checkdir($m);

		//获取毫秒的时间戳
		$time = explode (" ", microtime ());
		$time = substr($time[0], 2, 3);

		$code = $qrcode . $uniacid . "/" . $curr_y . "/" . $curr_m . "/" . 'C' . date('YmdHis', time()) . $time . '.jpg';

		return $code;
	}



	protected function checkdir($path) {
		if (!file_exists($path)) {
			mkdir($path, 511);
		}
	}

	/**
	 * 写文件操作,这个数据是，个数组
	 * @param  string $fileAddress 文件路径
	 * @param  res    $data        数据，一般是数组
	 * @return string              true
	 */
	protected function fileWriteJson($fileAddress, $data) {
		$fp = fopen($fileAddress, "w");
		fwrite($fp, json_encode($data));
		fclose($fp);
	}

	/**
	 * 写文件操作,这个数据是，Josn字符串
	 * @param  string $fileAddress 文件路径
	 * @param  res    $data        数据，一般是数组
	 * @return string              true
	 */
	protected function fileWrite($fileAddress, $data) {
		$fp = fopen($fileAddress, "w");
		fwrite($fp, $data);
		fclose($fp);
	}

	/**
	 * get请求
	 * @param  string $url 请求URL
	 * @return res         资源
	 */
	protected function httpGet($url) {
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

	/**
	 * post请求
	 * @param  string $url  请求URL
	 * @param  array  $data post数据
	 * @return res          资源
	 */
	protected function httpPost($url, $data) {

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HEADER, 0);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //要求结果保存到字符串中还是输出到屏幕上

		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

		$res = curl_exec($curl);
		curl_close($curl);

		return $res;
	}
}
