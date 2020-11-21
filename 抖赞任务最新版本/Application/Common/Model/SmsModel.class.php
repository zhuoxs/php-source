<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 短信发送 企信通2.0
 */
class SmsModel extends BaseModel{


    var $username;
    var $password;
    var $sign;

    var $wsdl="https://dx.ipyy.net/webservice.asmx?wsdl";

    //var $TokenId	= '36273ebc6f9c4cb783d80278aca8e48c';

    public function __construct($username=null, $account=null, $password=null) {
        $config = C('SMS');

        if ($username) {
            $this->username = $username;
        } else {
            $this->username = $config['user_id'];
        }

        if ($password) {
            $this->password = $password;
        } else {
            $this->password = $config['password'];
        }

        if( !empty($config['url']) ) {
            $this->wsdl = $config['url'];
        }

        $this->sign = $config['sign'];
    }

    public function send($mobiles,$content,&$error_msg)
    {
        $content = $content . $this->sign;
        return $this->http_post($mobiles,$content,$error_msg);
    }

    /**
     * CURL发送
     * @param $mobile
     * @param $msg
     * @param string $extno
     * @param null $plansendtime
     */
    public function http_post($mobile,$msg,&$error_msg)
    {
        $url = 'https://dx.ipyy.net/smsJson.aspx';
        $data = array(
            'userid' => '',
            'account' => $this->username,
            'password' => $this->password,
            'mobile' => $mobile,
            'content' => $msg,
            'sendTime' => '',
            'action' => 'send',
            'extno' => ''
        );
        $data = http_build_query($data);
        $request = curl_init($url);
        curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
        curl_setopt($request, CURLOPT_POSTFIELDS, $data); // use HTTP POST to send form data
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
        $result = curl_exec($request); // execute curl post and store results in $auth_ticket
        curl_close ($request);

        $result = json_decode($result, true);

        if( $result['returnstatus'] == 'Success' ) {
            return true;
        } else {
            $error_msg = "发送失败,错误代码：" . $result['message'];
            return false;
        }
    }

}