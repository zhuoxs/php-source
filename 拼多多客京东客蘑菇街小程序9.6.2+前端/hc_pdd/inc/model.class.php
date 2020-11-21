<?php

class HcfkModel

{

	public function test(){

		echo 1;

	}



	/**

	* $msg 待提示的消息

	* $url 待跳转的链接

	* $icon 这里主要有两个，5和6，代表两种表情（哭和笑）

	* $time 弹出维持时间（单位秒）

	*/

	function alert_success($msg='',$url,$time=3){ 

		$str='<script type="text/javascript" src="../addons/hc_fk/template/web/js/jquery-1.8.2.min.js"></script> <script type="text/javascript" src="../addons/hc_fk/template/web/js/layer/layer.js"></script>';//加载jquery和layer

		$str.='<script>

		$(function(){

		  	layer.msg("'.$msg.'",{time:'.($time*1000).'});

			setTimeout(function(){

				window.location.href="'.$url.'";

			},2000);

		});

		</script>';//主要方法

		echo $str;

	}



	/**

	* $msg 待提示的消息

	* $icon 这里主要有两个，5和6，代表两种表情（哭和笑）

	* $time 弹出维持时间（单位秒）

	*/

	function alert_error($msg='',$time=3){ 

		$str='<script type="text/javascript" src="../addons/hc_fk/template/web/js/jquery-1.8.2.min.js"></script> <script type="text/javascript" src="../addons/hc_fk/template/web/js/layer/layer.js"></script>';//加载jquery和layer

		$str.='<script>

		$(function(){

		  layer.msg("'.$msg.'",{time:'.($time*1000).'});

		  setTimeout(function(){

		      window.history.go(-1);

		  },2000)

		});

		</script>';//主要方法

		echo $str;

	}







	 // 获取指定长度的随机字符串

    function getRandChar($length)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;
        for ($i = 0; $i < $length; $i ++) {
            $str .= $strPol[rand(0, $max)]; // rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }
        return $str;
    }

    /*

     * 生成签名

     */

    function getSign($Obj,$api_key)
    {
        foreach ($Obj as $k => $v) {
            $Parameters[strtolower($k)] = $v;
        }
        // 签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        // echo "【string】 =".$String."</br>";
        // 签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $api_key;
        // echo "<textarea style='width: 50%; height: 150px;'>$String</textarea> <br />";
        // 签名步骤三：MD5加密
        $result_ = strtoupper(md5($String));
        return $result_;
    }

    

    /*

     * 生成签名

     */

    function getSign1($Obj,$api_key)
    {
        foreach ($Obj as $k => $v) {
            $Parameters[strtolower($k)] = $v;
        }
        // 签名步骤一：按字典序排序参数
        ksort($Parameters);
        //$String = $this->formatBizQueryParaMap($Parameters, false);
        $String  = "appId=".$Obj['appId']."&nonceStr=".$Obj['nonceStr']."&package=".$Obj['package']."&signType=MD5&timeStamp=".$Obj['timeStamp']; 
        // echo "【string】 =".$String."</br>";
        // 签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $api_key;
        // echo "<textarea style='width: 50%; height: 150px;'>$String</textarea> <br />";
        // 签名步骤三：MD5加密
        //echo $String;
        $result_ = strtoupper(md5($String));
        return $result_;
    }

    

    /*

     * 获取当前服务器的IP

     */

    function get_client_ip()

    {

        if ($_SERVER['REMOTE_ADDR']) {

            $cip = $_SERVER['REMOTE_ADDR'];

        } elseif (getenv("REMOTE_ADDR")) {

            $cip = getenv("REMOTE_ADDR");

        } elseif (getenv("HTTP_CLIENT_IP")) {

            $cip = getenv("HTTP_CLIENT_IP");

        } else {

            $cip = "unknown";

        }

        return $cip;

    }

    

    // 数组转xml

    function arrayToXml($arr)

    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
        }
        $xml .= "</xml>";
        // print_r($this->xmlstr_to_array($xml));
        // echo "--------";
        // exit;
        return $xml;
    }

    // post https请求，CURLOPT_POSTFIELDS xml格式

    function postXmlCurl($xml, $url, $second = 30)
    {
        // 初始化curl
        $ch = curl_init();
        // 超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        // 这里设置代理，如果有的话
        // curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        // curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // 设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        // 要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        // post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        // 运行curl
        $data = curl_exec($ch);
        // 返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            echo "curl出错，错误码:$error" . "<br>";
                echo "<a href='http://curl.haxx.se/libcurl/c/libcurl-errors.html'>错误原因查询</a></br>";
                    curl_close($ch);
                    return false;
        }

    }

    

    /**

     * xml转成数组

     */

    function xmlstr_to_array($xmlstr)
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xmlstring = simplexml_load_string($xmlstr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $val = json_decode(json_encode($xmlstring),true);
        return $val;
    }

    

    // 将数组转成uri字符串

    function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            $buff .= strtolower($k) . "=" . $v . "&";
        }
        $reqPar;
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }

    

    function domnode_to_array($node)
    {
        $output = array();
        switch ($node->nodeType) {
            case XML_CDATA_SECTION_NODE:
            case XML_TEXT_NODE:
                $output = trim($node->textContent);
                break;
            case XML_ELEMENT_NODE:
                for ($i = 0, $m = $node->childNodes->length; $i < $m; $i ++) {
                    $child = $node->childNodes->item($i);
                    $v = $this->domnode_to_array($child);
                    if (isset($child->tagName)) {
                        $t = $child->tagName;
                        if (! isset($output[$t])) {
                            $output[$t] = array();
                        }
                        $output[$t][] = $v;
                    } elseif ($v) {
                        $output = (string) $v;
                    }
                }
                if (is_array($output)) {
                    if ($node->attributes->length) {
                        $a = array();
                        foreach ($node->attributes as $attrName => $attrNode) {
                            $a[$attrName] = (string) $attrNode->value;
                        }
                        $output['@attributes'] = $a;
                    }
                    foreach ($output as $t => $v) {
                        if (is_array($v) && count($v) == 1 && $t != '@attributes') {
                            $output[$t] = $v[0];
                        }
                    }
                }
                break;
        }
        return $output;
    }





}