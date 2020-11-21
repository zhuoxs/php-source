<?php
class fengniao
{
    private $token;
    public  $API_URL = '';
    public  $APP_ID = '';
    public  $SECRET_KEY = '';

    function __construct($appid, $key, $mode = 1)
    {
        if ($mode == 1) {
            $this->API_URL = 'https://open-anubis.ele.me/anubis-webapi';
        } else {
            $this->API_URL = 'https://exam-anubis.ele.me/anubis-webapi';
        }

        $this->APP_ID = $appid;
        $this->SECRET_KEY = $key;
    }

    function generateSign($appId, $salt, $secretKey) {
        $seed = 'app_id=' . $appId . '&salt=' . $salt . '&secret_key=' . $secretKey;
        return md5(urlencode($seed));
    }

    function generateBusinessSign($appId, $token, $urlencodeData, $salt) {
        $seed = 'app_id=' . $appId . '&access_token=' . $token
            . '&data=' . $urlencodeData . '&salt=' . $salt;
        return md5($seed);
    }

    // step 2 创建订单
    public function sendOrder($dataArray)
    {
        $salt = mt_rand(1000, 9999);
        $dataJson = json_encode($dataArray, JSON_UNESCAPED_UNICODE);
        $urlencodeData = urlencode($dataJson) . PHP_EOL;
        $sig = $this->generateBusinessSign($this->APP_ID, $this->token, $urlencodeData, $salt);   //生成签名
        $requestJson = json_encode(array(
            'app_id' => $this->APP_ID,
            'salt' => $salt,
            'data' => $urlencodeData,
            'signature' => $sig
        ));

        $url = $this->API_URL . '/v2/order';
        return $this->doPost($url, $requestJson);
    }

    //查询门店配送范围
    public function queryRange($chain_store_code)
    {
        $url = $this->API_URL . "/v2/store/range";
        $data = array("chain_store_code" => $chain_store_code);
        $dataJson = json_encode($data, JSON_UNESCAPED_UNICODE);
        $salt = mt_rand(1000, 9999);
        $urlencodeData = urlencode($dataJson);
        $sig = $this->generateBusinessSign($this->APP_ID, $this->token, $urlencodeData, $salt);   //生成签名

        $requestJson = json_encode(array(
            'app_id' => $this->APP_ID,
            'salt' => $salt,
            'data' => $urlencodeData,
            'signature' => $sig
        ));
        return $this->doPost($url, $requestJson) . PHP_EOL;   //发送请求
    }


    //订单投诉
    public function complaintQrder($data)
    {
        $url = $this->API_URL . "/v2/order/complaint";
        $dataJson = json_encode($data, JSON_UNESCAPED_UNICODE);
        $salt = mt_rand(1000, 9999);
        $urlencodeData = urlencode($dataJson);
        $sig = $this->generateBusinessSign($this->APP_ID, $this->token, $urlencodeData, $salt);   //生成签名
        $requestJson = json_encode(array(
            'app_id' => $this->APP_ID,
            'salt' => $salt,
            'data' => $urlencodeData,
            'signature' => $sig
        ));
        return $this->doPost($url, $requestJson) . PHP_EOL;   //发送请求
    }

    public function queryQrder($partner_order_code)
    {
        $url = $this->API_URL . "/v2/order/query";
        $data = array("partner_order_code" => $partner_order_code);
        $dataJson = json_encode($data, JSON_UNESCAPED_UNICODE);
        $salt = mt_rand(1000, 9999);
        $urlencodeData = urlencode($dataJson);
        $sig = $this->generateBusinessSign($this->APP_ID, $this->token, $urlencodeData, $salt);   //生成签名

        $requestJson = json_encode(array(
            'app_id' => $this->APP_ID,
            'salt' => $salt,
            'data' => $urlencodeData,
            'signature' => $sig
        ));

        return $this->doPost($url, $requestJson) . PHP_EOL;   //发送请求
    }

