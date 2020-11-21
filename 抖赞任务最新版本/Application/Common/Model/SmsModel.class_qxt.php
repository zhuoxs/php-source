<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 短信发送 企信通2.0
 */
class SmsModel extends BaseModel{
    /*--------------------------------
功能:		企信通PHP HTTP接口 发送短信
修改日期:	2014-03-19
说明:		http://api.cnsms.cn/?ac=send&uid=用户账号&pwd=MD5位32密码&mobile=号码&content=内容
状态:
	100 发送成功
	101 验证失败
	102 短信不足
	103 操作失败
	104 非法字符
	105 内容过多
	106 号码过多
	107 频率过快
	108 号码内容空
	109 账号冻结
	110 禁止频繁单条发送
	111 系统暂定发送
	112 号码不正确
	120 系统升级
--------------------------------*/
    /*$uid = '9999';		//用户账号
    $pwd = '9999';		//密码
    $mobile	 = '13912341234,13312341234,13512341234';	//号码
    $content = '企信通PHP HTTP接口';		//内容
    //即时发送
    $res = sendSMS($uid,$pwd,$mobile,$content);
    echo $res;

    //定时发送
    $time = '2010-05-27 12:11';
    $res = sendSMS($uid,$pwd,$mobile,$content,$time);
    echo $res;*/

    public static function send($mobile,$content,&$error_msg)
    {
        $config = C('SMS');
        $url = $config['url'];
        $userid =  $config['user_id'];
        $password = $config['password'];

        //$content = $config['sign'] . $content;
        $content = iconv( "UTF-8","GB2312//IGNORE",$content);
        $data = array
        (
            'ac'=>'send',
            'uid'=>$userid,					//用户账号
            'pwd'=>strtolower(md5($password)),	//MD5位32密码
            'mobile'=>$mobile,				//号码
            'content'=>$content,			//内容
            'time'=>'',		//定时发送
        );
        //print_r($data);
        $re= self::postSMS($url,$data);			//POST方式提交
        if( trim($re) == '100' )
        {
            return true;
        }
        else
        {
            $error_msg = "发送失败,错误代码：" . $re;
            return false;
        }
    }

    private static function postSMS($url,$data='')
    {
        $row = parse_url($url);
        $host = $row['host'];
        $port = $row['port'] ? $row['port']:80;
        $file = $row['path'];
        $post = '';
        while (list($k,$v) = each($data))
        {
            $post .= rawurlencode($k)."=".rawurlencode($v)."&";	//转URL标准码
        }
        $post = substr( $post , 0 , -1 );
        $len = strlen($post);
        $fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
        if (!$fp) {
            return "$errstr ($errno)\n";
        } else {
            $receive = '';
            $out = "POST $file HTTP/1.0\r\n";
            $out .= "Host: $host\r\n";
            $out .= "Content-type: application/x-www-form-urlencoded\r\n";
            $out .= "Connection: Close\r\n";
            $out .= "Content-Length: $len\r\n\r\n";
            $out .= $post;
            fwrite($fp, $out);
            while (!feof($fp)) {
                $receive .= fgets($fp, 128);
            }
            fclose($fp);
            $receive = explode("\r\n\r\n",$receive);
            unset($receive[0]);
            return implode("",$receive);
        }
    }
}