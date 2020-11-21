<?php
class QYJSSDK {
    private $corpId;
    private $corpSecret;
    private $tokens;

    public function __construct($corpId, $corpSecret,$token) {
        $this->corpId = $corpId;
        $this->corpSecret = $corpSecret;
        $this->tokens = $token;

        $this->at_path = '../data/tmp/';
        $this->checkdir($this->at_path);
    }

    public function getAccessToken() {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $file = $this->at_path . $this->tokens."_qy_access.json";
        $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid={$this->corpId}&corpsecret={$this->corpSecret}";

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

    // 获取所有部门
    public function getAllDept() {
        $accessToken = $this->getAccessToken();
        $accessToken = 'M6mnyPpc8zovx-R1BtVeta7WEC15ncZxKUQWxXQMDvO0pw8IljQNHjx8Zq_B9eQA-gPltuOH2knc1GdmU49FgTGYFWyu8veU1HKOIyvqAC5tRUT_ATaG0iz8XSr6Lcp4';

        $url = "https://qyapi.weixin.qq.com/cgi-bin/department/list?access_token={$accessToken}";

        // $json_data = json_encode($send_data);
        $res = $this->httpGet($url);

        return $res;
    }

    // 获取所有用户
    public function getAllUser() {
        $accessToken = $this->getAccessToken();

        // $url = "https://qyapi.weixin.qq.com/cgi-bin/user/simplelist?access_token={$accessToken}&department_id=1&fetch_child=1";
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/list?access_token={$accessToken}&department_id=1&fetch_child=1";

        // $json_data = json_encode($send_data);
        $res = $this->httpGet($url);

        $data_json = json_decode($res, true);
        if (array_key_exists('errcode', $data_json) && array_key_exists('errmsg', $data_json)) {
            $data = $data_json;
        } else {
            $data = array(
                'errcode'=>'1',
                'errmsg'=>'访问出错',
            );
        }

        return $data;
    }



    /**
     * 写文件操作,这个数据是，个数组
     * @param  string $fileAddress 文件路径
     * @param  res    $data        数据，一般是数组
     * @return string              true
     */
    public function fileWriteJson($fileAddress, $data) {
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
    public function fileWrite($fileAddress, $data) {
        $fp = fopen($fileAddress, "w");
        fwrite($fp, $data);
        fclose($fp);
    }

    /**
     * get请求
     * @param  string $url 请求URL
     * @return res         资源
     */
    public function httpGet($url) {
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
    public function httpPost($url, $data) {

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




    protected function checkdir($path) {
        if (!file_exists($path)) {
            mkdir($path, 511);
        }
    }

    /**
     * 清除指字token文件内容
     * @param  string $token token
     * @return [type]        没有返回
     */
    public function clear_file($token){
        $data = json_decode(file_get_contents("./data/jssdk_cache/".$this->tokens."_qy_access.json"));
        $data->expire_time = "";
        $data->access_token = "";
        $fp = fopen("./data/jssdk_cache/".$token."_qy_access.json", "w");
        fwrite($fp, json_encode($data));
        fclose($fp);
    }

    /**
     * 生成验证码
     * @param  integer $length 生成字符串长度，默认为 4 个
     * @return string          随机字符串
     */
    private function createNonceStr($length = 4) {
        $chars = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
}
