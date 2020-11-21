<?php
header("Content-type:text/html;charset=utf-8");
include_once 'simple_html_dom.php';
class SpiderController extends BaseController{
    public $size = 10;
    public function index() {

        $url = $_POST['url'];
        $start = strpos($url,'offer');
        $end   = strpos($url,'.html');
        $id = substr($url,$start+6,$end-$start-6);
        $url = "http://m.1688.com/offer/$id.html";
        $result = $this->send_http_request($url);
        $html  = str_get_html($result);
        $data['title'] = $html->find('h1 span')[0]->innertext;
        $imagenode = $html->find('.d-swipe .swipe-pane img');
        foreach($imagenode as $image) {
            $name = 'swipe-lazy-src';
            if(!$data['image']) {
                $data['image'] = $image->$name;
            }
            $data['images'][] = '<div class="multi-item">
	<img src="'.$image->$name.'" class="img-responsive img-thumbnail">
	<input type="hidden" name="image[]" value="'.$image->$name.'">
	<em class="close" title="删除这张图片" onclick="deleteMultiImage(this)">×</em>
</div>';
        }
        //content
        preg_match('/detailUrl"\:"(.*?)"/',$result,$match);
        $content = ltrim($this->send_http_request($match[1]),'var offer_details=');
        $content = rtrim($content,';');
        $content = iconv('GB2312','utf-8',$content);
        $data['content'] = json_decode($content, true)['content'];
        $this->ajaxReturn(200,'',$data);
    }


    function send_http_request($url, $post = [])
    {
        $curl = curl_init();

        $ua = 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X; en-us] AppleWebKit/537.51.1 (KHTML, like Gecko] Version/7.0 Mobile/11A465 Safari/9537.53';
        if($post) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }
        curl_setopt ($curl, CURLOPT_REFERER, "http://m.1688.com/offer/1275228798.html");
        curl_setopt($curl, CURLOPT_USERAGENT, $ua);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLINFO_HEADER_OUT, true);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }


}
