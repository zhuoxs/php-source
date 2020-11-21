<?php
/**
 * 【超人】二手市场
 *
 * @author 超人
 * @url http://bbs.we7.cc/thread-13060-1-1.html
 */
defined('IN_IA') or exit('Access Denied');
class SupermanHandExpress {
    protected $reqURL;
    protected $eBusinessID;  //商户ID
    protected $app_key;      //appkey
    protected $express_com; //快递公司
    protected $express_no;  //快递单号
    public function __construct($eBusinessID, $app_key, $express_com, $express_no) {
        $this->eBusinessID = $eBusinessID;
        $this->app_key = $app_key;
        $this->express_com = $express_com;
        $this->express_no = $express_no;
        $this->reqURL = 'http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx';
    }
    public function query() {
        $method = "kdniao_query";
        return $this->$method();
    }
    private function kdniao_query() {
        if (!$this->express_no) {
            return false;
        }
        $requestData = "{'ShipperCode':'{$this->express_com}','LogisticCode':'{$this->express_no}'}";

        $datas = array(
            'EBusinessID' => $this->eBusinessID,
            'RequestType' => '1002',
            'RequestData' => urlencode($requestData) ,
            'DataType' => '2',
        );
        $datas['DataSign'] = urlencode(base64_encode(md5($requestData.$this->app_key)));
        $result = $this->sendPost($this->reqURL, $datas);
        $info = $result ? json_decode($result, true) : array();
        return $info;
    }
    public function sendPost($url, $datas) {
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
}