<?php
global $_W, $_GPC;		
		$itemid=$_GPC['itemid'];
		//$url="http://h5api.m.taobao.com/h5/mtop.taobao.detail.getdesc/6.0/?jsv=2.4.16&appKey=12574478&t=1539762947823&sign=016e02c1398f6799afbd047d0e3f17a9&api=mtop.taobao.detail.getdesc&v=6.0&type=jsonp&dataType=jsonp&callback=jsonp&data=%7B%22id%22%3A%22".$itemid."%22%2C%22type%22%3A%220%22%7D";
		//$url="https://h5api.m.taobao.com/h5/mtop.taobao.detail.getdesc/6.0/?jsv=2.4.16&appKey=12574478&t=1541558873242&sign=823d9b556df4d52017cf5fd943bdfc5d&api=mtop.taobao.detail.getdesc&v=6.0&type=jsonp&dataType=jsonp&callback=mtopjsonp2&data=%7B%22id%22%3A%22537146188479%22%2C%22type%22%3A%221%22%7D";
		$url="https://mdetail.tmall.com/templates/pages/desc?id=".$itemid;	
		$str=curl_request($url);
		$str=mb_convert_encoding($str, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5');
		//echo $str;
		$descurl=Text_qzj($str,'descUrl":"//','"');		
		//echo $descurl."+++++++++";
		$descurl=str_replace(" malformed","",$descurl);
		//echo $descurl."------";
		$descstr=curl_request("http://".$descurl);	
		//echo $descstr;
		//exit;
		preg_match_all('<img[\s\S]*?src="([\s\S]*?)"[\s\S]*?>',$descstr,$descarr);
		//echo "<pre>";
        //print_r($descarr);

		foreach($descarr[1] as $k=>$v){
			//$v=Text_qzj($v,'//','</img>');
			$img.="<img src='".$v."'/>";
			$xcximg[$k]=$v;
			//echo $v."<br>";
		}
 		//echo "<pre>";
 		//print_r($arr);
		//exit;
		

		
		function curl_request($url,$post='',$cookie='', $returnCookie=0){
    //参数1：访问的URL，参数2：post数据(不填则为GET)，参数3：提交的$Cookies,参数4：是否返回$cookies
        $curl = curl_init();//初始化curl会话
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; 	Trident/6.0)');
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
        if($post) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        if($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);//执行curl会话
        if (curl_errno($curl)) {
            return curl_error($curl);
        }
        curl_close($curl);//关闭curl会话
        if($returnCookie){
            list($header, $body) = explode("\r\n\r\n", $data, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
            $info['cookie']  = substr($matches[1][0], 1);
            $info['content'] = $body;
            return $info;
        }else{
            return $data;
        }
    }
    
     function Text_qzj($Text,$Front,$behind) {
    //语法：strpos(string,find,start)
    //函数返回字符串在另一个字符串中第一次出现的位置，如果没有找到该字符串，则返回 false。
    //参数描述：
    //string 必需。规定被搜索的字符串。
    //find   必需。规定要查找的字符。
    //start  可选。规定开始搜索的位置。
    
    //语法：string mb_substr($str,$start,$length,$encoding)
    //参数描述：
    //str      被截取的母字符串。
    //start    开始位置。
    //length   返回的字符串的最大长度,如果省略，则截取到str末尾。
    //encoding 参数为字符编码。如果省略，则使用内部字符编码。
        
        $t1 = mb_strpos(".".$Text,$Front);
        if($t1==FALSE){
            return "";
        }else{
            $t1 = $t1-1+strlen($Front);
        }
        $temp = mb_substr($Text,$t1,strlen($Text)-$t1);
        $t2 = mb_strpos($temp,$behind);
        if($t2==FALSE){
            return "";
        }
        return mb_substr($temp,0,$t2);
    }
	
		die(json_encode(array("error"=>0,'data'=>$img,'xcximg'=>$xcximg)));  
?>