    //查配送范围
    public function queryStoreDelivery($dataArray)
    {
        $salt = mt_rand(1000, 9999);
        $dataJson = json_encode($dataArray, JSON_UNESCAPED_UNICODE);
        $urlencodeData = urlencode($dataJson) . PHP_EOL;
        $sig = $this->generateBusinessSign($this->APP_ID, $this->token, $urlencodeData, $salt);   //生成签名
        $requestJson = json_encode(array(
            'app_id' => $this->APP_ID,
            'salt' => $salt,
            'data' => $urlencodeData,
            'signature' => $sig
        ));
        $url = $this->API_URL . '/v2/chain_store/delivery/query';
        return $this->doPost($url, $requestJson);
    }

    //订单骑手位置
    public function getcarrier($partner_order_code)
    {
        $url = $this->API_URL . "/v2/order/carrier";
        $data = array("partner_order_code" => $partner_order_code);
        $dataJson = json_encode($data, JSON_UNESCAPED_UNICODE);
        $salt = mt_rand(1000, 9999);
        $urlencodeData = urlencode($dataJson);
        $sig = $this->generateBusinessSign($this->APP_ID, $this->token, $urlencodeData, $salt);   //生成签名

        $requestJson = json_encode(array(
            'app_id' => $this->APP_ID,
            'salt' => $salt,
            'data' => $urlencodeData,
            'signature' => $sig
        ));

        return $this->doPost($url, $requestJson) . PHP_EOL;   //发送请求
    }

    public function cancelQrder($data) {

        $url = $this->API_URL . "/v2/order/cancel";
        $dataJson = json_encode($data);
        $salt = mt_rand(1000, 9999);
        $urlencodeData = urlencode($dataJson);
        $sig = $this->generateBusinessSign($this->APP_ID, $this->token, $urlencodeData, $salt);   //生成签名

        $requestJson = json_encode(array(
            'app_id' => $this->APP_ID,
            'salt' => $salt,
            'data' => $urlencodeData,
            'signature' => $sig
        ));

        return $this->doPost($url, $requestJson);
    }

    // step 1
    public function requestToken()
    {
        $salt = mt_rand(1000, 9999);
        // 获取签名
        $sig = $this->generateSign($this->APP_ID, $salt, $this->SECRET_KEY);
        $url = $this->API_URL . '/get_access_token';
        $tokenStr = $this->doGet($url, array('app_id' => $this->APP_ID, 'salt' => $salt, 'signature' => $sig));
        // echo $tokenStr;
        // 获取token
        $tokenStr = json_decode($tokenStr, true);

        $this->token = $tokenStr['data']['access_token'];
    }

    public function getToken()
    {
        return $this->token;
    }


    /**
     * 发送GET请求
     * @param string $url
     * @param array $param
     * @return bool|mixed
     */
    function doGet($url, $param = null)
    {
        if (empty($url) or (!empty($param) and !is_array($param))) {
            throw new InvalidArgumentException('Params is not of the expected type');
        }
        // 验证url合法性
//        if (!filter_var($url, FILTER_VALIDATE_URL)) {
//            throw new InvalidArgumentException('Url is not valid');
//        }

        if (!empty($param)) {
            $url = trim($url, '?') . '?' . http_build_query($param);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     //  不进行ssl 认证
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if (!empty($result) and $code == 200) {
            return $result;
        }
        return false;
    }

    /**
     * POST请求
     * @param $url
     * @param $param
     * @return boolean|mixed
     */
    function doPost($url, $param, $method = "POST")
    {
        // echo 'Request url is ' . $url . PHP_EOL;
        if (empty($url) or empty($param)) {
            throw new InvalidArgumentException('Params is not of the expected type');
        }

        // 验证url合法性
//        if (!filter_var($url, FILTER_VALIDATE_URL)) {
//            throw new InvalidArgumentException('Url is not valid');
//        }

        if (!empty($param) and is_array($param)) {
            $param = urldecode(json_encode($param));
        } else {
            // $param = urldecode(strval($param));
            $param = strval($param);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     //  不进行ssl 认证

        if (strcmp($method, "POST") == 0) {  // POST 操作
            curl_setopt($ch, CURLOPT_POST, true);
        } else if (strcmp($method, "DELETE") == 0) { // DELETE操作
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        } else {
            throw new InvalidArgumentException('Please input correct http method, such as POST or DELETE');
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: Application/json'));
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if (!empty($result) and $code == '200') {
            return $result;
        }
        return false;
    }
}