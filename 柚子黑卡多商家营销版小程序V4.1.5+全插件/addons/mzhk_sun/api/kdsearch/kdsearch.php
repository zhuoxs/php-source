<?php 

class Kdsearch {

    protected $ebusinessid;//电商ID
    protected $appkey;//电商加密私钥
    protected $shippercode;//快递公司编码
    protected $logisticcode;//物流单号

    function __construct($ebusinessid,$appkey, $shippercode, $logisticcode) {
        $this->ebusinessid = $ebusinessid;
        $this->appkey = $appkey;
		$this->shippercode = $shippercode;
        $this->logisticcode = $logisticcode;
    }

	/**
	 * Json方式 查询订单物流轨迹
	 */
	function getOrderTracesByJson(){
		
		$requrl = "http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx";
		
		$requestData= "{'OrderCode':'','ShipperCode':'$this->shippercode','LogisticCode':'$this->logisticcode'}";
		
		$datas = array(
			'EBusinessID' => $this->ebusinessid,
			'RequestType' => '1002',
			'RequestData' => urlencode($requestData) ,
			'DataType' => '2',
		);

		$datas['DataSign'] = $this->encrypt($requestData, $this->appkey);

		$result=$this->sendPost($requrl,$datas);	
		
		//根据公司业务处理返回的信息......
		
		return $result;
	}
	 
	/**
	 * post提交数据 
	 * @param  string $url 请求Url
	 * @param  array $datas 提交的数据 
	 * @return url响应返回的html
	 */
	function sendPost($url, $datas) {
		$temps = array();	
		foreach ($datas as $key => $value) {
			$temps[] = sprintf('%s=%s', $key, $value);		
		}	
		$post_data = implode('&', $temps);
		$url_info = parse_url($url);
		if(empty($url_info['port']))
		{
			$url_info['port']=80;	
		}
		$httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
		$httpheader.= "Host:" . $url_info['host'] . "\r\n";
		$httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
		$httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
		$httpheader.= "Connection:close\r\n\r\n";
		$httpheader.= $post_data;
		$fd = fsockopen($url_info['host'], $url_info['port']);
		fwrite($fd, $httpheader);

		$gets = "";
		$headerFlag = true;
		while (!feof($fd)) {
			if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
				break;
			}
		}
		while (!feof($fd)) {
			$gets.= fread($fd, 128);
		}
		fclose($fd);
		
		
		return $gets;
	}

	/**
	 * 电商Sign签名生成
	 * @param data 内容   
	 * @param appkey Appkey
	 * @return DataSign签名
	 */
	function encrypt($data, $appkey) {
		return urlencode(base64_encode(md5($data.$appkey)));
	}

}		
			
		
