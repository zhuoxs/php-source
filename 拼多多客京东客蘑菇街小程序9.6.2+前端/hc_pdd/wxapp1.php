<?php
/**
 * 答题挑战模块小程序接口定义
 *
 * @author huichuang
 * @url http://bbs.we7.cc
 */
defined('IN_IA') or exit('Access Denied');
require_once IA_ROOT."/addons/hc_pdd/inc/model.class.php";
require_once IA_ROOT."/addons/hc_pdd/wxBizDataCrypt.php";
require_once IA_ROOT."/addons/hc_pdd/inc/api.class.php";  
class Hc_pddModuleWxapp extends WeModuleWxapp {
    
    public function doPageTest(){
        ob_end_clean();
        global $_GPC, $_W;
        $post_url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$this->wx_get_token();
        $post_data = '';

        $json = $this->api_notice_increment($post_url,$post_data);
        $json=json_decode($json,true);
        return $this->result(0, '获取成功',$json);
    }
    
    public function getToken(){
        global $_GPC, $_W;
        $account = pdo_get('account_wxapp', array('uniacid' => $_W['uniacid']));
        $appid = $account['key'];
        $appsecret = $account['secret'];
        $file = file_get_contents("../addons/hc_pdd/access_token".$_W['uniacid'].".json",true);
        $result = json_decode($file,true);
        if(time() > $result['expires'] or empty($file)){
            $data = array();
            $data['access_token'] = $this->getNewToken($appid,$appsecret);
            $data['expires']=time()+7000;
            $jsonStr =  json_encode($data);
            $fp = fopen("../addons/hc_pdd/access_token".$_W['uniacid'].".json", "w");
            fwrite($fp, $jsonStr);
            fclose($fp);
            return $data['access_token'];
        }else{
            return $result['access_token'];
        }
    }

    public function getNewToken($appid,$appsecret){
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
        $access_token_Arr = $this->https_request($url);
        return $access_token_Arr['access_token'];
    }

    public function https_request($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $out = curl_exec($ch);
        curl_close($ch);
        return  json_decode($out,true);
    }

    public function get_url_content($url)
    {
        $user_agent = "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0)";
        //$data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        //curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            //'Content-Length: ' . strlen($data_string)
        ));

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function doPageGetopenid()
    {
        ob_end_clean();
        global $_GPC, $_W;
        $code = $_GPC['code'];
        $account = pdo_get('account_wxapp', array('uniacid' => $_GPC['i']));
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $account['key'] . '&secret=' . $account['secret'] . '&js_code=' . $code . '&grant_type=authorization_code';
        $result = $this->get_url_content($url);
        $result = json_decode($result, true);
        return $this->result(0, '获取成功', $result);
    }


    public function doPageZhuce()
    {
        ob_end_clean();
        global $_GPC, $_W;
        $data['uniacid'] = $_GPC['i'];
        $data['city'] = $_POST['city'];
        $data['country'] = $_POST['country'];
        $data['gender'] = $_POST['gender'];
        $data['open_id'] = $_POST['openid'];
        $data['nick_name'] = $_POST['nickname'];
        $data['head_pic'] = $_POST['avatar'];
        $data['province'] = $_POST['province'];
        $stact = 1;
        if(empty($data['open_id'])){
            $this->result(0, $stact, '');
        }
        $uid = pdo_getcolumn('hcpdd_users', array('open_id' => $data['open_id'], 'uniacid' => $data['uniacid']), 'user_id', 1);
        if (empty($uid)){
            $stact = 0;
            $data['fatherid'] = $_POST['activation'];
            $data['pid'] = $this->CreatePid();
            $result = pdo_insert('hcpdd_users', $data, $replace = true);
            $uid = pdo_insertid();
            $this->result(0, $stact,$uid);
        }else{
            $this->result(0, $stact,$uid);
        }        
    }

//红包树注册
    public function doPageTreezhuce()
    {
        ob_end_clean();
        global $_GPC, $_W;

        $data['uniacid'] = $_GPC['i'];
        $data['city'] = $_POST['city'];
        $data['country'] = $_POST['country'];
        $data['gender'] = $_POST['gender'];
        $data['open_id'] = $_POST['openid'];
        $data['nick_name'] = $_POST['nickname'];
        $data['head_pic'] = $_POST['avatar'];
        $data['province'] = $_POST['province'];
        $stact = 1;
        if(empty($data['open_id'])){
            $this->result(0, $stact, '');
        }
        $uid = pdo_getcolumn('hcpdd_users', array('open_id' => $data['open_id'], 'uniacid' => $data['uniacid']), 'user_id', 1);
        if (empty($uid)){
            $stact = 0;
            /*if(!empty($_POST['user_id'])){
                pdo_update('hcpdd_users', array('user_id' => $_POST['getuser_id']));
            }*/
            $data['fatherid'] = $_POST['activation'];
            $data['pid'] = $this->CreatePid();
            $result = pdo_insert('hcpdd_users', $data, $replace = true);
            $uid = pdo_insertid();
            if(!empty($_POST['outuser_id'])){
                $set = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
                $father = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_POST['outuser_id']));
                $son = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$uid));
                $min = $set['min_treemoney']*100;
                $max = $set['max_treemoney']*100;
                $aaa = mt_rand($min,$max);
                $res['uniacid'] = $_GPC['i'];
                $res['user_id'] = $_GPC['outuser_id'];
                $res['hbmoney'] = $aaa/100;
                $res['son_id'] = $uid;
                $res['time'] = time();
                $res['hb_id'] = $_GPC['hb_id'];

                $fnowmoney = $father['treemoney'] + $res['hbmoney'];
                $snowmoney = $son['treemoney'] + $res['hbmoney'];
                pdo_update('hcpdd_users',array('treemoney'=>$fnowmoney), array('user_id' => $_POST['outuser_id']));
                pdo_update('hcpdd_users',array('treemoney'=>$snowmoney), array('user_id' => $uid));

                $pogba = pdo_insert('hcpdd_treelog', $res, $replace = true);
            }
            $arr['data'] = $uid;
            $arr['hbmoney'] = $res['hbmoney'];
            $this->result(0, $stact,$arr);
        }else{
            if(!empty($_POST['outuser_id'])){
                $set = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
                $father = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_POST['outuser_id']));
                $son = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$uid));
                $log = pdo_get('hcpdd_treelog',array('uniacid'=>$_GPC['i'],'son_id'=>$uid));
                if(empty($log) and $uid<>$_POST['outuser_id']){
                    $min = $set['min_treemoney']*100;
                    $max = $set['max_treemoney']*100;
                    $aaa = mt_rand($min,$max);
                    $res['uniacid'] = $_GPC['i'];
                    $res['user_id'] = $_GPC['outuser_id'];
                    $res['hbmoney'] = $aaa/100;
                    $res['son_id'] = $uid;
                    $res['time'] = time();
                    $res['hb_id'] = $_GPC['hb_id'];

                    $fnowmoney = $father['treemoney'] + $res['hbmoney'];
                    $snowmoney = $son['treemoney'] + $res['hbmoney'];
                    pdo_update('hcpdd_users',array('treemoney'=>$fnowmoney), array('user_id' => $_POST['outuser_id']));
                    pdo_update('hcpdd_users',array('treemoney'=>$snowmoney), array('user_id' => $uid));

                    $arr['data'] = $uid;
                    $arr['hbmoney'] = $res['hbmoney'];
                }else{
                    $arr['data'] = $uid;
                    $arr['hbmoney'] = 0;
                }
                $pogba = pdo_insert('hcpdd_treelog', $res, $replace = true);
            }
            
            $result = pdo_update('hcpdd_users', $data, array('user_id' => $uid));
            $this->result(0, $stact,$arr);
        }
        
    }
    //多多进宝商品接口
    public function doPageGoodslist(){

        global $_GPC, $_W;
        $user_id = $_GPC['user_id'];
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));
        $pageNum = $_POST['pageNum'];     //页数
        if(empty($pageNum)){
            $pageNum = 0;
        }
        $category_id = $_POST['cateid'];
        if(empty($category_id)){
            $category_id = '';
        }
        $sort_type = $_POST['rankno'];
        if(empty($sort_type)){
            $sort_type = '0';
        }
        /*$keyword = $_POST['inputValue'];
        if(empty($keyword)){
            $keyword = '';
        }*/
        $keyword = $_POST['inputValue'];
        if(empty($keyword)){
            $keyword = '';
        }else{
        //检查是否搜过
        $lishi = pdo_getall('hcpdd_history', array('user_id'=>$user_id,'uniacid' => $_GPC['i']), array(), '', 'sotime asc');
        foreach ($lishi as $k => $v) {
            $lishi2[] = $v['keyword'];
        }
        if(in_array($keyword, $lishi2)){
            $aaa = 1;//没用
        }else{
            $hhh['user_id'] = $_GPC['user_id'];
            $hhh['keyword'] = $_POST['inputValue'];
            $hhh['sotime']  = time();
            $hhh['uniacid'] = $_GPC['i'];
            $result = pdo_insert('hcpdd_history', $hhh); 
        }
        }

        $page=1+$pageNum;
        $page = max(intval($page), 1);

        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';
        $timestamp = time();
        $type = 'pdd.ddk.goods.search';
        $signold = $client_secret.'cat_id'.$category_id.'client_id'.$client_id.'data_type'.$data_type.'keyword'.$keyword.'page'.$page.'page_size20sort_type'.$sort_type.'timestamp'.$timestamp.'type'.$type.'with_couponfalse'.$client_secret;
        $sign = md5($signold);
        $sign = strtoupper($sign);

        //echo $sign;
        $data = array (
            'type' => urlencode('pdd.ddk.goods.search'),
            'data_type' => 'JSON',
            'timestamp' => urlencode($timestamp),
            'cat_id'=> $category_id,
            'keyword'   => $keyword,
            'client_id' => $client_id,
            'page'      => $page,
            'page_size' => '20',
            'sort_type' => $sort_type,
            'with_coupon' => 'false',
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $list = $arr['goods_search_response']['goods_list'];

        foreach ($list as $k => $v) {
            $list[$k]['min_normal_price'] = $v['min_normal_price'] / 100;//最低单买价
            $list[$k]['min_group_price']  = $v['min_group_price']  / 100;//最低拼团价，原价
            $list[$k]['coupon_discount']  = $v['coupon_discount']  / 100;//优惠券面额
            $list[$k]['now_price']        = ($v['min_group_price'] - $v['coupon_discount'])/100;//现价
            $list[$k]['sold_quantity']    = $v['sales_tip'];   //销量
            if($user['is_daili'] == 2){
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['zongjian_moneyrate']/100000),2);//分享赚佣金
            }elseif($user['is_daili'] == 1){
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['daili_moneyrate']/100000),2);//分享赚佣金
            }else{
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['moneyrate']/100000),2);//分享赚佣金
            }           
            $list[$k]['goods_title']      = "【拼多多】优惠券".$list[$k]['coupon_discount']."元\n原价￥".$list[$k]['min_group_price']." 券后价￥".$list[$k]['now_price'];
        }

        $top = pdo_getcolumn('hcpdd_set',array('uniacid'=>$_GPC['i']),array('top'));
        if(!empty($top)){
            $top = explode(",",$top);
            foreach ($top as $k => $v){
                $toplist[$k] = $this->singlegoods($v,$user_id);
            }
        }
        if(is_array($toplist)){
            foreach ($toplist as $k => $v) {       
                $toplist[$k]['goods_title'] = "【拼多多】优惠券".$toplist[$k]['coupon_discount']."元\n原价￥".$toplist[$k]['min_group_price']." 券后价￥".$toplist[$k]['now_price'];
            }
        }
        if($sort_type == 0){
            $goodtop = pdo_getcolumn('hcpdd_set',array('uniacid'=>$_GPC['i']),array('goodtop'));
            if(!empty($goodtop)){
                $goodtop = explode(",",$goodtop);
                foreach ($goodtop as $k => $v) {
                    $goodtoplist[$k] = $this->singlegoods($v,$user_id);
                }
            } 
        }
        if(is_array($goodtoplist)){
            foreach ($goodtoplist as $k => $v) {                
                $goodtoplist[$k]['goods_title'] = "【拼多多】优惠券".$goodtoplist[$k]['coupon_discount']."元\n原价￥".$goodtoplist[$k]['min_group_price']." 券后价￥".$goodtoplist[$k]['now_price'];
            }
        }
        
                   
        $this->result(0, '优惠券列表',array('banner'=>$banner,'list'=>$list,'nav'=>$nav,'show'=>$show,'toplist'=>$toplist,'goodtoplist'=>$goodtoplist));
  
    }

    //多多进宝商品接口
    public function Goodslist($user_id,$pageNum,$sort_type){

        global $_GPC, $_W;
        //$user_id = $_GPC['user_id'];
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));
        //$pageNum = $_POST['pageNum'];     //页数
        if(empty($pageNum)){
            $pageNum = 0;
        }
        /*$sort_type = $_POST['rankno'];
        if(empty($sort_type)){
            $sort_type = '0';
        }*/
        $page=1+$pageNum;
        $page = max(intval($page), 1);

        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';
        $timestamp = time();
        $type = 'pdd.ddk.goods.search';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'page'.$page.'page_size20sort_type'.$sort_type.'timestamp'.$timestamp.'type'.$type.'with_couponfalse'.$client_secret;
        //推荐置顶商品
        $goodtop = $info['goodtop'];
        if($sort_type == -1){
            if (!empty($goodtop)){
                $goods_id_list = '['.$goodtop.']';
                $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'goods_id_list'.$goods_id_list.'page'.$page.'page_size20sort_type'.$sort_type.'timestamp'.$timestamp.'type'.$type.'with_couponfalse'.$client_secret;
                $sign = md5($signold);
                $sign = strtoupper($sign);
                $data = array (
                    'type' => urlencode('pdd.ddk.goods.search'),
                    'data_type' => 'JSON',
                    'timestamp' => urlencode($timestamp),
                    'client_id' => $client_id,
                    'goods_id_list' => $goods_id_list,
                    'page'      => $page,
                    'page_size' => '20',
                    'sort_type' => $sort_type,
                    'with_coupon' => 'false',
                    'sign' => $sign
                );
                $url = 'http://gw-api.pinduoduo.com/api/router';
                load()->func('communication');
                $response = ihttp_post($url,$data);
                $arr = json_decode($response['content'],true);
                $list = $arr['goods_search_response']['goods_list'];

                foreach ($list as $k => $v) {
                    $list[$k]['min_normal_price'] = $v['min_normal_price'] / 100;//最低单买价
                    $list[$k]['min_group_price']  = $v['min_group_price']  / 100;//最低拼团价，原价
                    $list[$k]['coupon_discount']  = $v['coupon_discount']  / 100;//优惠券面额
                    $list[$k]['now_price']        = ($v['min_group_price'] - $v['coupon_discount'])/100;//现价
                    $list[$k]['sold_quantity']    = $v['sales_tip'];   //销量
                    if($user['is_daili'] == 2){
                        $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['zongjian_moneyrate']/100000),2);//分享赚佣金
                    }elseif($user['is_daili'] == 1){
                        $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['daili_moneyrate']/100000),2);//分享赚佣金
                    }else{
                        $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['moneyrate']/100000),2);//分享赚佣金
                    }
                    $list[$k]['goods_title']      = "【拼多多】优惠券".$list[$k]['coupon_discount']."元\n原价￥".$list[$k]['min_group_price']." 券后价￥".$list[$k]['now_price'];
                }

                return $list;
            }else{
                return [];
            }
        }
        if($sort_type == 4){
            $range_list = '[{"range_id":1,"range_to":990}]'; //9.9包邮
            $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'page'.$page.'page_size20range_list'.$range_list.'sort_type'.$sort_type.'timestamp'.$timestamp.'type'.$type.'with_couponfalse'.$client_secret;
        }
        if($sort_type == 28){
            $range_list = '[{"range_id":5,"range_from":1000,"range_to":10000}]'; //热卖
            $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'page'.$page.'page_size20range_list'.$range_list.'sort_type'.$sort_type.'timestamp'.$timestamp.'type'.$type.'with_couponfalse'.$client_secret;
        }

        $sign = md5($signold);
        $sign = strtoupper($sign);

        //echo $sign;
        $data = array (
            'type' => urlencode('pdd.ddk.goods.search'),
            'data_type' => 'JSON',
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'page'      => $page,
            'page_size' => '20',
            'sort_type' => $sort_type,
            'with_coupon' => 'false',
            'sign' => $sign
        );
        if($sort_type == 4 or $sort_type == 28){
            $data = array (
            'type' => urlencode('pdd.ddk.goods.search'),
            'data_type' => 'JSON',
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'range_list'=> $range_list,
            'page'      => $page,
            'page_size' => '20',
            'sort_type' => $sort_type,
            'with_coupon' => 'false',
            'sign' => $sign
            );
        }
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $list = $arr['goods_search_response']['goods_list'];

        foreach ($list as $k => $v) {
            $list[$k]['min_normal_price'] = $v['min_normal_price'] / 100;//最低单买价
            $list[$k]['min_group_price']  = $v['min_group_price']  / 100;//最低拼团价，原价
            $list[$k]['coupon_discount']  = $v['coupon_discount']  / 100;//优惠券面额
            $list[$k]['now_price']        = ($v['min_group_price'] - $v['coupon_discount'])/100;//现价
            $list[$k]['sold_quantity']    = $v['sales_tip'];   //销量
            if($user['is_daili'] == 2){
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['zongjian_moneyrate']/100000),2);//分享赚佣金
            }elseif($user['is_daili'] == 1){
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['daili_moneyrate']/100000),2);//分享赚佣金
            }else{
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['moneyrate']/100000),2);//分享赚佣金
            }           
            $list[$k]['goods_title']      = "【拼多多】优惠券".$list[$k]['coupon_discount']."元\n原价￥".$list[$k]['min_group_price']." 券后价￥".$list[$k]['now_price'];
        }
                
        return $list;
  
    }
    //推荐列表
    public function doPageTuijianlist(){
        
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id'])); 
        $pageNum = $_POST['pageNum'];     //页数
        $toplist = pdo_getall('hcpdd_tuijian', array('uniacid' => $_GPC['i']), array(), '', 'displayorder asc');
        foreach ($toplist as $k => $v) {
            $toplist[$k]['toppic'] = tomedia($v['toppic']);
            $color[$k] = $v['titlecolor'];
        }
        $aaa = $toplist[$_GPC['jump']];
        $_GPC['jump'] = $aaa['jump'];
        $topgoodslist = [];
        if($_GPC['jump'] == 0){
            $goodslist = $this->Goodslist($_GPC['user_id'],$pageNum,'0');
            $topgoodslist = $this->Goodslist($_GPC['user_id'],$pageNum,'-1');
        }elseif($_GPC['jump'] == 2){
            $goodslist = $this->Goodslist($_GPC['user_id'],$pageNum,'6');
        }elseif($_GPC['jump'] == 3){
            $goodslist = $this->Goodslist($_GPC['user_id'],$pageNum,'2');
        }elseif($_GPC['jump'] == 4){
            $goodslist = $this->Goodslist($_GPC['user_id'],$pageNum,'4');
        }elseif($_GPC['jump'] == 5){
            $goodslist = $this->Goodslist($_GPC['user_id'],$pageNum,'16');
        }elseif($_GPC['jump'] == 6){
            $goodslist = $this->Goodslist($_GPC['user_id'],$pageNum,'28');
        }elseif($_GPC['jump'] == 1){
            if(empty($pageNum)){
                $pageNum = 0;
            }
            $page=1+$pageNum;
            $page = max(intval($page), 1);
            $model = new moguapiModel();
            $access_token = $info['access_token'];
            $app_key = $info['app_key'];
            $AppSecret = $info['app_secret'];
            //$promInfoQuery = '{"hasCoupon":true,"pageSize":20}';
            $promInfoQuery = json_encode(array('hasCoupon'=>'true','pageSize'=>20,'pageNo'=>$page,'sortType'=>0));
            
            $goodslist = $model->moguapi_goodslist($access_token,$app_key,$AppSecret,$promInfoQuery);
            foreach ($goodslist as $k => $v) {
                $goodslist[$k]['goods_name'] = $v['title'];
                $goodslist[$k]['goods_thumbnail_url'] = $v['pictUrlForH5'];
                $goodslist[$k]['min_group_price']  = $v['zkPrice'];   //原价
                $goodslist[$k]['coupon_discount']  = $v['couponAmount'];//优惠券面额
                $goodslist[$k]['now_price']        = $v['afterCouponPrice'];   //现价
                $goodslist[$k]['sold_quantity']        = $v['biz30day'];   //销量
                //$list[$k]['commission']   = round(($v['afterCouponPrice']*$v['commissionRate']/100),2);//
                if($user['is_daili'] == 0){
                    $goodslist[$k]['commission']   = round(($v['afterCouponPrice']*$v['commissionRate']*$info['mogurate']/100),2);//
                }elseif($user['is_daili'] == 1){
                    $goodslist[$k]['commission']   = round(($v['afterCouponPrice']*$v['commissionRate']*$info['mogudailirate']/100),2);//
                }else{
                    $goodslist[$k]['commission']   = round(($v['afterCouponPrice']*$v['commissionRate']*$info['moguzongjianrate']/100),2);//
                } 
                $goodslist[$k]['goods_title']      = "【蘑菇街】优惠券".$list[$k]['coupon_discount']."元\n原价￥".$list[$k]['min_group_price']." 券后价￥".$list[$k]['now_price'];
            }
        }elseif($_GPC['jump'] == 7){
            $pageNum = $_POST['pageNum'];     //页数
            if(empty($pageNum)){
                $pageNum = 0;
            }
            $page=1+$pageNum;
            $page = max(intval($page), 1);
            $model = new moguapiModel();
            //$app_key = $info['jdappkey'];
            //$AppSecret = $info['jdsecretkey'];
            $param_json = json_encode(
                array(
                    'goodsReqDTO'=>
                    array(
                          'pageSize' => 20,
                          'pageIndex' => 1,
                          'isCoupon' =>1,
                          'pageIndex' =>$page
                          )
                    )
                );            
            $goodslist = $model->jdapi_goodslist($param_json);
            if(empty($goodslist)){
               $goodslist = $model->jdapi_goodslist2($param_json);
            }
            if(empty($goodslist)){
               $goodslist = $model->jdapi_goodslist3($param_json);
            }
            if(empty($goodslist)){
               $goodslist = $model->jdapi_goodslist5($param_json);
            }
            if(empty($goodslist)){
               $goodslist = $model->jdapi_goodslist6($param_json);
            }
            if(empty($goodslist)){
               $goodslist = $model->jdapi_goodslist7($param_json);
            }
            if(empty($goodslist)){
               $goodslist = $model->jdapi_goodslist8($param_json);
            }
            if(empty($goodslist)){
               $goodslist = $model->jdapi_goodslist9($param_json);
            }
            if(empty($goodslist)){
               $goodslist = $model->jdapi_goodslist10($param_json);
            }
            foreach ($goodslist as $k => $v) {
                $goodslist[$k]['goods_name'] = $v['skuName'];
                $goodslist[$k]['goods_thumbnail_url'] = $v['imageInfo']['imageList'][0]['url'];
                if($v['pinGouInfo']['pingouPrice']){
                    $goodslist[$k]['min_group_price']  = $v['pinGouInfo']['pingouPrice'];   //原价
                }else{
                    $goodslist[$k]['min_group_price']  = $v['priceInfo']['price'];   //原价
                }          
                
                if($v['couponInfo']['couponList'][0]['discount'] >= $goodslist[$k]['min_group_price']){
                    $goodslist[$k]['now_price'] = $goodslist[$k]['min_group_price'];//现价
                    $goodslist[$k]['coupon_discount']  = 0;//优惠券面额
                }else{
                    $goodslist[$k]['coupon_discount']  = $v['couponInfo']['couponList'][0]['discount'];//优惠券面额
                    $goodslist[$k]['now_price'] = $goodslist[$k]['min_group_price'] - $v['couponInfo']['couponList'][0]['discount'];//现价
                }           
                $goodslist[$k]['sold_quantity']        = $v['inOrderCount30Days'];   //销量
                //$list[$k]['commission']   = round(($v['afterCouponPrice']*$v['commissionRate']/100),2);//
                if($user['is_daili'] == 0){
                    $goodslist[$k]['commission']   = round(($goodslist[$k]['now_price']*$v['commissionInfo']['commissionShare']*$info['jdrate']*0.9/100),2);//
                }elseif($user['is_daili'] == 1){
                    $goodslist[$k]['commission']   = round(($goodslist[$k]['now_price']*$v['commissionInfo']['commissionShare']*$info['jddailirate']*0.9/100),2);//
                }else{
                    $goodslist[$k]['commission']   = round(($goodslist[$k]['now_price']*$v['commissionInfo']['commissionShare']*$info['jdzongjianrate']*0.9/100),2);//
                } 
                $goodslist[$k]['goods_title']      = "【京东】优惠券".$goodslist[$k]['coupon_discount']."元\n原价￥".$goodslist[$k]['min_group_price']." 券后价￥".$goodslist[$k]['now_price'];
            }

        }


        $this->result(0, '列表',array('toplist'=>$toplist,'goodslist'=>$goodslist,'topgoodslist'=>$topgoodslist,'color'=>$color));
        
    }


    //蘑菇街商品列表
    public function doPageMogugoodslist(){
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id'])); 
        $pageNum = $_POST['pageNum'];     //页数
        if(empty($pageNum)){
            $pageNum = 0;
        }

        if($_GPC['rankno'] == 1){
            $sortType = 11;
        }
        elseif($_GPC['rankno'] == 2){
            $sortType = 12;
        }
        elseif($_GPC['rankno'] == 3){
            $sortType = 21;
        }
        elseif($_GPC['rankno'] == 4){
            $sortType = 22;
        }
        elseif($_GPC['rankno'] == 5){
            $sortType = 0;
        }
        elseif($_GPC['rankno'] == 6){
            $sortType = 32;
        }else{
            $sortType = 0;
        }

        $page=1+$pageNum;
        $page = max(intval($page), 1);

        $model = new moguapiModel();
        $access_token = $info['access_token'];
        $app_key = $info['app_key'];
        $AppSecret = $info['app_secret'];
        //$promInfoQuery = '{"hasCoupon":true,"pageSize":20}';
        $promInfoQuery = json_encode(array('hasCoupon'=>'true','pageSize'=>20,'pageNo'=>$page,'sortType'=>$sortType,'keyword'=>$_GPC['inputValue']));
        
        $list = $model->moguapi_goodslist($access_token,$app_key,$AppSecret,$promInfoQuery);
        foreach ($list as $k => $v) {
            $list[$k]['goods_name'] = $v['title'];
            $list[$k]['goods_thumbnail_url'] = $v['pictUrlForH5'];
            $list[$k]['min_group_price']  = $v['zkPrice'];   //原价
            $list[$k]['coupon_discount']  = $v['couponAmount'];//优惠券面额
            $list[$k]['now_price']        = $v['afterCouponPrice'];   //现价
            $list[$k]['sold_quantity']        = $v['biz30day'];   //销量
            //$list[$k]['commission']   = round(($v['afterCouponPrice']*$v['commissionRate']/100),2);//
            if($user['is_daili'] == 0){
                $list[$k]['commission']   = round(($v['afterCouponPrice']*$v['commissionRate']*$info['mogurate']/100),2);//
            }elseif($user['is_daili'] == 1){
                $list[$k]['commission']   = round(($v['afterCouponPrice']*$v['commissionRate']*$info['mogudailirate']/100),2);//
            }else{
                $list[$k]['commission']   = round(($v['afterCouponPrice']*$v['commissionRate']*$info['moguzongjianrate']/100),2);//
            } 
            $list[$k]['goods_title']      = "【蘑菇街】优惠券".$list[$k]['coupon_discount']."元\n原价￥".$list[$k]['min_group_price']." 券后价￥".$list[$k]['now_price'];
        }

        $this->result(0, '蘑菇街优惠券列表',array('list'=>$list));

    }

    //京东客商品列表
    public function doPageJdgoodslist(){
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id'])); 
        $pageNum = $_POST['pageNum'];     //页数
        if(empty($pageNum)){
            $pageNum = 0;
        }

        if($_GPC['rankno'] == 1){                  //佣金比例升序
            $sortName = 'commissionShare';
            $sort = 'asc';
        }
        elseif($_GPC['rankno'] == 2){              //降序
            $sortName = 'commissionShare';
            $sort = 'desc';
        }
        elseif($_GPC['rankno'] == 3){              //价格升序
            $sortName = 'price'; 
            $sort = 'asc';
        }
        elseif($_GPC['rankno'] == 4){              //降序
            $sortName = 'price';
            $sort = 'desc';
        }
        elseif($_GPC['rankno'] == 5){              //销量升序
            $sortName = 'inOrderCount30Days';
            $sort = 'asc';
        }
        elseif($_GPC['rankno'] == 6){              //销量降序
            $sortName = 'inOrderCount30Days';
            $sort = 'desc';
        }else{
            $sortName = '';
            $sort = '';
        }

        $page=1+$pageNum;
        $page = max(intval($page), 1);

        $model = new moguapiModel();
        //$app_key = $info['jdappkey'];
        //$AppSecret = $info['jdsecretkey'];
        if(!empty($_GPC['inputValue'])){
            $keyword = $_GPC['inputValue'];
        }else{
            $keyword = '';
        }
        $param_json = json_encode(
            array(
                'goodsReqDTO'=>
                array(
                      'pageSize' => 20,
                      'pageIndex' => 1,
                      'isCoupon' =>1,
                      'pageIndex' =>$page,
                      'sort' => $sort,
                      'sortName' => $sortName,
                      'keyword' => $keyword
                      )
                )
            );
        
        $list = $model->jdapi_goodslist($param_json);
        if(empty($list)){
            $list = $model->jdapi_goodslist2($param_json);
        }
        if(empty($list)){
            $list = $model->jdapi_goodslist3($param_json);
        }
        if(empty($list)){
            $list = $model->jdapi_goodslist5($param_json);
        }
        if(empty($list)){
            $list = $model->jdapi_goodslist6($param_json);
        }
        if(empty($list)){
            $list = $model->jdapi_goodslist7($param_json);
        }
        if(empty($list)){
            $list = $model->jdapi_goodslist8($param_json);
        }
        if(empty($list)){
            $list = $model->jdapi_goodslist9($param_json);
        }
        if(empty($list)){
            $list = $model->jdapi_goodslist10($param_json);
        }
        foreach ($list as $k => $v) {
            $list[$k]['goods_name'] = $v['skuName'];
            $list[$k]['goods_thumbnail_url'] = $v['imageInfo']['imageList'][0]['url'];
            if($v['pinGouInfo']['pingouPrice']){
                $list[$k]['min_group_price']  = $v['pinGouInfo']['pingouPrice'];   //原价
            }else{
                $list[$k]['min_group_price']  = $v['priceInfo']['price'];   //原价
            }          
            
            if($v['couponInfo']['couponList'][0]['discount'] >= $list[$k]['min_group_price']){
                $list[$k]['now_price'] = $list[$k]['min_group_price'];//现价
                $list[$k]['coupon_discount']  = 0;//优惠券面额
            }else{
                $list[$k]['coupon_discount']  = $v['couponInfo']['couponList'][0]['discount'];//优惠券面额
                $list[$k]['now_price'] = $list[$k]['min_group_price'] - $v['couponInfo']['couponList'][0]['discount'];//现价
            }           
            $list[$k]['sold_quantity']        = $v['inOrderCount30Days'];   //销量
            //$list[$k]['commission']   = round(($v['afterCouponPrice']*$v['commissionRate']/100),2);//
            if($user['is_daili'] == 0){
                $list[$k]['commission']   = round(($list[$k]['now_price']*$v['commissionInfo']['commissionShare']*$info['jdrate']*0.9/100),2);//
            }elseif($user['is_daili'] == 1){
                $list[$k]['commission']   = round(($list[$k]['now_price']*$v['commissionInfo']['commissionShare']*$info['jddailirate']*0.9/100),2);//
            }else{
                $list[$k]['commission']   = round(($list[$k]['now_price']*$v['commissionInfo']['commissionShare']*$info['jdzongjianrate']*0.9/100),2);//
            } 
            $list[$k]['goods_title']      = "【京东】优惠券".$list[$k]['coupon_discount']."元\n原价￥".$list[$k]['min_group_price']." 券后价￥".$list[$k]['now_price'];
        }

        $this->result(0, '京东优惠券列表',array('list'=>$list));

    }

    //爆款推荐
    public function doPageBaokuanlist(){
        
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id'])); 
        $pageNum = $_POST['pageNum'];     //页数
        $goodslist = $this->Goodslist($_GPC['user_id'],$pageNum,'6');

        $this->result(0, '列表',array('goodslist'=>$goodslist));
        
    }

    //主题推荐列表
    public function doPageTheme(){

        global $_GPC, $_W;
        $sort_type = '0';
        $user_id = $_GPC['user_id'];
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $yesno = pdo_get('hcpdd_theme',array('uniacid'=>$_GPC['i']));
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';
        $timestamp = time();
        $goods_id_list = trim($yesno['goods']);
        $type = 'pdd.ddk.goods.search';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'goods_id_list['.$goods_id_list.']page_size100sort_type0timestamp'.$timestamp.'type'.$type.'with_couponfalse'.$client_secret;
        $sign = md5($signold);
        $sign = strtoupper($sign);
        $data = array (
            'type' => urlencode('pdd.ddk.goods.search'),
            'data_type' => 'JSON',
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'page_size' => '100',
            'sort_type' => $sort_type,
            'goods_id_list' => '['.$goods_id_list.']',
            'with_coupon' => 'false',
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $list = $arr['goods_search_response']['goods_list'];
        /*foreach ($arr as $k => $v) {
                $list = $v['goods_list'];
        }*/
        foreach ($list as $k => $v) {
            $list[$k]['min_normal_price'] = $v['min_normal_price'] / 100;//最低单买价
            $list[$k]['min_group_price']  = $v['min_group_price']  / 100;//最低拼团价，原价
            $list[$k]['coupon_discount']  = $v['coupon_discount']  / 100;//优惠券面额
            $list[$k]['now_price']        = ($v['min_group_price'] - $v['coupon_discount'])/100;//现价
            $list[$k]['sold_quantity']    = $v['sales_tip'];   //销量
            if($user['is_daili'] == 2){
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['zongjian_moneyrate']/100000),2);//分享赚佣金
            }elseif($user['is_daili'] == 1){
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['daili_moneyrate']/100000),2);//分享赚佣金
            }else{
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['moneyrate']/100000),2);//分享赚佣金
            }
        }
        //首页是否显示主题活动        
        $yesno['banner'] = $_W['attachurl'].$yesno['banner'];
        $yesno['mainpic'] = $_W['attachurl'].$yesno['mainpic']; 
        
        
        $this->result(0, '优惠券列表',array('list'=>$list,'yesno'=>$yesno));
  
    }

    //查询单个商品
    public function singlegoods($goods_id,$user_id){

        global $_GPC, $_W;
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$user_id));
        $sort_type = '0';
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';
        $timestamp = time();
        $goods_id_list = $goods_id;
        $type = 'pdd.ddk.goods.search';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'goods_id_list['.$goods_id_list.']page_size100sort_type0timestamp'.$timestamp.'type'.$type.'with_couponfalse'.$client_secret;
        $sign = md5($signold);
        $sign = strtoupper($sign);
        $data = array (
            'type' => urlencode('pdd.ddk.goods.search'),
            'data_type' => 'JSON',
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'page_size' => '100',
            'sort_type' => $sort_type,
            'goods_id_list' => '['.$goods_id_list.']',
            'with_coupon' => 'false',
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $list = $arr['goods_search_response']['goods_list'];
        foreach ($list as $k => $v) {
            $list[$k]['min_normal_price'] = $v['min_normal_price'] / 100;//最低单买价
            $list[$k]['min_group_price']  = $v['min_group_price']  / 100;//最低拼团价，原价
            $list[$k]['coupon_discount']  = $v['coupon_discount']  / 100;//优惠券面额
            $list[$k]['now_price']        = ($v['min_group_price'] - $v['coupon_discount'])/100;//现价
            $list[$k]['sold_quantity']    = $v['sales_tip'];   //销量
            if($user['is_daili'] == 2){
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['zongjian_moneyrate']/100000),2);//分享赚佣金
            }elseif($user['is_daili'] == 1){
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['daili_moneyrate']/100000),2);//分享赚佣金
            }else{
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['moneyrate']/100000),2);//分享赚佣金
            }
        }
        
        return $list[0];
  
    }

    //主题商品列表
    public function doPageThemedetail(){

        global $_GPC, $_W;
        $user_id = $_GPC['user_id'];
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';
        $timestamp = time();
        $img = $_GPC['img'];
        $tname = $_GPC['tname'];
        $theme_id = $_GPC['theme_id'];
        $type = 'pdd.ddk.theme.goods.search';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'theme_id'.$theme_id.'timestamp'.$timestamp.'type'.$type.$client_secret;
        $sign = md5($signold);
        $sign = strtoupper($sign);
        $data = array (
            'type' => urlencode('pdd.ddk.theme.goods.search'),
            'data_type' => 'JSON',
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'theme_id' => $theme_id,
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $list = $arr['theme_list_get_response']['goods_list'];
        /*foreach ($arr as $k => $v) {
                $list = $v['goods_list'];
        }*/
        foreach ($list as $k => $v) {
            $list[$k]['min_normal_price'] = $v['min_normal_price'] / 100;//最低单买价
            $list[$k]['min_group_price']  = $v['min_group_price']  / 100;//最低拼团价，原价
            $list[$k]['coupon_discount']  = $v['coupon_discount']  / 100;//优惠券面额
            $list[$k]['now_price']        = ($v['min_group_price'] - $v['coupon_discount'])/100;//现价
            if($user['is_daili'] == 2){
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['zongjian_moneyrate']/100000),2);//分享赚佣金
            }elseif($user['is_daili'] == 1){
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['daili_moneyrate']/100000),2);//分享赚佣金
            }else{
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['moneyrate']/100000),2);//分享赚佣金
            }
        }
      
        
        
        $this->result(0, '主题商品列表',array('list'=>$list,'img'=>$img,'tname'=>$tname));
  
    }

    //官方主题列表
    public function doPageThemelist(){

        global $_GPC, $_W;
        $user_id = $_GPC['user_id'];
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $pageNum = $_POST['pageNum'];     //页数
        if(empty($pageNum)){
            $pageNum = 0;
        }
        $page=1+$pageNum;
        $page = max(intval($page), 1);
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';
        $timestamp = time();
        $type = 'pdd.ddk.theme.list.get';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'page'.$page.'page_size10timestamp'.$timestamp.'type'.$type.$client_secret;
        $sign = md5($signold);
        $sign = strtoupper($sign);
        $data = array (
            'type' => urlencode('pdd.ddk.theme.list.get'),
            'data_type' => 'JSON',
            'timestamp' => urlencode($timestamp),
            'page'      => $page,
            'page_size' => '10',
            'client_id' => $client_id,
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $list = $arr['theme_list_get_response']['theme_list'];
       
        $this->result(0, '主题列表',$list);
  
    }
    //搜索接口
    public function doPageSoso(){

        global $_GPC, $_W;
        $user_id = $_GPC['user_id'];
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));
        $pageNum = $_POST['pageNum'];     //页数
        if(empty($pageNum)){
            $pageNum = 0;
        }
        $sort_type = $_POST['rankno'];
        if(empty($sort_type)){
            $sort_type = '0';
        }
        $keyword = $_POST['inputValue'];
        if($keyword == 'undefined' ){
            $list['res'] = '关键词为空';
            $this->result(1, '关键词为空',array('list'=>$list));
        }else{
        //检查是否搜过
        $lishi = pdo_getall('hcpdd_history', array('user_id'=>$user_id,'uniacid' => $_GPC['i']), array(), '', 'sotime asc');
        foreach ($lishi as $k => $v) {
            $lishi2[] = $v['keyword'];
        }
        if(in_array($keyword, $lishi2)){
            $aaa = 1;//没用
        }else{
            $hhh['user_id'] = $_GPC['user_id'];
            $hhh['keyword'] = $_POST['inputValue'];
            $hhh['sotime']  = time();
            $hhh['uniacid'] = $_GPC['i'];
            $result = pdo_insert('hcpdd_history', $hhh); 
        }

        $page=1+$pageNum;
        $page = max(intval($page), 1);

        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';
        $timestamp = time();
        $type = 'pdd.ddk.goods.search';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'keyword'.$keyword.'page'.$page.'page_size20sort_type'.$sort_type.'timestamp'.$timestamp.'type'.$type.'with_couponfalse'.$client_secret;
        $sign = md5($signold);
        $sign = strtoupper($sign);

        //echo $sign;
        $data = array (
            'type' => urlencode('pdd.ddk.goods.search'),
            'data_type' => 'JSON',
            'timestamp' => urlencode($timestamp),
            'keyword'   => $keyword,
            'client_id' => $client_id,
            'page'      => $page,
            'page_size' => '20',
            'sort_type' => $sort_type,
            'with_coupon' => 'false',
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $list = $arr['goods_search_response']['goods_list'];
        /*foreach ($arr as $k => $v) {
                $list = $v['goods_list'];
        }*/
        foreach ($list as $k => $v) {
            $list[$k]['min_normal_price'] = $v['min_normal_price'] / 100;//最低单买价
            $list[$k]['min_group_price']  = $v['min_group_price']  / 100;//最低拼团价，原价
            $list[$k]['coupon_discount']  = $v['coupon_discount']  / 100;//优惠券面额
            $list[$k]['now_price']        = ($v['min_group_price'] - $v['coupon_discount'])/100;//现价
            $list[$k]['sold_quantity']    = $v['sales_tip'];   //销量
            if($user['is_daili'] == 2){
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['zongjian_moneyrate']/100000),2);//分享赚佣金
            }elseif($user['is_daili'] == 1){
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['daili_moneyrate']/100000),2);//分享赚佣金
            }else{
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['moneyrate']/100000),2);//分享赚佣金
            }
            $list[$k]['goods_title']      = "【拼多多】优惠券".$list[$k]['coupon_discount']."元\n原价￥".$list[$k]['min_group_price']." 券后价￥".$list[$k]['now_price'];
        }
        
        
        $this->result(0, '搜索列表',array('list'=>$list));
        }
  
    }
    public function doPageHistory(){
        global $_GPC, $_W;
        $del = $_GPC['del'];
        if($del == 1){
           pdo_delete('hcpdd_history', array('user_id'=>$_GPC['user_id'],'uniacid'=>$_GPC['i'])); 
        }
        $user_id = $_GPC['user_id'];
        $lishi = pdo_getall('hcpdd_history', array('user_id'=>$user_id,'uniacid' => $_GPC['i']), array(), '', 'sotime DESC');
        foreach ($lishi as $k => $v) {
            $list[] = $v['keyword'];
        }
        $this->result(0, '搜索历史',$list);

    }
    //展示位列表
    public function doPageShowlist(){

        global $_GPC, $_W;
        $user_id = $_GPC['user_id'];
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));
        $pageNum = $_POST['pageNum'];     //页数
        if(empty($pageNum)){
            $pageNum = 0;
        }
        $sort_type = $_POST['rankno'];
        if(empty($sort_type)){
            $sort_type = '0';
        }
        $screenid = $_POST['screen_id'];
        if($screenid == 1){
            $range_list = '[{"range_id":5,"range_from":1000,"range_to":10000}]';//今日推荐
        }
        if($screenid == 2){
            $range_list = '[{"range_id":5,"range_from":10000,"range_to":999999}]'; //热卖
        }
        if($screenid == 3){
            $range_list = '[{"range_id":1,"range_to":990}]'; //9.9包邮
        }
        if($screenid == 4){
            $range_list = '[{"range_id":3,"range_from":1000,"range_to":999999}]'; //大额券
        }
        if($screenid == 5){
            $range_list = '[{"range_id":6,"range_from":1000,"range_to":999999}]';  //高佣金
        }
        
        $page = 1 + $pageNum;
        $page = max(intval($page),1);

        //$range_list = '[{"range_id":1,"range_to":990}]'; //9.9包邮
        //$range_list = '[{"range_id":5,"range_from":10000,"range_to":999999}]'; //热卖
        //$range_list = '[{"range_id":3,"range_from":1000,"range_to":999999}]'; //大额券
        //$range_list = '[{"range_id":6,"range_from":1000,"range_to":999999}]';  //高佣金
        //$range_list = '[{"range_id":5,"range_from":1000,"range_to":10000}]';//今日推荐


        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';
        $timestamp = time();
        $type = 'pdd.ddk.goods.search';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'page'.$page.'page_size20range_list'.$range_list.'sort_type'.$sort_type.'timestamp'.$timestamp.'type'.$type.'with_couponfalse'.$client_secret;
        $sign = md5($signold);
        $sign = strtoupper($sign);

        //echo $sign;
        $data = array (
            'type' => urlencode('pdd.ddk.goods.search'),
            'data_type' => 'JSON',
            'timestamp' => urlencode($timestamp),
            'range_list'=> $range_list,
            'client_id' => $client_id,
            'page'      => $page,
            'page_size' => '20',
            'sort_type' => $sort_type,
            'with_coupon' => 'false',
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $list = $arr['goods_search_response']['goods_list'];
        /*foreach ($arr as $k => $v) {
                $list = $v['goods_list'];
        }*/
        foreach ($list as $k => $v) {
            $list[$k]['min_normal_price'] = $v['min_normal_price'] / 100;//最低单买价
            $list[$k]['min_group_price']  = $v['min_group_price']  / 100;//最低拼团价，原价
            $list[$k]['coupon_discount']  = $v['coupon_discount']  / 100;//优惠券面额
            $list[$k]['now_price']        = ($v['min_group_price'] - $v['coupon_discount'])/100;//现价
            $list[$k]['sold_quantity']    = $v['sales_tip'];   //销量
            if($user['is_daili'] == 2){
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['zongjian_moneyrate']/100000),2);//分享赚佣金
            }elseif($user['is_daili'] == 1){
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['daili_moneyrate']/100000),2);//分享赚佣金
            }else{
                $list[$k]['commission']   = round((($v['min_group_price'] - $v['coupon_discount']) * $v['promotion_rate']*$info['moneyrate']/100000),2);//分享赚佣金
            }
            $list[$k]['goods_title']      = "【拼多多】优惠券".$list[$k]['coupon_discount']."元\n原价￥".$list[$k]['min_group_price']." 券后价￥".$list[$k]['now_price'];
        }
        
        $this->result(0, '展示位列表',array('list'=>$list));
        
  
    }
    /***
    //
    //商品详情接口
    //
    **/
    public function doPageGoodsdetail(){
        
        global $_W,$_GPC;  
        $user_id = $_GPC['user_id'];
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        //pdd
        if($_GPC['parameter'] == 0){
            $goods_id_list=$_POST['goods_id_list'];         
            $client_secret = $info['client_secret'];
            $client_id = $info['client_id'];
            $data_type = 'JSON';
            $timestamp = time();
            $type = 'pdd.ddk.goods.detail';
            $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'goods_id_list['.$goods_id_list.']timestamp'.$timestamp.'type'.$type.$client_secret;
            $sign = md5($signold);
            $sign = strtoupper($sign);
            $data = array (
                'type' => urlencode('pdd.ddk.goods.detail'),
                'data_type' => 'JSON',
                'goods_id_list' => '['.$goods_id_list.']',
                'timestamp' => urlencode($timestamp),
                'client_id' => $client_id,
                'sign' => $sign
            );
            $url = 'http://gw-api.pinduoduo.com/api/router';
            load()->func('communication');
            $response = ihttp_post($url,$data);
            $arr = json_decode($response['content'],true);
            $result = $arr['goods_detail_response']['goods_details'][0];
            $result['min_normal_price'] = $result['min_normal_price'] / 100;//最低单买价
            $result['min_group_price']  = $result['min_group_price']  / 100;//最低拼团价，原价
            $result['coupon_discount']  = $result['coupon_discount']  / 100;//优惠券面额
            $result['now_price']        = round(($result['min_group_price'] - $result['coupon_discount']),2);//现价
            $result['sold_quantity']    = $result['sales_tip']; 
            if($user['is_daili'] == 2){
                $result['commission']       = round((($result['min_group_price'] - $result['coupon_discount']) * $result['promotion_rate']/1000*$info['zongjian_moneyrate']),2);//分享赚佣金
            }elseif($user['is_daili'] == 1){
                $result['commission']       = round((($result['min_group_price'] - $result['coupon_discount']) * $result['promotion_rate']/1000*$info['daili_moneyrate']),2);//分享赚佣金
            }else{
                $result['commission']       = round((($result['min_group_price'] - $result['coupon_discount']) * $result['promotion_rate']/1000*$info['moneyrate']),2);//分享赚佣金
            }
            
            $result['coupon_start_time']= date('Y-m-d',$result['coupon_start_time']); //开始时间
            $result['coupon_end_time']  = date('Y-m-d',$result['coupon_end_time']); //结束时间
            $result['goods_title'] = "【拼多多】优惠券".$result['coupon_discount']."元\n原价￥".$result['min_group_price']." 券后价￥".$result['now_price'];
            $this->result(0, '商品详情',$result);
        }
        //mogu
        if($_GPC['parameter'] == 1){
            $model = new moguapiModel();
            $access_token = $info['access_token'];
            $app_key = $info['app_key'];
            $AppSecret = $info['app_secret'];
            $url = $_GPC['itemUrl'];
            
            $result = $model->moguapi_goodsdetail($access_token,$app_key,$AppSecret,$url);

            $result['goods_name']  = $result['title'];
            $result['goods_desc']  = $result['extendDesc'];
            $result['coupon_total_quantity']  = $result['couponTotalCount'];//优惠券总量
            $result['coupon_remain_quantity']  = $result['couponLeftCount'];//优惠券余量
            $result['goods_gallery_urls'] = array('0' =>$result['pictUrl']);
            $result['goods_thumbnail_url'] = $result['pictUrl'];
            $result['min_group_price']  = $result['zkPrice'];//最低拼团价，原价
            $result['coupon_discount']  = $result['couponAmount'];//优惠券面额
            $result['now_price']        = $result['afterCouponPrice'];//现价
            $result['sold_quantity']    = $result['biz30day'];//销量
            if($user['is_daili'] == 0){
                $result['commission']   = round(($result['afterCouponPrice']*$result['commissionRate']*$info['mogurate']/100),2);//
            }elseif($user['is_daili'] == 1){
                $result['commission']   = round(($result['afterCouponPrice']*$result['commissionRate']*$info['mogudailirate']/100),2);//
            }else{
                $result['commission']   = round(($result['afterCouponPrice']*$result['commissionRate']*$info['moguzongjianrate']/100),2);//
            }
            
            $result['coupon_start_time']= date('Y-m-d',$result['coupon_start_time']); //开始时间
            $result['coupon_end_time']  = date('Y-m-d',$result['coupon_end_time']); //结束时间
            $result['goods_title'] = "【蘑菇街】优惠券".$result['coupon_discount']."元\n原价￥".$result['min_group_price']." 券后价￥".$result['now_price'];

            $this->result(0, '商品详情',$result); 
        }
        //JD
        if($_GPC['parameter'] == 2){
            $model = new moguapiModel();
            //$app_key = $info['jdappkey'];
            //$AppSecret = $info['jdsecretkey'];
            $param_json = json_encode(
                array(
                    'goodsReqDTO'=>
                    array(
                          'skuIds' => array($_GPC['skuId'])
                          )
                    )
                );
            
            $aaa = $model->jdapi_goodslist($param_json);
            if(empty($aaa)){
                $aaa = $model->jdapi_goodslist2($param_json);
            }
            if(empty($aaa)){
                $aaa = $model->jdapi_goodslist3($param_json);
            }
            if(empty($aaa)){
                $aaa = $model->jdapi_goodslist5($param_json);
            }
            if(empty($aaa)){
                $aaa = $model->jdapi_goodslist6($param_json);
            }
            if(empty($aaa)){
                $aaa = $model->jdapi_goodslist7($param_json);
            }
            if(empty($aaa)){
                $aaa = $model->jdapi_goodslist8($param_json);
            }
            if(empty($aaa)){
                $aaa = $model->jdapi_goodslist9($param_json);
            }
            if(empty($aaa)){
                $aaa = $model->jdapi_goodslist10($param_json);
            }
            $result = $aaa[0];

            $result['goods_name']  = $result['skuName'];
            $result['goods_desc']  = $result['skuName'];
            $couponInfo = $model->jdapi_couponinfo($result['couponInfo']['couponList'][0]['link']);
            if(empty($couponInfo)){
                $couponInfo = $model->jdapi_couponinfo2($result['couponInfo']['couponList'][0]['link']);
            }
            if(empty($couponInfo)){
                $couponInfo = $model->jdapi_couponinfo3($result['couponInfo']['couponList'][0]['link']);
            }
            $result['coupon_total_quantity']  = $couponInfo[0]['num'];//优惠券总量
            $result['coupon_remain_quantity']  = $couponInfo[0]['remainNum'];//优惠券余量
            foreach ($result['imageInfo']['imageList'] as $k => $v){
                $result['goods_gallery_urls'][$k] = $v['url'];
            }
            $result['goods_thumbnail_url'] = $result['imageInfo']['imageList'][0]['url'];
            if($result['pingGouInfo']['pingouPrice']){
                $result['min_group_price']  = $result['pingGouInfo']['pingouPrice'];//最低拼团价，原价
            }else{
                $result['min_group_price']  = $result['priceInfo']['price'];//原价
            }           
            
            if($result['couponInfo']['couponList'][0]['discount'] >= $result['min_group_price']){
                $result['coupon_discount'] = 0;
                $result['now_price']  = $result['min_group_price'];//现价
            }else{
                $result['coupon_discount']  = $result['couponInfo']['couponList'][0]['discount'];//优惠券面额
                $result['now_price']  = $result['min_group_price'] - $result['couponInfo']['couponList'][0]['discount'];//现价
            }
            
            if($user['is_daili'] == 0){
                $result['commission']   = round(($result['now_price']*$result['commissionInfo']['commissionShare']*$info['jdrate']*0.9/100),2);//
            }elseif($user['is_daili'] == 1){
                $result['commission']   = round(($result['now_price']*$result['commissionInfo']['commissionShare']*$info['jddailirate']*0.9/100),2);//
            }else{
                $result['commission']   = round(($result['now_price']*$result['commissionInfo']['commissionShare']*$info['jdzongjianrate']*0.9/100),2);//
            }
            
            $result['coupon_start_time']= date('Y-m-d',$result['couponInfo']['couponList'][0]['getStartTime']/1000); //开始时间
            $result['coupon_end_time']  = date('Y-m-d',$result['couponInfo']['couponList'][0]['getEndTime']/1000); //结束时间
            $result['sold_quantity'] = $result['inOrderCount30Days'];//销量
            $result['goods_title'] = "【京东】优惠券".$result['coupon_discount']."元\n原价￥".$result['min_group_price']." 券后价￥".$result['now_price'];

            $this->result(0, '商品详情',$result); 
        }   
        
    }

    /***
    //
    //商品详情接口
    //
    **/
    public function goodsdetail($user_id,$goods_id_list){
        
        global $_W,$_GPC;  
        //$user_id = $_GPC['user_id'];
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$user_id));     
        //$goods_id_list=$_POST['goods_id_list'];
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';
        $timestamp = time();
        $type = 'pdd.ddk.goods.detail';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'goods_id_list['.$goods_id_list.']timestamp'.$timestamp.'type'.$type.$client_secret;
        $sign = md5($signold);
        $sign = strtoupper($sign);
        $data = array (
            'type' => urlencode('pdd.ddk.goods.detail'),
            'data_type' => 'JSON',
            'goods_id_list' => '['.$goods_id_list.']',
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $result = $arr['goods_detail_response']['goods_details'][0];
        $result['min_normal_price'] = $result['min_normal_price'] / 100;//最低单买价
        $result['min_group_price']  = $result['min_group_price']  / 100;//最低拼团价，原价
        $result['coupon_discount']  = $result['coupon_discount']  / 100;//优惠券面额
        $result['now_price']        = round(($result['min_group_price'] - $result['coupon_discount']),2);//现价
        $result['sold_quantity']    = $result['sales_tip']; 

        if($user['is_daili'] == 2){
            $result['commission']       = round((($result['min_group_price'] - $result['coupon_discount']) * $result['promotion_rate']/1000*$info['zongjian_moneyrate']),2);//分享赚佣金
        }elseif($user['is_daili'] == 1){
            $result['commission']       = round((($result['min_group_price'] - $result['coupon_discount']) * $result['promotion_rate']/1000*$info['daili_moneyrate']),2);//分享赚佣金
        }else{
            $result['commission']       = round((($result['min_group_price'] - $result['coupon_discount']) * $result['promotion_rate']/1000*$info['moneyrate']),2);//分享赚佣金
        }
        
        //$this->result(0, '商品详情',$result);
        return $result;
    }
   /*
    * 获取商品分享链接
    */

    public function doPageShareurl(){
        
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        

        //pinduoduo
        if($_GPC['parameter'] == 0){

            $goods_id_list = $_POST['goods_id'];
            $user_id = $_POST['user_id'];
            $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
            $arr  = pdo_get('hcpdd_users',array('user_id'=>$user_id));
            $p_id      = $arr['pid'];
            $client_secret = $info['client_secret'];
            $client_id = $info['client_id'];
            $data_type = 'JSON';
            $generate_we_app    = 'true'; //是否是小程序跳转链接
            $generate_short_url = 'true'; //是否生成短链接
            $timestamp = time();
            $type = 'pdd.ddk.goods.promotion.url.generate';
            $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'generate_short_url'.$generate_short_url.'generate_we_app'.$generate_we_app.'goods_id_list['.$goods_id_list.']p_id'.$p_id.'timestamp'.$timestamp.'type'.$type.$client_secret;
            $sign = md5($signold);
            //echo $signold;
            $sign = strtoupper($sign);
            $data = array (
                'type' => urlencode('pdd.ddk.goods.promotion.url.generate'),
                'data_type' => 'JSON',
                'goods_id_list' => '['.$goods_id_list.']',
                'p_id' => $p_id,
                'generate_we_app' => $generate_we_app,
                'generate_short_url' => $generate_short_url,
                'timestamp' => urlencode($timestamp),
                'client_id' => $client_id,
                'sign' => $sign
            );
            $url = 'http://gw-api.pinduoduo.com/api/router';
            load()->func('communication');
            $response = ihttp_post($url,$data);
            $arr = json_decode($response['content'],true);
            $result = $arr['goods_promotion_url_generate_response']['goods_promotion_url_list'][0];

            $goodsname = $result['goods_detail']['goods_name'];
            $min_group_price = $result['goods_detail']['min_group_price']/100;
            $quanhou = ($result['goods_detail']['min_group_price'] - $result['goods_detail']['coupon_discount'])/100;
            $url = $result['short_url'];
           
            $wenan = "【限时抢购】".$goodsname."\n【拼团价】".$min_group_price."\n【券后价】".$quanhou."\n【下单地址】".$url."\n---------------------\n 1.长按识别二维码 \n 2.一键抢券 \n 3.立即购买，输入收货信息下单 \n 4.微信付款，等待收货即可！";
            $result['wenan'] = $wenan;
                     
            $this->result(0, '跳转链接',$result);

        }
        //蘑菇街
        if($_POST['parameter'] == 1){

            $model = new moguapiModel();
            $access_token = $info['access_token'];
            $app_key = $info['app_key'];
            $AppSecret = $info['app_secret'];

            $CpsChannelGroupParam = json_encode(array('name'=>$_GPC['user_id']));
            //$gid = $model->moguapi_getgid($access_token,$app_key,$AppSecret,$CpsChannelGroupParam);
            $user  = pdo_get('hcpdd_users',array('user_id'=>$_GPC['user_id']));
            if(empty($user['gid'])){
                $gid = $model->moguapi_getgid($access_token,$app_key,$AppSecret,$CpsChannelGroupParam);
                pdo_update('hcpdd_users',array('gid'=>$gid),array('user_id' => $_GPC['user_id']));
            }

            $wxcodeParam = json_encode(array('itemId'=>$_GPC['itemId'],'promId'=>$_GPC['promId'],'uid'=> $info['uid'],'genWxcode'=>'false','gid'=>$user['gid']));
            $res = $model->moguapi_getpath($access_token,$app_key,$AppSecret,$wxcodeParam);

            $result['we_app_info']['app_id'] = 'wxca3957e5474b3670';
            $result['we_app_info']['page_path'] = $res;

            $wenan = "蘑菇专享优惠券推广，领券下单享专属优惠！";
            $result['wenan'] = $wenan;
            
            $this->result(0, 'path',$result);
            
        }

        //京东
        if($_POST['parameter'] == 2){

            $model = new moguapiModel();
            //$app_key = $info['jdappkey'];
            //$AppSecret = $info['jdsecretkey'];
            $user  = pdo_get('hcpdd_users',array('user_id'=>$_GPC['user_id']));
            $spaceNameList = $_GPC['i'].'_'.$user['user_id'];
            $param_json = json_encode(
            array(
                'positionReq'=>
                array('unionId' => $info['unionId'],
                      'key' => $info['jdkey'],
                      'unionType' => 1,
                      'type' => 3,
                      'spaceNameList' => array($spaceNameList),
                      'siteId' => $info['siteid']
                      )
                )
            );

            
            if(empty($user['positionId'])){
                $positionId = $model->jdapi_getpid($spaceNameList,$param_json);
                if(empty($positionId)){
                    $positionId = $model->jdapi_getpid2($spaceNameList,$param_json);
                }
                if(empty($positionId)){
                    $positionId = $model->jdapi_getpid3($spaceNameList,$param_json);
                }

                pdo_update('hcpdd_users',array('positionId'=>$positionId),array('user_id' => $_GPC['user_id']));
            }

            $user2  = pdo_get('hcpdd_users',array('user_id'=>$_GPC['user_id']));

            $param_json2 = json_encode(
            array(
                'promotionCodeReq'=>
                array('materialId' => $_GPC['materialUrl'],
                    'unionId' => $info['unionId'],
                    'couponUrl' => $_GPC['couponUrl'],
                    'positionId' => $user2['positionId']
                      )
                )
            );

            $res = $model->jdapi_getpath($param_json2);
            if(empty($res)){
                $res = $model->jdapi_getpath2($param_json2);
            }
            if(empty($res)){
                $res = $model->jdapi_getpath3($param_json2);
            }
            $result['we_app_info']['app_id'] = 'wx13e41a437b8a1d2e';
            $result['we_app_info']['page_path'] = '/pages/product/product?wareId='.$_GPC['skuId'].'&spreadUrl='.$res.'&customerinfo=20190115ypxp';
            $wenan = "京东专享优惠券推广，领券下单享专属优惠！";
            $result['wenan'] = $wenan;
            $result['positionId'] = $positionId;
            
            $this->result(0, 'path',$result);
            
        }
        
    }
    //主题推广链接
    public function doPageSharetheme(){

        global $_GPC, $_W;
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';
        $timestamp = time();
        $theme_id_list = '['.$_GPC['theme_id'].']';
        $generate_we_app    = 'true';
        $generate_short_url = 'true';
        $generate_mobile = 'true';
        $pid = $user['pid'];
        $type = 'pdd.ddk.theme.prom.url.generate';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'generate_mobile'.$generate_mobile.'generate_short_url'.$generate_short_url.'generate_we_app'.$generate_we_app.'pid'.$pid.'theme_id_list'.$theme_id_list.'timestamp'.$timestamp.'type'.$type.$client_secret;
        $sign = md5($signold);
        $sign = strtoupper($sign);
        $data = array (
            'type' => urlencode('pdd.ddk.theme.prom.url.generate'),
            'data_type' => 'JSON',
            'generate_mobile' => $generate_mobile,
            'generate_short_url' => $generate_short_url,
            'generate_we_app' => $generate_we_app,
            'theme_id_list' => $theme_id_list,
            'timestamp' => urlencode($timestamp),
            'pid' => $pid,
            'client_id' => $client_id,
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $result = $arr['theme_promotion_url_generate_response']['url_list'][0];
        $lianjie = $result['short_url'];
        $tname = $_GPC['tname'];

        $wenan = "【主题推荐】".$tname."\n【主题地址】".$lianjie;

        $this->result(0, '主题推广链接',$wenan);

    }
 /**
  * 推广订单列表接口
  */
     public function doPageOrderlist(){
        
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $user_id = $_POST['user_id'];
        $arr  = pdo_get('hcpdd_users',array('user_id'=>$user_id));
        $user  = pdo_get('hcpdd_users',array('user_id'=>$user_id));
        $pageindex = max(1, intval($_GPC['pageNum']));
        $pagesize = 10;
        
        if($_GPC['parameter'] == 0){
            $p_id      = $arr['pid'];
            $order_status = $_POST['order_status'];
            if($order_status == 0){
                $historyresult = pdo_getslice('hcpdd_allorder',array('uniacid' =>$_GPC['i'],'p_id'=>$p_id),array($pageindex, $pagesize),$total,array(),'','order_pay_time DESC');
                //$historyresult = pdo_getall('hcpdd_allorder', array('uniacid' =>$_GPC['i'],'p_id'=>$p_id),array() ,'','order_pay_time DESC');
            }else{
                $historyresult = pdo_getslice('hcpdd_allorder',array('uniacid' =>$_GPC['i'],'order_status'=>$order_status,'p_id'=>$p_id),array($pageindex, $pagesize),$total,array(),'','order_pay_time DESC');
                //$historyresult = pdo_getall('hcpdd_allorder', array('uniacid' =>$_GPC['i'],'order_status'=>$order_status,'p_id'=>$p_id),array() ,'','order_pay_time DESC');
            }
            $result = $historyresult;
            $dailitime  = pdo_getcolumn('hcpdd_orders',array('weid'=>$_GPC['i'],'uid'=>$_GPC['user_id'],'fid'=>0),array('paytime'));
            $zongjiantime  = pdo_getcolumn('hcpdd_orders',array('weid'=>$_GPC['i'],'uid'=>$_GPC['user_id'],'fid'=>1),array('paytime'));

            foreach ($result as $k => $v) {
                $rate = pdo_getall('hcpdd_moneyrate', array('uniacid' =>$_GPC['i']), array() , '','edittime DESC');
                $first = pdo_getcolumn('hcpdd_moneyrate', array('uniacid' =>$_GPC['i']), 'min(edittime)'); 
                $frate = pdo_get('hcpdd_moneyrate',array('uniacid'=>$_GPC['i'],'edittime'=>$first));         
                foreach ($rate as $key => $value) {
                    $info['zongjian_moneyrate'] = $frate['zongjian_moneyrate'];
                    $info['daili_moneyrate'] = $frate['daili_moneyrate'];
                    $info['moneyrate'] = $frate['moneyrate'];
                    if($v['order_create_time'] > $value['edittime']){
                        $info['zongjian_moneyrate'] = $value['zongjian_moneyrate'];
                        $info['daili_moneyrate'] = $value['daili_moneyrate'];
                        $info['moneyrate'] = $value['moneyrate'];
                        break;
                    }
                }
                $result[$k]['order_create_time'] = date('Y-m-d',$v['order_create_time']);//订单生成时间
                if($arr['is_daili'] == 2){
                        if($v['order_create_time'] < $zongjiantime and $v['order_create_time'] > $dailitime){
                           $result[$k]['promotion_amount']  = round(($v['promotion_amount']/100*$info['daili_moneyrate']),2);   //佣金  
                        }elseif($v['order_create_time'] < $dailitime){
                           $result[$k]['promotion_amount']  = round(($v['promotion_amount']/100*$info['moneyrate']),2);   //佣金
                        }else{
                           $result[$k]['promotion_amount']  = round(($v['promotion_amount']/100*$info['zongjian_moneyrate']),2);   //佣金 
                        }
                                   
                }elseif($arr['is_daili'] == 1){
                        if($v['order_create_time'] < $dailitime){
                           $result[$k]['promotion_amount']  = round(($v['promotion_amount']/100*$info['moneyrate']),2);      //佣金
                        }else{
                           $result[$k]['promotion_amount']  = round(($v['promotion_amount']/100*$info['daili_moneyrate']),2);      //佣金 
                        }        
                }else{
                        $result[$k]['promotion_amount']  = round(($v['promotion_amount']/100*$info['moneyrate']),2);         //佣金
                }
                
                $result[$k]['order_amount']      = $v['order_amount']/100;               //订单价格
            }
        }
        if($_GPC['parameter'] == 1){

            $result = pdo_getslice('hcpdd_moguorders',array('uniacid' =>$_GPC['i'],'groupId'=>$arr['gid']),array($pageindex, $pagesize),$total,array(),'','orderTime DESC');
            //$result = pdo_getall('hcpdd_moguorders', array('uniacid' =>$_GPC['i'],'groupId'=>$arr['gid']),array() ,'','orderTime DESC');
            $model = new moguapiModel();
            $access_token = $info['access_token'];
            $app_key = $info['app_key'];
            $AppSecret = $info['app_secret'];

            foreach ($result as $k => $v) {
                $products = json_decode($v['products'],true);
                $result[$k]['goods_name'] = $products[0]['name'];
                //$result[$k]['promotion_amount'] = $v['expense'];
                if($user['is_daili'] == 0){
                    $result[$k]['promotion_amount']   = round(($v['expense']*$info['mogurate']),2);//
                }elseif($user['is_daili'] == 1){
                    $result[$k]['promotion_amount']   = round(($v['expense']*$info['mogudailirate']),2);//
                }else{
                    $result[$k]['promotion_amount']   = round(($v['expense']*$info['moguzongjianrate']),2);//
                } 
                $result[$k]['order_amount'] = $v['price'];

                $pic = $model->moguapi_goodsdetail($access_token,$app_key,$AppSecret,$products[0]['productUrl']);
                $result[$k]['goods_thumbnail_url'] = $pic['pictUrl'];
                if($v['paymentStatus'] == 20000){
                    $result[$k]['order_status_desc'] = "已支付";
                }
                if($v['paymentStatus'] == 30000){
                    $result[$k]['order_status_desc'] = "已退款";
                }
                if($v['paymentStatus'] == 40000){
                    $result[$k]['order_status_desc'] = "已完成";
                }
                if($v['paymentStatus'] == 45000){
                    $result[$k]['order_status_desc'] = "最终完成";
                }
                if($v['paymentStatus'] == 90000){
                    $result[$k]['order_status_desc'] = "已取消";
                }
                if($v['paymentStatus'] == 95000){
                    $result[$k]['order_status_desc'] = "订单被风控";
                }
            }
        }
        if($_GPC['parameter'] == 2){

            $result = pdo_getslice('hcpdd_jdorders',array('uniacid' =>$_GPC['i'],'positionId'=>$arr['positionId']),array($pageindex, $pagesize),$total,array(),'','orderTime DESC');
            //$result = pdo_getall('hcpdd_jdorders',array('uniacid' =>$_GPC['i'],'positionId'=>$arr['positionId']),array() ,'','orderTime DESC');
            $model = new moguapiModel();
            //$app_key = $info['jdappkey'];
            //$AppSecret = $info['jdsecretkey'];

            foreach ($result as $k => $v) {
                $skuList = json_decode($v['skuList'],true);
                $result[$k]['goods_name'] = $skuList[0]['skuName'];
                $param_json = json_encode(
                array(
                    'goodsReqDTO'=>
                    array(
                          'skuIds' => array($skuList[0]['skuId'])
                          )
                    )
                );
                //$result[$k]['promotion_amount'] = $v['expense'];
                /*if($user['is_daili'] == 0){
                    $result[$k]['promotion_amount']   = round(($v['commission']),2);//
                }elseif($user['is_daili'] == 1){
                    $result[$k]['promotion_amount']   = round(($skuList[0]['estimateFee']*$info['jddailirate']),2);//
                }else{
                    $result[$k]['promotion_amount']   = round(($skuList[0]['estimateFee']*$info['jdzongjianrate']),2);//
                } */
                $result[$k]['promotion_amount']   = round(($v['commission']),2);//
                $result[$k]['order_amount'] = $skuList[0]['estimateCosPrice'];

                $pic = $model->jdapi_goodslist($param_json);
                if(empty($pic)){
                    $pic = $model->jdapi_goodslist2($param_json);
                }
                if(empty($pic)){
                    $pic = $model->jdapi_goodslist3($param_json);
                }
                if(empty($pic)){
                    $pic = $model->jdapi_goodslist5($param_json);
                }
                if(empty($pic)){
                    $pic = $model->jdapi_goodslist6($param_json);
                }
                if(empty($pic)){
                    $pic = $model->jdapi_goodslist7($param_json);
                }
                if(empty($pic)){
                    $pic = $model->jdapi_goodslist8($param_json);
                }
                if(empty($pic)){
                    $pic = $model->jdapi_goodslist9($param_json);
                }
                if(empty($pic)){
                    $pic = $model->jdapi_goodslist10($param_json);
                }
                $result[$k]['goods_thumbnail_url'] = $pic[0]['imageInfo']['imageList'][0]['url'];
                
                if($v['validCode'] == 16){
                    $result[$k]['order_status_desc'] = "已支付";
                }elseif($v['validCode'] == 17){
                    $result[$k]['order_status_desc'] = "已完成";
                }elseif($v['validCode'] == 18){
                    $result[$k]['order_status_desc'] = "已结算";
                }else{
                    $result[$k]['order_status_desc'] = "无效订单";
                }
                
            }
        }
        

        $this->result(0, '推广订单列表',$result);
     }

    //联系我们信息
    public function doPageContact(){
        global $_GPC, $_W;
        $config = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']),array('contact','contact_qr'));
        $config['contact_qr'] = $_W['attachurl'].$config['contact_qr'];
        
        return $this->result(0, '联系方式',$config);
    }
    //超级搜京东
    public function doPageChaojisojd(){
        global $_GPC, $_W;
        $config = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']),array('is_jd'));
        
        return $this->result(0,'是否开启京东',$config);
    }
    //小程序头部颜色
    public function doPageHeadcolor(){
        
        global $_GPC, $_W;
        
        $user_id = $_POST['user_id'];
        $config = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i'])); 
        $info = pdo_get('hcpdd_cset',array('uniacid'=>$_GPC['i']));
        $arr  = pdo_get('hcpdd_users',array('user_id'=>$user_id,'uniacid'=>$_GPC['i']));
        $theme = pdo_get('hcpdd_theme',array('uniacid'=>$_GPC['i']));
        $hongbao = pdo_get('hcpdd_hongbao',array('uniacid'=>$_GPC['i']));
        
        if($config['is_mogu'] == 0 and $config['is_jd'] == 0){
            $config['kaiguan'] = 0;//pdd
        }elseif($config['is_mogu'] == 1 and $config['is_jd'] == 0){
            $config['kaiguan'] = 1;//pdd,mogu
        }elseif($config['is_mogu'] == 0 and $config['is_jd'] == 1){
            $config['kaiguan'] = 2;//pdd,jd
        }elseif($config['is_mogu'] == 1 and $config['is_jd'] == 1){
            $config['kaiguan'] = 3;//pdd,jd,mogu
        }
        
        $config['pid'] = $arr['pid']; 
        $config['p_id'] = $arr['pid']; 
        $config['pdd'] = $arr['pid']; 
        $config['user'] = $arr['pid'];       
        
        if(empty($config['share_icon'])){
            $config['share_icon']='';           
        }elseif(strpos($config['share_icon'],'https') !== false){
            $config['share_icon'] = $config['share_icon'];
        }else{
            $config['share_icon'] = $_W['attachurl'].$config['share_icon'];
        }
        if(empty($config['treesharepic'])){
            $config['treesharepic']='';           
        }elseif(strpos($config['treesharepic'],'https') !== false){
            $config['treesharepic'] = $config['treesharepic'];
        }else{
            $config['treesharepic'] = $_W['attachurl'].$config['treesharepic'];
        }
        /*if(empty($config['tree_pic'])){
            $config['tree_pic']='';           
        }elseif(strpos($config['tree_pic'],'https') !== false){
            $config['tree_pic'] = $config['tree_pic'];
        }else{
            $config['tree_pic'] = $_W['attachurl'].$config['tree_pic'];
        }
        if(empty($config['treewith_pic'])){
            $config['treewith_pic']='';           
        }elseif(strpos($config['treewith_pic'],'https') !== false){
            $config['treewith_pic'] = $config['treewith_pic'];
        }else{
            $config['treewith_pic'] = $_W['attachurl'].$config['treewith_pic'];
        }*/
        //indexpic
        $config['tree_pic'] = tomedia($config['tree_pic']);
        $config['tree_pic2'] = tomedia($config['tree_pic2']);
        $config['treewith_pic'] = tomedia($config['treewith_pic']);
        if(empty($config['indexpic'])){
            $config['indexpic']='';           
        }elseif(strpos($config['indexpic'],'https') !== false){
            $config['indexpic'] = $config['indexpic'];
        }else{
            $config['indexpic'] = $_W['attachurl'].$config['indexpic'];
        }
        //loginbg
        if(empty($config['loginbg'])){
            $config['loginbg']='';           
        }elseif(strpos($config['loginbg'],'https') !== false){
            $config['loginbg'] = $config['loginbg'];
        }else{
            $config['loginbg'] = $_W['attachurl'].$config['loginbg'];
        }
        //bg_pic
        /*if(empty($config['bg_pic'])){
            $config['bg_pic']='';           
        }elseif(strpos($config['bg_pic'],'https') !== false){
            $config['bg_pic'] = $config['bg_pic'];
        }else{
            $config['bg_pic'] = $_W['attachurl'].$config['bg_pic'];
        }*/
        $config['bg_pic'] = tomedia($config['bg_pic']);
        //invite_bg
        if($info['invite_bg']){
            $info['invite_bg'] = $_W['attachurl'].$info['invite_bg'];           
        }elseif(strpos($info['invite_bg'],'https') !== false){
            $info['invite_bg'] = $info['invite_bg'];
        }else{
            $info['invite_bg'] = '';
        }
        if(empty($config['zeroshare'])){
            $config['zeroshare']='';           
        }elseif(strpos($config['zeroshare'],'https') !== false){
            $config['zeroshare'] = $config['zeroshare'];
        }else{
            $config['zeroshare'] = $_W['attachurl'].$config['zeroshare'];
        }
        if(empty($config['zerobuy'])){
            $config['zerobuy']='';           
        }elseif(strpos($config['zerobuy'],'https') !== false){
            $config['zerobuy'] = $config['zerobuy'];
        }else{
            $config['zerobuy'] = $_W['attachurl'].$config['zerobuy'];
        }
        if(empty($hongbao['open_bg'])){
            $hongbao['open_bg']='';           
        }elseif(strpos($config['open_bg'],'https') !== false){
            $hongbao['open_bg'] = $hongbao['open_bg'];
        }else{
            $hongbao['open_bg'] = $_W['attachurl'].$hongbao['open_bg'];
        }
        if(empty($hongbao['fenxiangpic'])){
            $hongbao['fenxiangpic']='';           
        }elseif(strpos($hongbao['fenxiangpic'],'https') !== false){
            $hongbao['fenxiangpic'] = $hongbao['fenxiangpic'];
        }else{
            $hongbao['fenxiangpic'] = $_W['attachurl'].$hongbao['fenxiangpic'];
        }
        //首页是否显示主题活动
        $yesno = pdo_get('hcpdd_theme',array('uniacid'=>$_GPC['i']),array('enabled','banner')); 
        if(strpos($yesno['banner'],'https') !== false){
           $yesno['banner'] = $yesno['banner']; 
        }else{
           $yesno['banner'] = $_W['attachurl'].$yesno['banner'];
        }
        //小图标
        $icon['jd'] = $_W['siteroot']."addons/hc_pdd/template/img/jd.png";
        $icon['pdd'] = $_W['siteroot']."addons/hc_pdd/template/img/pdd.png";
        $icon['mogu'] = $_W['siteroot']."addons/hc_pdd/template/img/mogu.png";
          
        $config['text'] = "1111111\n111111";

        if($config['getmobile'] == 1){
            if($arr['mobile']){
                $is_mobile = 1; //已获取到手机号
            }else{
                $is_mobile = 0; //未获取到手机号
            }
        }else{
            $is_mobile = 1;
        }

        //首页轮播图
        $banner = pdo_getall('hcpdd_adv', array('enabled'=>1,'uniacid' => $_GPC['i']), array(), '', 'displayorder asc');
        foreach ($banner as $key => $val) {
            if(strpos($val['thumb'],'https') !== false){
               $banner[$key]['thumb'] = $val['thumb'];
            }else{
               $banner[$key]['thumb'] = $_W['attachurl'].$val['thumb'];
            }

            if(strpos($val['diypic'],'https') !== false){
               $banner[$key]['diypic'] = $val['diypic'];
            }else{
               $banner[$key]['diypic'] = $_W['attachurl'].$val['diypic'];
            }        
        }
        //首页导航栏
        $nav = pdo_getall('hcpdd_nav', array('parentid'=>0,'status'=>1,'uniacid' => $_GPC['i']), array(),'','displayorder asc', array(1,16));
        foreach ($nav as $key => $val) {
            $nav[$key]['icon'] = tomedia($val['icon']);           
        }
        //首页展示位
        $show = pdo_get('hcpdd_show', array('uniacid' => $_GPC['i']));
        
        if(strpos($show['show1'],'https') !== false){
           $show['show1'] = $show['show1'];
        }else{
           $show['show1'] = $_W['attachurl'].$show['show1']; 
        }
        if(strpos($show['show2'],'https') !== false){
           $show['show2'] = $show['show2'];
        }else{
           $show['show2'] = $_W['attachurl'].$show['show2']; 
        }
        if(strpos($show['show3'],'https') !== false){
           $show['show3'] = $show['show3'];
        }else{
           $show['show3'] = $_W['attachurl'].$show['show3']; 
        }
        if(strpos($show['show4'],'https') !== false){
           $show['show4'] = $show['show4'];
        }else{
           $show['show4'] = $_W['attachurl'].$show['show4']; 
        }
        if(strpos($show['show5'],'https') !== false){
           $show['show5'] = $show['show5'];
        }else{
           $show['show5'] = $_W['attachurl'].$show['show5']; 
        }

        if(empty($show['rexiao1'])){
            $show['rexiao1'] = '实时热销榜';
        }
        if(empty($show['rexiao2'])){
            $show['rexiao2'] = '看看大家都在买什么';
        }
        if(empty($show['baoyou1'])){
            $show['baoyou1'] = '9.9包邮';
        }
        if(empty($show['baoyou2'])){
            $show['baoyou2'] = '全民疯抢，低价包邮';
        }
        if(empty($show['youhui1'])){
            $show['youhui1'] = '品牌优惠';
        }
        if(empty($show['youhui2'])){
            $show['youhui2'] = '大牌保障，尊享品质';
        }
         

        $hongbao['cishushangxian'] = 0;
        $time=date('Y-m-d',time());
        $hb = pdo_get('hcpdd_hblog', array('hongbaotime'=>$time,'uniacid'=>$_GPC['i'],'user_id'=>$user_id));

        $hb_day = count($hb);
        $hongbao['cishu'] = $hb_day;
        if($hb){
            if($hb_day >= $hongbao['hb_day']){
                $hongbao['cishushangxian'] = 1;
            }
        }
        $hb['endtime'] = date("Y-m-d H:i",$hb['e_time']);
        $hongbao['status'] = $hb['status'];

        return $this->result(0, '各种颜色',array('config'=>$config,'yesno'=>$yesno,'is_daili'=>$arr['is_daili'],'info'=>$info,'theme'=>$theme,'is_mobile'=>$is_mobile,'hongbao'=>$hongbao,'hb'=>$hb,'user'=>$arr,'banner'=>$banner,'nav'=>$nav,'show'=>$show,'icon'=>$icon));
    }

    //各种文字
    public function doPageNavlist(){
        global $_GPC, $_W;
        //首页轮播图
        $banner = pdo_getall('hcpdd_adv', array('enabled'=>1,'uniacid' => $_GPC['i']), array(), '', 'displayorder asc');
        foreach ($banner as $key => $val) {
            if(strpos($val['thumb'],'https') !== false){
               $banner[$key]['thumb'] = $val['thumb'];
            }else{
               $banner[$key]['thumb'] = $_W['attachurl'].$val['thumb'];
            }

            if(strpos($val['diypic'],'https') !== false){
               $banner[$key]['diypic'] = $val['diypic'];
            }else{
               $banner[$key]['diypic'] = $_W['attachurl'].$val['diypic'];
            }        
        }
        //首页导航栏
        $nav = pdo_getall('hcpdd_nav', array('parentid'=>0,'status'=>1,'uniacid' => $_GPC['i']), array(),'','displayorder asc');
        foreach ($nav as $key => $val) {
            $nav[$key]['icon'] = tomedia($val['icon']);           
        }

        return $this->result(0, '各种文字',array('banner'=>$banner,'nav'=>$nav));
    }

    //各种文字
    public function doPageDiyname(){
        global $_GPC, $_W;
        $user_id = $_GPC['user_id'];
        $arr  = pdo_get('hcpdd_users',array('user_id'=>$user_id,'uniacid'=>$_GPC['i']));
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $config = pdo_get('hcpdd_cset',array('uniacid'=>$_GPC['i'])); 
        $config['invite_pic'] = $_W['attachurl'].$config['invite_pic'];
        if($arr['is_daili'] == 0){
            $config['rolename'] = $info['huiyuan'];
        }
        if($arr['is_daili'] == 1){
            $config['rolename'] = $config['daili'];
        }
        if($arr['is_daili'] == 2){
            $config['rolename'] = $config['yunyingzongjian'];
        }
        $config['shengdaili'] = tomedia($config['shengdaili']);
        $config['shengzongjian'] = tomedia($config['shengzongjian']);

        $role[0] = $config['daili'];
        $role[1] = $config['yunyingzongjian'];
        return $this->result(0, '各种文字',array('config'=>$config,'role'=>$role));
    }


    ///生成推广位
    public function CreatePid(){
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';
        $timestamp = time();
        $type = 'pdd.ddk.goods.pid.generate';
        $number = '1';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'number'.$number.'timestamp'.$timestamp.'type'.$type.$client_secret;
        $sign = md5($signold);
        $sign = strtoupper($sign);

        $data = array (
            'type' => urlencode('pdd.ddk.goods.pid.generate'),
            'data_type' => 'JSON',
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'number'    => $number,
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $result = $arr['p_id_generate_response']['p_id_list'][0];
        $pid = $result['p_id'];
       
        return $pid;
    } 

    
    function api_notice_increment($url, $data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function doPageTixian(){
        global $_GPC, $_W;
        $type = $_POST['kenif'];
        $user_id=$_POST['user_id'];
        $user = pdo_get('hcpdd_users', array('user_id'=>$user_id,'uniacid'=>$_GPC['i']));
        $set = pdo_get('hcpdd_set', array('uniacid'=>$_GPC['i']));

        $time=date('Y-m-d',time());
        $tixian = pdo_getall('hcpdd_tixian', array('open_id'=>$user['open_id'],'uniacid'=>$_GPC['i']), array() , '','id DESC');
        if($tixian){
            if(date('Y-m-d',strtotime($tixian[0]['payment_time']))==$time){
                $res[0]='今日已提现';
                return $this->result(1, '一天只允许提现一次', $res);
            }
        }
        $tx['user_id'] = $_POST['user_id'];
        $tx['uniacid'] = $_GPC['i'];
        $tx['open_id'] = $user['open_id'];
        $tx['tel'] = $_POST['tel'];
        $res = $this->isMobile($tx['tel']);
        if ($res == false){
            return $this->result(1, '请输入正确的手机号',$tx);
            //exit;
        }
        $tx['weixin'] = $_POST['weixin'];
        $tx['truename'] = $_POST['name'];
        $tx['money'] = $_POST['tmoney'];
        $tx['payment_time'] = $time;
        if($user['money'] < $tx['money']){
            return $this->result(1, '可提现金额不足',$tx);
        }
        elseif($tx['money'] < $set['tx_money']){
            return $this->result(1, '至少提现'.$set['tx_money'].'元',$tx);
        }else{
            $tx['status'] = 1;
            $result = pdo_insert('hcpdd_tixian', $tx);
            $nowwaitmoney = $user['waitmoney'] + $tx['money'];
            $nowmoney     = $user['money'] - $tx['money'];
            /*$update =array(
                    'waitmoney' => $nowwaitmoney,
                    'money'     => $nowmoney
                    );*/
            $cao = pdo_update('hcpdd_users',array('waitmoney'=>$nowwaitmoney,'money'=>$nowmoney), array('user_id' => $user_id ));
            if($cao){
                    return $this->result(0, '申请成功',$tx);
            }else{
                    return $this->result(1, '系统错误',array('nowm'=>$nowwaitmoney,'n'=>$nowmoney));
                 }
                
            }

    }
    //微信提现
    public function doPageWxtixian()
    {
        ob_end_clean();
        global $_GPC, $_W;
        $user_id=$_GPC['user_id'];
        $money=$_GPC['tmoney'];
        $user = pdo_get('hcpdd_users', array('user_id' => $user_id));
        $set = pdo_get('hcpdd_set', array('uniacid'=>$_GPC['i']));

        $data['uniacid']=$_GPC['i'];
        $data['user_id']=$_GPC['user_id'];
        $data['money']=$_GPC['tmoney'];
        $data['add_time']=time();
        $data['partner_trade_no']='PDD'.time();
        $data['nick_name']=$user['nick_name'];

        if($user['money'] < $data['money']){
            return $this->result(1, '可提现金额不足',$data);
        }
        elseif($data['money'] < $set['tx_money']){
            return $this->result(1, '至少提现'.$set['tx_money'].'元',$data);
        }else{
            $data['status'] = 0;
            $result = pdo_insert('hcpdd_with', $data);
            $nowwaitmoney = $user['waitmoney'] + $data['money'];
            $nowmoney     = $user['money'] - $data['money'];
            /*$update =array(
                    'waitmoney' => $nowwaitmoney,
                    'money'     => $nowmoney
                    );*/
            $cao = pdo_update('hcpdd_users',array('waitmoney'=>$nowwaitmoney,'money'=>$nowmoney), array('user_id' => $user_id ));
            if($cao){
                    return $this->result(0, '申请成功',$data);
            }else{
                    return $this->result(1, '系统错误',array('nowm'=>$nowwaitmoney,'n'=>$nowmoney));
                 }              
            }
    }
    //红包树提现
    public function doPageTreetixian()
    {
        ob_end_clean();
        global $_GPC, $_W;
        $user_id=$_GPC['user_id'];
        $money=$_GPC['tmoney'];
        $user = pdo_get('hcpdd_users', array('user_id' => $user_id));
        $set = pdo_get('hcpdd_set', array('uniacid'=>$_GPC['i']));

        $data['uniacid']=$_GPC['i'];
        $data['user_id']=$_GPC['user_id'];
        $data['money']=$_GPC['tmoney'];
        $data['add_time']=time();
        $data['partner_trade_no']='PDD'.time();
        $data['nick_name']=$user['nick_name'];

        if($user['treemoney'] < $data['money']){
            return $this->result(1, '可提现金额不足',$data);
        }
        elseif($data['money'] < $set['min_treetxmoney']){
            return $this->result(1, '至少提现'.$set['min_treetxmoney'].'元',$data);
        }else{
            $data['status'] = 0;
            $result = pdo_insert('hcpdd_treewith', $data);
            $nowmoney     = $user['treemoney'] - $data['money'];
            /*$update =array(
                    'waitmoney' => $nowwaitmoney,
                    'money'     => $nowmoney
                    );*/
            $cao = pdo_update('hcpdd_users',array('treemoney'=>$nowmoney), array('user_id' => $user_id ));
            if($cao){
                    return $this->result(0, '申请成功',$data);
            }else{
                    return $this->result(1, '系统错误',array('n'=>$nowmoney));
                 }              
            }
    }
    //提成提现
    public function doPageCtixian(){
        global $_GPC, $_W;
        $user_id=$_POST['user_id'];
        $user = pdo_get('hcpdd_users', array('user_id' => $user_id));

        $time=date('Y-m-d',time());
        $tixian = pdo_getall('hcpdd_ctixian', array( 'open_id' => $user['open_id']), array() , '','id DESC');
        if($tixian){
            if(date('Y-m-d',strtotime($tixian[0]['payment_time']))==$time){
                $res[0]='今日已提现';
                return $this->result(1, '一天只允许提现一次', $res);
            }
        }
        $tx['user_id'] = $_POST['user_id'];
        $tx['uniacid'] = $_GPC['i'];
        $tx['open_id'] = $user['open_id'];
        $tx['tel'] = $_POST['tel'];
        $res = $this->isMobile($tx['tel']);
        if ($res == false){
            return $this->result(1, '请输入正确的手机号',$tx);
            //exit;
        }
        $tx['weixin'] = $_POST['weixin'];
        $tx['truename'] = $_POST['name'];
        $tx['money'] = $_POST['tmoney'];
        $tx['payment_time'] = $time;
        if($user['cmoney'] < $tx['money']){
            return $this->result(1, '可提现金额不足',$tx);
        }
        elseif($tx['money'] < 10){
            return $this->result(1, '至少提现10元',$tx);
        }else{
            $tx['status'] = 1;
            $result = pdo_insert('hcpdd_ctixian', $tx);
            $nowwaitmoney = $user['cwaitmoney'] + $tx['money'];
            $nowmoney     = $user['cmoney'] - $tx['money'];
            /*$update =array(
                    'waitmoney' => $nowwaitmoney,
                    'money'     => $nowmoney
                    );*/
            $cao = pdo_update('hcpdd_users',array('cwaitmoney'=>$nowwaitmoney,'cmoney'=>$nowmoney), array('user_id' => $user_id ));
            if($cao){
                    return $this->result(0, '申请成功',$tx);
            }else{
                    return $this->result(1, '系统错误',array('nowm'=>$nowwaitmoney,'n'=>$nowmoney));
                 }
                
            }

    }
    //账户信息
    public function doPageWithdraw(){
        
        global $_GPC, $_W;
        $type = $_POST['kenif'];
        $user_id=$_POST['user_id'];
        $info = pdo_get('hcpdd_cset',array('uniacid'=>$_GPC['i']));
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));
        $set = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $pid = pdo_getcolumn('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$user_id),array('pid'));
        $time  = pdo_getcolumn('hcpdd_orders',array('weid'=>$_GPC['i'],'uid'=>$_GPC['user_id'],'fid'=>1),array('paytime'));
        //$config = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']),array('contact','contact_qr'));
        if($type == 0){
            $users = pdo_get('hcpdd_users', array('user_id' => $user_id,'uniacid'=>$_GPC['i']),array('money','finishmoney','waitmoney'));
        }
        if($type == 1){
            $users = pdo_get('hcpdd_users', array('user_id' => $user_id,'uniacid'=>$_GPC['i']),array('cmoney','cfinishmoney','cwaitmoney'));
        }
        //拼多多 
        $history_zong = $this->history($user_id); //数据库同步的订单  
        $pddzisheng = $history_zong['zisheng'];
        $pddfenxiao = $history_zong['fenxiao'];
        if(empty($pddzisheng)){
            $pddzisheng = 0;
        }
        if(empty($pddfenxiao)){
            $pddfenxiao = 0;
        }
        $pddzong = round(($pddzisheng+$pddfenxiao),2);//拼多多预估收入
        //拼多多结束      
        //蘑菇街京东分销佣金
        if($info['fx_level'] == 0){
            $mogufenxiao = 0;
            $jdfenxiao = 0;
        }elseif($info['fx_level'] == 1) {
            $mogufenxiao = pdo_getcolumn('hcpdd_mogucommission',array('uniacid' => $_GPC['i'],'level'=>1,'status' =>0,'user_id'=>$_GPC['user_id']),array('sum(fx_commission)'));
            $jdfenxiao = pdo_getcolumn('hcpdd_jdcommission',array('uniacid' => $_GPC['i'],'level'=>1,'status' =>0,'user_id'=>$_GPC['user_id']),array('sum(fx_commission)'));
        }elseif($info['fx_level'] == 2){
            $mogufenxiao = pdo_getcolumn('hcpdd_mogucommission',array('uniacid' => $_GPC['i'],'level !='=>3,'status' =>0,'user_id'=>$_GPC['user_id']),array('sum(fx_commission)'));
            $jdfenxiao = pdo_getcolumn('hcpdd_jdcommission',array('uniacid' => $_GPC['i'],'level !='=>3,'status' =>0,'user_id'=>$_GPC['user_id']),array('sum(fx_commission)'));
        }elseif($info['fx_level'] == 3){
            $mogufenxiao = pdo_getcolumn('hcpdd_mogucommission',array('uniacid' => $_GPC['i'],'status' =>0,'user_id'=>$_GPC['user_id']),array('sum(fx_commission)'));
            $jdfenxiao = pdo_getcolumn('hcpdd_jdcommission',array('uniacid' => $_GPC['i'],'status' =>0,'user_id'=>$_GPC['user_id']),array('sum(fx_commission)'));
        }
        if(empty($mogufenxiao)){
            $mogufenxiao = 0;
        }
        if(empty($jdfenxiao)){
            $jdfenxiao = 0;
        }
        $moguzisheng = pdo_getcolumn('hcpdd_moguorders',array('groupId'=>$user['gid'],'orderStatus !='=>80000,'paymentStatus !='=>10000,'paymentStatus !='=>90000),array('sum(expense)'));//蘑菇街预估收入
        if(empty($moguzisheng)){
            $moguzisheng = 0;
        }
        if($user['is_daili'] == 0){
            $moguzong = $moguzisheng*$set['mogurate'] + $mogufenxiao;
        }
        if($user['is_daili'] == 1){
            $moguzong = $moguzisheng*$set['mogudailirate'] + $mogufenxiao;
        }
        if($user['is_daili'] == 2){
            $moguzong = $moguzisheng*$set['moguzongjianrate'] + $mogufenxiao;
        }
        $moguzong = round($moguzong,2);
        //蘑菇统计结束
        //京东
        if($user['positionId']>0){
            $jdzisheng = pdo_getcolumn('hcpdd_jdorders',array('positionId'=>$user['positionId'],'validCode !='=>18,'validCode >'=>15),array('sum(commission)'));// 
            $jdzisheng = round($jdzisheng,3);
        }else{
            $jdzisheng = 0;

        }
        //$jdzisheng = pdo_getcolumn('hcpdd_jdorders',array('positionId'=>$user['positionId'],'validCode !='=>18,'validCode >'=>15),array('sum(commission)'));//     
        if(empty($jdzisheng)){
            $jdzisheng = 0;
        }
        $jdzong = $jdzisheng + $jdfenxiao;
        $jdzong = round($jdzong,2);
        //京东结束
        if($set['is_mogu'] == 1 and $set['is_jd'] ==1){
            $all = $pddzong + $moguzong + $jdzong; //总预估
            $tongji = array();
            $tongji[0]['zisheng'] = $pddzisheng;
            $tongji[0]['fenxiao'] = $pddfenxiao;
            $tongji[0]['he'] = $pddzong;
            $tongji[1]['zisheng'] = $jdzisheng;
            $tongji[1]['fenxiao'] = $jdfenxiao;
            $tongji[1]['he'] = $jdzong;
            $tongji[2]['zisheng'] = $moguzisheng;
            $tongji[2]['fenxiao'] = $mogufenxiao;
            $tongji[2]['he'] = $moguzong;
        }elseif($set['is_mogu'] == 0 and $set['is_jd'] == 1){
            $all = $pddzong + $jdzong; //总预估
            $tongji = array();
            $tongji[0]['zisheng'] = $pddzisheng;
            $tongji[0]['fenxiao'] = $pddfenxiao;
            $tongji[0]['he'] = $pddzong;
            $tongji[1]['zisheng'] = $jdzisheng;
            $tongji[1]['fenxiao'] = $jdfenxiao;
            $tongji[1]['he'] = $jdzong;
            $tongji[2]['zisheng'] = 0;
            $tongji[2]['fenxiao'] = 0;
            $tongji[2]['he'] = 0;
        }elseif($set['is_mogu'] == 1 and $set['is_jd'] == 0){
            $all = $pddzong + $moguzong; //总预估
            $tongji = array();
            $tongji[0]['zisheng'] = $pddzisheng;
            $tongji[0]['fenxiao'] = $pddfenxiao;
            $tongji[0]['he'] = $pddzong;
            $tongji[1]['zisheng'] = 0;
            $tongji[1]['fenxiao'] = 0;
            $tongji[1]['he'] = 0;
            $tongji[2]['zisheng'] = $moguzisheng;
            $tongji[2]['fenxiao'] = $mogufenxiao;
            $tongji[2]['he'] = $moguzong;
        }else{
            $all = $pddzong;
            $tongji = array();
            $tongji[0]['zisheng'] = $pddzisheng;
            $tongji[0]['fenxiao'] = $pddfenxiao;
            $tongji[0]['he'] = $pddzong;
            $tongji[1]['zisheng'] = 0;
            $tongji[1]['fenxiao'] = 0;
            $tongji[1]['he'] = 0;
            $tongji[2]['zisheng'] = 0;
            $tongji[2]['fenxiao'] = 0;
            $tongji[2]['he'] = 0;
        }
        
    return $this->result(0, '提现页面',array('tongji'=>$tongji,'user'=>$users,'money'=>$all,'set'=>$set,'pddmoney'=>$pddzong,'mogumoney'=>$moguzong,'jdzong'=>$jdzong));

    }

    //红包树账户
    public function doPageTreewith(){
        
        global $_GPC, $_W;

        $set = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $users = pdo_get('hcpdd_users', array('user_id' => $_GPC['user_id'],'uniacid'=>$_GPC['i']),array('treemoney'));
       
        return $this->result(0, '提现页面',array('user'=>$users));

    }

    //红包树开红包
    public function doPageOpentree(){
        
        global $_GPC, $_W;
        $users = pdo_get('hcpdd_users', array('user_id' => $_GPC['user_id'],'uniacid'=>$_GPC['i']),array('head_pic','nick_name'));
       
        return $this->result(0, '用户信息',array('user'=>$users));

    }

    //公告列表
    public function doPageNotice(){

        global $_GPC, $_W;
        $notice = pdo_getall('hcpdd_notice', array('enabled' => 1,'uniacid'=>$_GPC['i']));
        foreach ($notice as $k => $v) {
            $notice[$k]['createtime'] = date('Y-m-d',$v['createtime']);
        }
        return $this->result(0, '公告',$notice);

    }

    //发圈素材
    public function doPageCopy(){

        global $_GPC, $_W;
        $user_id = $_GPC['user_id'];
        $set['copy_writer'] = pdo_getcolumn('hcpdd_set',array('uniacid'=>$_GPC['i']),array('copy_writer'));
        $set['copy_headpic'] = pdo_getcolumn('hcpdd_set',array('uniacid'=>$_GPC['i']),array('copy_headpic'));
        $set['copy_headpic'] = $_W['attachurl'].$set['copy_headpic'];
        $menu[0] = pdo_getcolumn('hcpdd_set',array('uniacid'=>$_GPC['i']),array('sptj'));
        $menu[1] = pdo_getcolumn('hcpdd_set',array('uniacid'=>$_GPC['i']),array('scyx'));
        $menu[2] = pdo_getcolumn('hcpdd_set',array('uniacid'=>$_GPC['i']),array('xsbf'));

        $pageindex = max(1, intval($_GPC['pageNum']));
        $pagesize = 5;
        $list = pdo_getslice('hcpdd_copy',array('uniacid'=>$_GPC['i'],'copy_type'=>$_GPC['copy']),array($pageindex, $pagesize),$total,array(),'','createtime DESC');
        $page = pagination($total, $pageindex, $pagesize);

        //$list = pdo_getall('hcpdd_copy', array('uniacid'=>$_GPC['i'],'copy_type'=>$_GPC['copy']),array(),'','createtime DESC');
        foreach ($list as $k => $v) {
            $list[$k]['copy_text'] = json_decode($v['copy_text']);
            $list[$k]['createtime'] = date('Y-m-d H:i',$v['createtime']);
            $list[$k]['copy_img'] = $_W['attachurl'].$v['copy_img'];
            $aaa = $this->goodsdetail($user_id,$v['copy_goodsid']);
            $list[$k]['yuanjia'] = $aaa['min_group_price'];
            $list[$k]['xianjia'] = $aaa['now_price'];
            $list[$k]['src_path'] = $aaa['goods_gallery_urls'][0];
            $list[$k]['goods_name'] = $aaa['goods_name'];
            $list[$k]['youhuiquan'] = $aaa['coupon_discount'];

            $list[$k]['commission'] = $aaa['commission'];
            $list[$k]['copy_imgs'] = $aaa['goods_gallery_urls'];
            if(count($list[$k]['copy_imgs']) > 3){
               $list[$k]['copy_imgs'] = array_slice($list[$k]['copy_imgs'],0,3); 
            }           
        }

        return $this->result(0, '发圈',array('list'=>$list,'menu'=>$menu,'set'=>$set,'aaa'=>$aaa));

    }

    public function GetQrcode($goods_id,$user_id,$itemUrl,$skuId,$materialUrl,$parameter){
        global $_GPC, $_W;
        // 获取access_token
        //$accessTokenObject = json_decode(file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$_W['account']['key'].'&secret='.$_W['account']['secret']));
        //二维码接口
        //$url="https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".$accessTokenObject->access_token;
        //菊花码
        /*$account_api = WeAccount::create();
        $token = $account_api->getAccessToken();*/
        $token = $this->getToken();
        //$url = "https://api.weixin.qq.com/wxa/getwxacode?access_token=".$accessTokenObject->access_token;
        $url = "https://api.weixin.qq.com/wxa/getwxacode?access_token=".$token;
        //$goods_id = '447250186';
        $width = '100';
        
        /*if(!empty($itemUrl) and $goods_id =='undefined'){
          $path = '/hc_pdd/pages/details/details?itemUrl='.$itemUrl.'&user_id='.$user_id;  
        }else{
          $path = '/hc_pdd/pages/details/details?goods_id='.$goods_id.'&user_id='.$user_id;
        }*/
        if($parameter == 0){
           $path = '/hc_pdd/pages/details/details?goods_id='.$goods_id.'&parameter='.$parameter.'&user_id='.$user_id.'&sharein=sharein'; 
        }elseif($parameter == 1){
           $path = '/hc_pdd/pages/details/details?itemUrl='.$itemUrl.'&parameter='.$parameter.'&user_id='.$user_id.'&sharein=sharein';  
        }elseif($parameter == 2){
           $path = '/hc_pdd/pages/details/details?skuId='.$skuId.'&materialUrl='.$materialUrl.'&parameter='.$parameter.'&user_id='.$user_id.'&sharein=s';   
        }
        $json='{"path":"'.$path.'","width":'.$width.'}';
        //$json = '{"scene": "/user_id/'.$user_id.'", "width": 50, "page": ""}';
        //$data=$this->api_notice_increment($url,$json);
        $data=$this->request_post($url,$json);
        $name = $_GPC['i'].'_'.time().'qrcode.png';
        //$filename = dirname(__FILE__)."/erweima.png";
        $filename = dirname(__FILE__)."/qrcode/".$name;
        $local_file = fopen($filename, 'w');
        if (false !== $local_file) {
            if (false !== fwrite($local_file, $data)) {
                fclose($local_file);
            }
        }
        //file_put_contents($filename,$data);
        return $_W['siteroot']."addons/hc_pdd/qrcode/".$name;
    }
    //超级搜图片
    public function doPageChaojiso(){
        global $_GPC, $_W;
        $config = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        if(!empty($config['pddsobg'])){
            $res['pddhelp'] = tomedia($config['pddsobg']); 
        }else{
            $res['pddhelp'] = $_W['siteroot']."addons/hc_pdd/template/img/pddsobg.png";
        }
        if(!empty($config['jdsobg'])){
            $res['jdhelp'] = tomedia($config['jdsobg']); 
        }else{
            $res['jdhelp'] = $_W['siteroot']."addons/hc_pdd/template/img/jdsobg.png";
        }
        if(!empty($config['sohead'])){
            $res['so'] = tomedia($config['sohead']); 
        }else{
            $res['so'] = $_W['siteroot']."addons/hc_pdd/template/img/sohead.png";
        }

        $res['sobian'] = $_W['siteroot']."addons/hc_pdd/template/img/sobian.png";
        
        
        return $this->result(0, '图片',$res);

    }


    public function doPageCreatePoster(){
        global $_GPC, $_W;
        ob_end_clean();    
        $url = $_W['siteroot']."addons/hc_pdd/template/poster/poster.png";       
        $res['img']=$url;
        return $this->result(0, '海报',$url);
    }
    public function doPageSave(){
        global $_GPC, $_W;
        ob_end_clean();    
        $url = $_W['siteroot']."addons/hc_pdd/yaoqing.png";       
        $res['img']=$url;
        return $this->result(0, 'erweima',$url);
    }
    public function doPageTreeurl(){
        global $_GPC, $_W;
        ob_end_clean();    
        $url = $_W['siteroot']."addons/hc_pdd/template/poster/treeposter.png";       
        $res['img']=$url;
        return $this->result(0, '海报',$url);
    }
    public function doPageCreate(){
        ob_end_clean();
        ob_clean();
        global $_GPC, $_W;   
        $user_id = $_POST['user_id'];
        $src_path = $_POST['src_path'];
        $yuanjia = $_POST['yuanjia'];
        $quanhoujia = $_POST['xianjia'];  
        $youhuiquan = $_POST['youhuiquan'];
        $goodname = $_POST['goodname'];
        $path     = $_POST['path'];
        $goods_id = $_POST['goods_id'];
        $itemUrl = $_POST['itemUrl'];
        $skuId = $_POST['skuId'];
        $materialUrl = $_POST['materialUrl'];
        $parameter = $_POST['parameter'];
        //$qrcode = $this->GetQrcode($path,$user_id);
        $img = $this->CreatePoster($src_path,$yuanjia,$quanhoujia,$youhuiquan,$goodname,$goods_id,$user_id,$itemUrl,$skuId,$materialUrl,$parameter);
    }

    
    // 生成海报
    public function CreatePoster($src_path,$yuanjia,$quanhoujia,$youhuiquan,$goodname,$goods_id,$user_id,$itemUrl,$skuId,$materialUrl,$parameter){
        ob_end_clean();
        ob_clean();
        global $_W,$_GPC;        
        $dst_path = $_W['siteroot']."addons/hc_pdd/bg2.jpg";//背景图
        $qr_path = $this->GetQrcode($goods_id,$user_id,$itemUrl,$skuId,$materialUrl,$parameter);//小程序码
        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        $src = imagecreatefromstring(file_get_contents($src_path));
        $qr = imagecreatefromstring(file_get_contents($qr_path));
        //打上文字
        $font = '../addons/hc_pdd/PingFang.ttf';//字体路径
        $boldfont = '../addons/hc_pdd/Bold.ttf';//粗字体路径
        //echo $font;
        $black = imagecolorallocate($dst, 0x00, 0x00, 0x00);//字体颜色
        $red = imagecolorallocate($dst,224,47,37);//券后价字体颜色
        $white = imagecolorallocate($dst,255,255,255);//优惠券颜色
        $hui = imagecolorallocate($dst,126,126,126);//原价颜色

        //获取水印图片的宽高
        list($src_w, $src_h) = getimagesize($src_path);
        //将水印图片复制到目标图片上，最后个参数50是设置透明度，这里实现半透明效果
        //小图居中
        $center = (800 - $src_w)/2;
        if($center < 0){
            $center = 0;
        }
        if($src_w > 800){
            $img_p = imagecreatetruecolor(800, 800); //设置缩略图
            imagecopyresampled($img_p, $src, 0, 0, 0, 0, 800, 800, $src_w, $src_h);
            imagecopymerge($dst, $img_p,0, 320, 0, 0, 800, 800, 100);
        }else{
            imagecopymerge($dst, $src,$center, 320, 0, 0, $src_w, $src_h, 100);
        }
        //获取水印图片的宽高
        list($qr_w, $qr_h) = getimagesize($qr_path);
        $new_x = 300;
        $new_y = 300;
        $image_p = imagecreatetruecolor($new_x, $new_y); //设置缩略图
        imagecopyresampled($image_p, $qr, 0, 0, 0, 0, $new_x, $new_y, $qr_w, $qr_h);
        imagecopymerge($dst,$image_p,50,1150,0,0,$new_x,$new_y,100);
        $res = mb_strlen($goodname);
        
        if($res >= 18 and $res < 36){
            $goodname1 = mb_substr($goodname,0,18,'utf-8');
            $goodname2 = mb_substr($goodname,18,$res,'utf-8');
            $goodname = $goodname1."\n".$goodname2;
        }elseif($res >= 36) {
            $goodname1 = mb_substr($goodname,0,18,'utf-8');
            $goodname2 = mb_substr($goodname,18,20,'utf-8');
            $goodname3 = mb_substr($goodname,38,$res,'utf-8');
            $goodname = $goodname1."\n".$goodname2."\n".$goodname3;
        }

        $tquanhoujia = "券后价：￥".$quanhoujia;
        $tyuanjia = "原价￥".$yuanjia;
        $tyouhuiquan = $youhuiquan."元福利券";
        $ling = "领".$youhuiquan."元福利券";
        imagefttext($dst, 28, 0, 80, 70, $black, $font,$goodname);
        imagefttext($dst,28,0,280,230,$red, $boldfont,$tquanhoujia);//券后价
        imagefttext($dst,20,0,240,275,$hui, $boldfont,$tyuanjia);//原价
        imagefttext($dst,20,0,440,273,$white, $boldfont,$tyouhuiquan);//优惠券
        imagefttext($dst,40,0,420,1300,$red, $boldfont,$ling);//领优惠券
        //输出图片
        list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
        switch ($dst_type) {
        case 1://GIF
           //header('Content-Type: image/gif');
           imagegif($dst);
           break;
        case 2://JPG
           //header('Content-Type: image/jpeg');
           imagejpeg($dst);
           break;
        case 3://PNG
           //header('Content-Type: image/png');          
           imagepng($dst);
           break;
        default:
           break;
        }
        
        $filename = dirname(__FILE__)."/template/poster/poster.png";
        imagepng($dst,$filename);
        imagedestroy($dst);

    }
    //判断手机号
    public function isMobile($mobile) {
    if (!is_numeric($mobile)) {
        return false;
    }
    return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
    }

    public function getwxaqrcode()
    {
        global $_W,$_GPC;
        $access_token = $this->AccessToken();
        $url = 'https://api.weixin.qq.com/wxa/getwxacode?access_token='.$access_token;
        $path='/pages/details/details?goods_id='.$goods_id;
        $width=430;
        $data='{"path":"'.$path.'","width":'.$width.'}';
        $return = $this->request_post($url,$data);
        //将生成的小程序码存入相应文件夹下
        file_put_contents($_W['siteroot']."addons/hc_pdd/erweima.png",$return);
        return $_W['siteroot']."addons/hc_pdd/erweima.png";
    }
    public function request_post($url, $data){
            $ch = curl_init();
            $header = "Accept-Charset: utf-8";
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $tmpInfo = curl_exec($ch);
            if (curl_errno($ch)) {
                return false;
            }else{
                return $tmpInfo;
            }
        }
    //代理申请页面
    public function doPageAgent()
    {
        global $_W,$_GPC;
        $aaa = $_POST['yellow']; 
        $info = pdo_get('hcpdd_cset',array('uniacid'=>$_GPC['i']));
        $data = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_POST['user_id']));
        if($aaa == 0){
            $info['guize'] = $info['agreement'];          
        }else{
            $info['guize'] = $info['zongjian_agreement'];
        }
        $info['tip'] = "下线达到".$info['zongjiansum']."人可自动升级";

        if(!empty($info['guize_bg'])){
            $info['guize_bg'] = $_W['attachurl'].$info['guize_bg'];
        }else{
            $info['guize_bg']='';
        }

        return $this->result(0, '是否收费',array('info'=>$info,'data'=>$data['is_daili'],'res'=>$data['is_daili']));
    }
    //注册新代理
    public function doPageAgentzhuce()
    {
        global $_W,$_GPC;
        $data['is_daili'] = 1;
        $arr['uniacid'] = $_GPC['i'];
        $arr['user_id'] = $_POST['user_id'];
        if(!empty($_POST['user_id'])){
                $aaa['weid'] = $_GPC['i'];
                $aaa['uid'] = $_POST['user_id'];
                $aaa['fid'] = 0;
                $aaa['status'] = 0;
                $aaa['paytime'] = time();
                $result = pdo_insert('hcpdd_orders', $aaa, $replace = true);
                $res = pdo_update('hcpdd_users', $data, array('user_id' => $_POST['user_id']));
                //$result = pdo_insert('hcpdd_daili', $arr);
                if(!empty($res)){
                    return $this->result(0, '申请成功',$_POST['user_id']);
                }
                else{
                    return $this->result(1, '申请失败',$_POST['user_id']);
                }
            }
        else{
            return $this->result(1, 'user_id为空',$info);
        }
    }
    //邀请好友
    public function doPageInvite()
    {
        global $_W,$_GPC;
        $data = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_POST['user_id']));
        $info = pdo_get('hcpdd_cset',array('uniacid'=>$_GPC['i']));
        $img[0]['pic'] = $_W['attachurl'].$info['inviteposter1'];
        $img[1]['pic'] = $_W['attachurl'].$info['inviteposter2'];
        $img[2]['pic'] = $_W['attachurl'].$info['inviteposter3'];
        return $this->result(0, '是否代理',array('info'=>$info,'data'=>$data,'img'=>$img));

    }
    //邀请链接注册新人
    public function doPageYaoqingzhuce()
    {
        ob_end_clean();
        global $_GPC, $_W;
        $data['uniacid'] = $_GPC['i'];
        $data['city'] = $_POST['city'];
        $data['country'] = $_POST['country'];
        $data['gender'] = $_POST['gender'];
        $data['open_id'] = $_POST['openid'];
        $data['nick_name'] = $_POST['nickname'];
        $data['head_pic'] = $_POST['avatar'];
        $data['province'] = $_POST['province'];
        //$data['fatherid'] = $_POST['activation'];
        $stact = 1;
        if(empty($data['open_id'])){
            $this->result(0, $stact, '');
        }
        $uid = pdo_getcolumn('hcpdd_users', array('open_id' => $data['open_id'], 'uniacid' => $data['uniacid']), 'user_id', 1);
        if (empty($uid)) {
            $stact = 0;
            $data['fatherid'] = $_POST['activation'];
            if(!empty($_POST['user_id'])){
                pdo_update('hcpdd_users', array('user_id' => $_POST['getuser_id']));
            }
            $data['pid'] = $this->CreatePid();
            $result = pdo_insert('hcpdd_users', $data, $replace = true);
            $uid = pdo_insertid();

            $info = pdo_get('hcpdd_cset',array('uniacid'=>$_GPC['i']));
            $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$data['fatherid']));
            
            //按人数升级
            if($info['is_shoufei'] == 2){
                //一级下线
            $son1_daili = pdo_getall('hcpdd_users', array('fatherid' =>$data['fatherid'],'uniacid' =>$_GPC['i'],'is_daili !='=>0));
            $son1_huiyuan = pdo_getall('hcpdd_users', array('fatherid' =>$data['fatherid'],'uniacid' =>$_GPC['i'],'is_daili'=>0));
            $son1 = pdo_getall('hcpdd_users', array('fatherid' =>$data['fatherid'],'uniacid' =>$_GPC['i']));
            //二级下线    
                 foreach ($son1_daili as $k => $v) {
                    $son2_daili[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_GPC['i'],'is_daili !='=>0));
                    $son2_huiyuan[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_GPC['i'],'is_daili'=>0));       
                    $son2[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_GPC['i']));
                        //三级下线
                        foreach ($son2_daili[$k] as $key => $value) {
                        $son3_daili[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i'],'is_daili !='=>0));
                        $son3_huiyuan[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i'],'is_daili'=>0));
                        $son3[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i']));
                        }
                 }
                    if($info['fx_level'] == 3){
                        $count = count($son1)+count($son2)+count($son3);
                    }
                    if($info['fx_level'] == 2){
                        $count = count($son1)+count($son2);
                    }
                    if($info['fx_level'] == 1){
                        $count = count($son1);
                    }

                    /*if($count >= $info['dailisum'] and $user['is_daili'] < 1){
                       $aaa['is_daili'] = 1;
                       $result = pdo_update('hcpdd_users', $aaa, array('user_id' => $user['user_id']));
                    }*/
                    if($count >= $info['zongjiansum'] and $user['is_daili'] < 2){
                       $aaa['is_daili'] = 2;
                       $result = pdo_update('hcpdd_users', $aaa, array('user_id' => $user['user_id']));
                    }

            }
            
          

        }else{
            $result = pdo_update('hcpdd_users', $data, array('user_id' => $uid));
        }
        $this->result(0, $stact, $uid);
    }
    //分享商品注册新人
    public function doPageGoodszhuce()
    {
        ob_end_clean();
        global $_GPC, $_W;
        $data['uniacid'] = $_GPC['i'];
        $data['city'] = $_POST['city'];
        $data['country'] = $_POST['country'];
        $data['gender'] = $_POST['gender'];
        $data['open_id'] = $_POST['openid'];
        $data['nick_name'] = $_POST['nickname'];
        $data['head_pic'] = $_POST['avatar'];
        $data['province'] = $_POST['province'];
        //$data['fatherid'] = $_POST['activation'];
        $stact = 1;
        if(empty($data['open_id'])){
            $this->result(0, $stact, '');
        }
        $uid = pdo_getcolumn('hcpdd_users', array('open_id' => $data['open_id'], 'uniacid' => $data['uniacid']), 'user_id', 1);
        if (empty($uid)) {
            $stact = 0;
            $data['fatherid'] = $_POST['user_id'];

            $data['pid'] = $this->CreatePid();
            $result = pdo_insert('hcpdd_users', $data, $replace = true);
            $uid = pdo_insertid();

            $info = pdo_get('hcpdd_cset',array('uniacid'=>$_GPC['i']));
            $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$data['fatherid']));
            
            //按人数升级
            if($info['is_shoufei'] == 2){
                //一级下线
            $son1_daili = pdo_getall('hcpdd_users', array('fatherid' =>$data['fatherid'],'uniacid' =>$_GPC['i'],'is_daili !='=>0));
            $son1_huiyuan = pdo_getall('hcpdd_users', array('fatherid' =>$data['fatherid'],'uniacid' =>$_GPC['i'],'is_daili'=>0));
            $son1 = pdo_getall('hcpdd_users', array('fatherid' =>$data['fatherid'],'uniacid' =>$_GPC['i']));
            //二级下线    
                 foreach ($son1_daili as $k => $v) {
                    $son2_daili[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_GPC['i'],'is_daili !='=>0));
                    $son2_huiyuan[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_GPC['i'],'is_daili'=>0));       
                    $son2[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_GPC['i']));
                        //三级下线
                        foreach ($son2_daili[$k] as $key => $value) {
                        $son3_daili[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i'],'is_daili !='=>0));
                        $son3_huiyuan[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i'],'is_daili'=>0));
                        $son3[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i']));
                        }
                 }
                    if($info['fx_level'] == 3){
                        $count = count($son1)+count($son2)+count($son3);
                    }
                    if($info['fx_level'] == 2){
                        $count = count($son1)+count($son2);
                    }
                    if($info['fx_level'] == 1){
                        $count = count($son1);
                    }

                    /*if($count >= $info['dailisum'] and $user['is_daili'] < 1){
                       $aaa['is_daili'] = 1;
                       $result = pdo_update('hcpdd_users', $aaa, array('user_id' => $user['user_id']));
                    }*/
                    if($count >= $info['zongjiansum'] and $user['is_daili'] < 2){
                       $aaa['is_daili'] = 2;
                       $result = pdo_update('hcpdd_users', $aaa, array('user_id' => $user['user_id']));
                    }

            }
            
          

        }else{
            $result = pdo_update('hcpdd_users', $data, array('user_id' => $uid));
        }
        $this->result(0, $stact, $uid);

    }
    
    public function doPageMyteam()
    {
     
     global $_W,$_GPC;
     //各种设置
     $info = pdo_get('hcpdd_cset',array('uniacid'=>$_GPC['i']));
     $set = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));    
     $_POST['user_id'] = $_GPC['user_id'];

     $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));
     //一级下线
     $son1_daili = pdo_getall('hcpdd_users', array('fatherid' =>$_POST['user_id'],'uniacid' =>$_GPC['i'],'is_daili !='=>0));
     $son1_huiyuan = pdo_getall('hcpdd_users', array('fatherid' =>$_POST['user_id'],'uniacid' =>$_GPC['i'],'is_daili'=>0));
     $son1 = pdo_getall('hcpdd_users', array('fatherid' =>$_POST['user_id'],'uniacid' =>$_GPC['i']));
     //二级下线    
     foreach ($son1_daili as $k => $v) {
        $son2_daili[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_GPC['i'],'is_daili !='=>0));
        $son2_huiyuan[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_GPC['i'],'is_daili'=>0));       
        $son2[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_GPC['i']));

            /*foreach ($son2_daili[$k] as $key => $value) {
            $son3_daili[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i'],'is_daili !='=>0));
            $son3_huiyuan[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i'],'is_daili'=>0));
            $son3[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i']));
            }*/
     }
  
  //一级下线
     $pid1 = array_column($son1, 'pid');
  //二级下线
     foreach ($son2 as $k => $v) {
        foreach ($son2[$k] as $key => $value) {
            $aaa = pdo_getcolumn('hcpdd_users',array('uniacid'=>$_GPC['i'],'pid'=>$value['pid']),array('is_daili'));
            $pid2[] = $value['pid'];
            if($aaa == 0){
              $hpid2[] = $value['pid'];  
            }else{
              $dpid2[] = $value['pid'];
              $userid2[] = $value;
            }        
        }    
     }
    //三级下线
     foreach ($userid2 as $key => $value) {
            $son3_daili[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_W['uniacid'],'is_daili !='=>0));
            $son3_huiyuan[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_W['uniacid'],'is_daili'=>0));
            $son3[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_W['uniacid']));
    }      
   //三级下线  
     foreach ($son3 as $k => $v) {
        foreach ($son3[$k] as $key => $value) {
            $aaa = pdo_getcolumn('hcpdd_users',array('uniacid'=>$_GPC['i'],'pid'=>$value['pid']),array('is_daili'));
            $pid3[] = $value['pid'];
            if($aaa == 0){
              $hpid3[] = $value['pid'];  
            }else{
              $dpid3[] = $value['pid'];
            }
        }    
     }

     //一级
     foreach ($pid1 as $k => $v) {
        $list1[] = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'pid'=>$v));
     }
     foreach ($list1 as $k => $v) {
            $aaa = pdo_getcolumn('hcpdd_users',array('user_id'=>$v['user_id']),array('is_daili'));
            if($aaa == 0){
               $list1[$k]['juese'] = $set['huiyuan']; 
            }
            if($aaa == 1){
               $list1[$k]['juese'] = $info['daili']; 
            }
            if($aaa == 2){
               $list1[$k]['juese'] = $info['yunyingzongjian']; 
            }
            
     }

     //二级
     foreach ($pid2 as $k => $v) {
        $list2[] = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'pid'=>$v));
     }
     foreach ($list2 as $k => $v) {
            $aaa = pdo_getcolumn('hcpdd_users',array('user_id'=>$v['user_id']),array('is_daili'));
            if($aaa == 0){
               $list2[$k]['juese'] = $set['huiyuan']; 
            }
            if($aaa == 1){
               $list2[$k]['juese'] = $info['daili']; 
            }
            if($aaa == 2){
               $list2[$k]['juese'] = $info['yunyingzongjian']; 
            }
            
     }

     //三级
     foreach ($pid3 as $k => $v) {
        $list3[] = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'pid'=>$v));
     }
     foreach ($list3 as $k => $v) {
            $aaa = pdo_getcolumn('hcpdd_users',array('user_id'=>$v['user_id']),array('is_daili'));
            if($aaa == 0){
               $list3[$k]['juese'] = $set['huiyuan']; 
            }
            if($aaa == 1){
               $list3[$k]['juese'] = $info['daili']; 
            }
            if($aaa == 2){
               $list3[$k]['juese'] = $info['yunyingzongjian']; 
            }
            
     }


     $data['son1_daili_count'] = count($son1_daili);
     $data['son1_huiyuan_count'] = count($son1_huiyuan);
     $data['son1_count'] = $data['son1_daili_count'] + $data['son1_huiyuan_count'];
     $data['son2_daili_count'] = count($dpid2);
     $data['son2_huiyuan_count'] = count($hpid2);
     $data['son2_count'] = $data['son2_daili_count'] + $data['son2_huiyuan_count'];
     $data['son3_daili_count'] = count($dpid3);
     $data['son3_huiyuan_count'] = count($hpid3);
     $data['son3_count'] = $data['son3_daili_count'] + $data['son3_huiyuan_count'];


     if($info['fx_level'] == 1){
        $data['son_count'] = $data['son1_count'];
        $data['son_daili_count'] = $data['son1_daili_count'];
        $data['son_huiyuan_count'] = $data['son1_huiyuan_count'];

     }
     if($info['fx_level'] == 2){
        $data['son_count'] = $data['son1_count']+$data['son2_count'];
        $data['son_daili_count'] = $data['son1_daili_count']+$data['son2_daili_count'];
        $data['son_huiyuan_count'] = $data['son1_huiyuan_count']+$data['son2_huiyuan_count'];
     }
     if($info['fx_level'] == 3){
        $data['son_count'] = $data['son1_count']+$data['son2_count']+$data['son3_count'];
        $data['son_daili_count'] = $data['son1_daili_count']+$data['son2_daili_count']+$data['son3_daili_count'];
        $data['son_huiyuan_count'] = $data['son1_huiyuan_count']+$data['son2_huiyuan_count']+$data['son3_huiyuan_count'];
     }

     $level = $_GPC['level'];
     if($level == 1){
        $list = $list1;
     }
     if($level == 2){
        $list = $list2;
     }
     if($level == 3){
        $list = $list3;
     }
     

     return $this->result(0, '我的团队数据',array('data'=>$data,'info'=>$info,'list'=>$list));
    }
    //佣金明细
    public function doPageCorder(){
     
     global $_W,$_GPC;
     //各种设置//
     $sort = $_POST['sort'];
     $info = pdo_get('hcpdd_cset',array('uniacid'=>$_GPC['i']));
     $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));
     $set = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
     //拼多多分销订单
     if($_GPC['parameter'] == 0){
         $listall = pdo_getall('hcpdd_allorder', array('uniacid' => $_GPC['i'],'order_status >=' =>0,'order_status <'=>4), array() , '','order_create_time DESC');

         //各级各角色佣金比例
         if($user['is_daili'] == 1){
            $rate1 = $info['commission1'];
            $rate2 = $info['commission2'];
            $rate3 = $info['commission3'];
         }
         if($user['is_daili'] == 2){
            $rate1 = $info['zongjian_commission1'];
            $rate2 = $info['zongjian_commission2'];
            $rate3 = $info['zongjian_commission3'];
            $time  = pdo_getcolumn('hcpdd_orders',array('weid'=>$_GPC['i'],'uid'=>$_GPC['user_id'],'fid'=>1),array('paytime')); 
         }

         //一级下线
         $son1_daili = pdo_getall('hcpdd_users', array('fatherid' =>$_POST['user_id'],'uniacid' =>$_GPC['i'],'is_daili !='=>0));
         $son1_huiyuan = pdo_getall('hcpdd_users', array('fatherid' =>$_POST['user_id'],'uniacid' =>$_GPC['i'],'is_daili'=>0));
         $son1 = pdo_getall('hcpdd_users', array('fatherid' =>$_POST['user_id'],'uniacid' =>$_GPC['i']));

         //二级下线    
         foreach ($son1_daili as $k => $v) {
            $son2_daili[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_GPC['i'],'is_daili !='=>0));
            $son2_huiyuan[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_GPC['i'],'is_daili'=>0));       
            $son2[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_GPC['i']));
                //三级下线
                /*foreach ($son2_daili[$k] as $key => $value) {
                $son3_daili[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i'],'is_daili !='=>0));
                $son3_huiyuan[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i'],'is_daili'=>0));
                $son3[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i']));
                }*/
         }

               //一级下线
               $pid1 = array_column($son1, 'pid');

               //二级下线
                 foreach ($son2 as $k => $v) {
                    foreach ($son2[$k] as $key => $value) {
                        $pid2[] = $value['pid'];
                    }    
                 }
                 foreach ($son2_daili as $k => $v) {
                    foreach ($son2_daili[$k] as $key => $value) {
                        $userid2[] = $value;
                    }    
                 }
                 //三级下线
                 foreach ($userid2 as $key => $value) {
                    $son3_daili[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i'],'is_daili !='=>0));
                    $son3_huiyuan[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i'],'is_daili'=>0));
                    $son3[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i']));
                 } 
                 
               //三级下线    
                 foreach ($son3 as $k => $v) {
                    foreach ($son3[$k] as $key => $value) {
                        $pid3[] = $value['pid'];
                    }    
                 }
               

               foreach ($listall as $key => $value) {
                   if(in_array($value['p_id'],$pid1)){
                    $order1[] = $value;
                   }
                   if(in_array($value['p_id'],$pid2)){
                    $order2[] = $value;
                   }
                   if(in_array($value['p_id'],$pid3)){
                    $order3[] = $value;
                   }
               }


        //代理佣金明细
        //1101修改
        if($user['is_daili'] == 1){
             foreach ($order1 as $k => $v) {
                 $aaa = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));
                 if($aaa == 0){
                   $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                   $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['moneyrate']; 
                 }elseif($aaa == 1){
                   $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                   $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['daili_moneyrate']; 
                 }else{
                   $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                   $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['zongjian_moneyrate']; 
                 }                         
                 $order1[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['order_modify_at']);
                 $order1[$k]['username'] = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('nick_name'));
             }
             foreach ($order2 as $k => $v) {
                 $bbb = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));
                 if($bbb == 0){
                   $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                   $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['moneyrate']; 
                 }elseif($bbb == 1){
                   $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                   $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['daili_moneyrate']; 
                 }else{
                   $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                   $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['zongjian_moneyrate']; 
                 }            
                 $order2[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['order_modify_at']);
                 $order2[$k]['username'] = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('nick_name'));
             }
             foreach ($order3 as $k => $v) {
                 $ccc = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));
                 if($ccc == 0){
                   $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                   $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['moneyrate']; 
                 }elseif($ccc == 1){
                   $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                   $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['daili_moneyrate']; 
                 }else{
                   $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                   $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['zongjian_moneyrate']; 
                 }           
                 $order3[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['order_modify_at']);
                 $order3[$k]['username'] = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('nick_name'));
             } 
        }
         //运营总监各级下线佣金明细

         if($user['is_daili'] == 2){
            foreach ($order1 as $k => $v) {
                 $ddd = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));             
                 if($order1[$k]['order_modify_at'] > $time){
                        if($ddd == 0){
                            $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                            $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['moneyrate'];
                        }elseif($ddd == 1){
                            $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                            $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['daili_moneyrate'];
                        }else{
                            $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                            $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['zongjian_moneyrate'];
                        }                
                 }else{
                        if($ddd == 0){
                            $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                            $order1[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission1']/100*$set['moneyrate'];
                        }elseif($ddd == 1){
                            $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                            $order1[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission1']/100*$set['daili_moneyrate'];
                        }else{
                            $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                            $order1[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission1']/100*$set['zongjian_moneyrate'];
                        }
                 }
                 $order1[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['order_modify_at']);
                 $order1[$k]['username'] = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('nick_name'));
             }
             foreach ($order2 as $k => $v) {
                 $eee = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));             
                 if($order2[$k]['order_modify_at'] > $time){
                        if($eee == 0){
                            $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                            $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['moneyrate'];
                        }elseif($eee == 1){
                            $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                            $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['daili_moneyrate'];
                        }else{
                            $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                            $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['zongjian_moneyrate'];
                        }                
                 }else{
                        if($eee == 0){
                            $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                            $order2[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission2']/100*$set['moneyrate'];
                        }elseif($eee == 1){
                            $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                            $order2[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission2']/100*$set['daili_moneyrate'];
                        }else{
                            $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                            $order2[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission2']/100*$set['zongjian_moneyrate'];
                        }
                 }
                 $order2[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['order_modify_at']);
                 $order2[$k]['username'] = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('nick_name'));
             }
             foreach ($order3 as $k => $v) {
                 $fff = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));             
                 if($order3[$k]['order_modify_at'] > $time){
                        if($fff == 0){
                            $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                            $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['moneyrate'];
                        }elseif($fff == 1){
                            $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                            $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['daili_moneyrate'];
                        }else{
                            $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                            $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['zongjian_moneyrate'];
                        }                
                 }else{
                        if($fff == 0){
                            $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                            $order3[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission3']/100*$set['moneyrate'];
                        }elseif($fff == 1){
                            $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                            $order3[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission3']/100*$set['daili_moneyrate'];
                        }else{
                            $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                            $order3[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission3']/100*$set['zongjian_moneyrate'];
                        }
                 }
                 $order3[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['order_modify_at']);
                 $order3[$k]['username'] = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('nick_name'));
             }
         }

         //各级下线佣金额
         $money_count1 = array_sum(array_column($order1, 'ticheng'));   //一级下线佣金总和
         $money_count2 = array_sum(array_column($order2, 'ticheng'));   //二级下线佣金总和
         $money_count3 = array_sum(array_column($order3, 'ticheng'));   //三级下线佣金总和
     }
     //拼多多分销订单到此结束
     //蘑菇街分销订单
     if($_GPC['parameter'] == 1){

        //一级分销佣金明细
        $order1 = pdo_getall('hcpdd_mogucommission', array('uniacid' => $_GPC['i'],'level' => 1,'status' => 0,'user_id'=>$_GPC['user_id']), array() , '','addtime DESC');
        foreach ($order1 as $k => $v) {
            $order1[$k]['username'] = pdo_getcolumn('hcpdd_users',array('gid'=>$v['groupId'],'uniacid' =>$_GPC['i']),array('nick_name'));
            $order1[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['addtime']);
            $order1[$k]['order_status_desc']  = '已支付';
            $order1[$k]['ticheng']  = $v['fx_commission'];
        }
        $money_count1 = pdo_getcolumn('hcpdd_mogucommission',array('uniacid' => $_GPC['i'],'level' => 1,'status' => 0,'user_id'=>$_GPC['user_id']),array('sum(fx_commission)'));//蘑菇街预估收入

        //二级分销佣金明细
        $order2 = pdo_getall('hcpdd_mogucommission', array('uniacid' => $_GPC['i'],'level' => 2,'status' => 0,'user_id'=>$_GPC['user_id']), array() , '','addtime DESC');
        foreach ($order2 as $k => $v) {
            $order2[$k]['username'] = pdo_getcolumn('hcpdd_users',array('gid'=>$v['groupId'],'uniacid' =>$_GPC['i']),array('nick_name'));
            $order2[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['addtime']);
            $order2[$k]['order_status_desc']  = '已支付';
            $order2[$k]['ticheng']  = $v['fx_commission'];
        }
        $money_count2 = pdo_getcolumn('hcpdd_mogucommission',array('uniacid' => $_GPC['i'],'level' => 2,'status' => 0,'user_id'=>$_GPC['user_id']),array('sum(fx_commission)'));//蘑菇街预估收入

        //三级分销佣金明细
        $order3 = pdo_getall('hcpdd_mogucommission', array('uniacid' => $_GPC['i'],'level' => 3,'status' => 0,'user_id'=>$_GPC['user_id']), array() , '','addtime DESC');
        foreach ($order3 as $k => $v) {
            $order3[$k]['username'] = pdo_getcolumn('hcpdd_users',array('gid'=>$v['groupId'],'uniacid' =>$_GPC['i']),array('nick_name'));
            $order3[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['addtime']);
            $order3[$k]['order_status_desc']  = '已支付';
            $order3[$k]['ticheng']  = $v['fx_commission'];
        }
        $money_count3 = pdo_getcolumn('hcpdd_mogucommission',array('uniacid' => $_GPC['i'],'level' => 3,'status' => 0,'user_id'=>$_GPC['user_id']),array('sum(fx_commission)'));//蘑菇街预估收入
     }
     //蘑菇街分销订单结束
     //京东分销订单
     if($_GPC['parameter'] == 2){

        //一级分销佣金明细
        $order1 = pdo_getall('hcpdd_jdcommission', array('uniacid' => $_GPC['i'],'level' => 1,'status' => 0,'user_id'=>$_GPC['user_id']), array() , '','addtime DESC');
        foreach ($order1 as $k => $v) {
            $order1[$k]['username'] = pdo_getcolumn('hcpdd_users',array('positionId'=>$v['positionId'],'uniacid' =>$_GPC['i']),array('nick_name'));
            $order1[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['addtime']);
            $order1[$k]['order_status_desc']  = '已支付';
            $order1[$k]['ticheng']  = $v['fx_commission'];
        }
        $money_count1 = pdo_getcolumn('hcpdd_jdcommission',array('uniacid' => $_GPC['i'],'level' => 1,'status' => 0,'user_id'=>$_GPC['user_id']),array('sum(fx_commission)'));//蘑菇街预估收入

        //二级分销佣金明细
        $order2 = pdo_getall('hcpdd_jdcommission', array('uniacid' => $_GPC['i'],'level' => 2,'status' => 0,'user_id'=>$_GPC['user_id']), array() , '','addtime DESC');
        foreach ($order2 as $k => $v) {
            $order2[$k]['username'] = pdo_getcolumn('hcpdd_users',array('positionId'=>$v['positionId'],'uniacid' =>$_GPC['i']),array('nick_name'));
            $order2[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['addtime']);
            $order2[$k]['order_status_desc']  = '已支付';
            $order2[$k]['ticheng']  = $v['fx_commission'];
        }
        $money_count2 = pdo_getcolumn('hcpdd_jdcommission',array('uniacid' => $_GPC['i'],'level' => 2,'status' => 0,'user_id'=>$_GPC['user_id']),array('sum(fx_commission)'));//蘑菇街预估收入

        //三级分销佣金明细
        $order3 = pdo_getall('hcpdd_jdcommission', array('uniacid' => $_GPC['i'],'level' => 3,'status' => 0,'user_id'=>$_GPC['user_id']), array() , '','addtime DESC');
        foreach ($order3 as $k => $v) {
            $order3[$k]['username'] = pdo_getcolumn('hcpdd_users',array('positionId'=>$v['positionId'],'uniacid' =>$_GPC['i']),array('nick_name'));
            $order3[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['addtime']);
            $order3[$k]['order_status_desc']  = '已支付';
            $order3[$k]['ticheng']  = $v['fx_commission'];
        }
        $money_count3 = pdo_getcolumn('hcpdd_jdcommission',array('uniacid' => $_GPC['i'],'level' => 3,'status' => 0,'user_id'=>$_GPC['user_id']),array('sum(fx_commission)'));//蘑菇街预估收入
     }
     //京东分销订单结束

     
     
     
     if($sort == 1){
        $list = $order1;
     }
     if($sort == 2){
        $list = $order2;
     }
     if($sort == 3){
        $list = $order3;
     }

     
     if($info['fx_level'] == 1){
         //$menu[0] = "所有";
         $menu[1] = $info['yiji'];
         $money_count= $money_count1;
     }
     if($info['fx_level'] == 2){
         //$menu[0] = "所有";
         $menu[1] = $info['yiji'];
         $menu[2] = $info['erji'];
         $money_count= $money_count1 + $money_count2;
     }
     if($info['fx_level'] == 3){
         //$menu[0] = "所有";
         $menu[1] = $info['yiji'];
         $menu[2] = $info['erji'];
         $menu[3] = $info['sanji'];
         $money_count= $money_count1 + $money_count2 + $money_count3;
     }
     
     return $this->result(0, '各级佣金明细',array('list'=>$list,'money_count'=>$money_count,'menu'=>$menu,'time'=>$time));
    }

    public function corder($userid){


    //代理佣金明细
    if($user['is_daili'] == 1){
         foreach ($order1 as $k => $v) {
             $aaa = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));
             if($aaa == 0){
               $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
               $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['moneyrate']; 
             }elseif($aaa == 1){
               $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
               $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['daili_moneyrate']; 
             }else{
               $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
               $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['zongjian_moneyrate']; 
             }                         
             $order1[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['order_modify_at']);
             $order1[$k]['username'] = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('nick_name'));
         }
         foreach ($order2 as $k => $v) {
             $bbb = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));
             if($bbb == 0){
               $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
               $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['moneyrate']; 
             }elseif($bbb == 1){
               $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
               $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['daili_moneyrate']; 
             }else{
               $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
               $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['zongjian_moneyrate']; 
             }            
             $order2[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['order_modify_at']);
             $order2[$k]['username'] = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('nick_name'));
         }
         foreach ($order3 as $k => $v) {
             $ccc = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));
             if($ccc == 0){
               $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
               $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['moneyrate']; 
             }elseif($ccc == 1){
               $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
               $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['daili_moneyrate']; 
             }else{
               $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
               $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['zongjian_moneyrate']; 
             }           
             $order3[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['order_modify_at']);
             $order3[$k]['username'] = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('nick_name'));
         } 
    }
     //运营总监各级下线佣金明细

     if($user['is_daili'] == 2){
        foreach ($order1 as $k => $v) {
             $ddd = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));             
             if($order1[$k]['order_modify_at'] > $time){
                    if($ddd == 0){
                        $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['moneyrate'];
                    }elseif($ddd == 1){
                        $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['daili_moneyrate'];
                    }else{
                        $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['zongjian_moneyrate'];
                    }                
             }else{
                    if($ddd == 0){
                        $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission1']/100*$set['moneyrate'];
                    }elseif($ddd == 1){
                        $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission1']/100*$set['daili_moneyrate'];
                    }else{
                        $order1[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission1']/100*$set['zongjian_moneyrate'];
                    }
             }
             $order1[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['order_modify_at']);
             $order1[$k]['username'] = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('nick_name'));
         }
         foreach ($order2 as $k => $v) {
             $eee = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));             
             if($order2[$k]['order_modify_at'] > $time){
                    if($eee == 0){
                        $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['moneyrate'];
                    }elseif($eee == 1){
                        $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['daili_moneyrate'];
                    }else{
                        $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['zongjian_moneyrate'];
                    }                
             }else{
                    if($eee == 0){
                        $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission2']/100*$set['moneyrate'];
                    }elseif($eee == 1){
                        $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission2']/100*$set['daili_moneyrate'];
                    }else{
                        $order2[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission2']/100*$set['zongjian_moneyrate'];
                    }
             }
             $order2[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['order_modify_at']);
             $order2[$k]['username'] = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('nick_name'));
         }
         foreach ($order3 as $k => $v) {
             $fff = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));             
             if($order3[$k]['order_modify_at'] > $time){
                    if($fff == 0){
                        $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['moneyrate'];
                    }elseif($fff == 1){
                        $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['daili_moneyrate'];
                    }else{
                        $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['zongjian_moneyrate'];
                    }                
             }else{
                    if($fff == 0){
                        $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['moneyrate'];
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission3']/100*$set['moneyrate'];
                    }elseif($fff == 1){
                        $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission3']/100*$set['daili_moneyrate'];
                    }else{
                        $order3[$k]['promotion_amount'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission3']/100*$set['zongjian_moneyrate'];
                    }
             }
             $order3[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['order_modify_at']);
             $order3[$k]['username'] = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('nick_name'));
         }
     }  

     //各级下线佣金额
     $money_count1 = array_sum(array_column($order1, 'ticheng'));   //一级下线佣金总和
     $money_count2 = array_sum(array_column($order2, 'ticheng'));   //二级下线佣金总和
     $money_count3 = array_sum(array_column($order3, 'ticheng'));   //三级下线佣金总和
     
     
     
     
     if($sort == 1){
        $list = $order1;
     }
     if($sort == 2){
        $list = $order2;
     }
     if($sort == 3){
        $list = $order3;
     }

/*     foreach ($list as $k => $v) {
         $list[$k]['promotion_amount'] = $v['promotion_amount']/100;
         $list[$k]['order_modify_at']  = date('Y-m-d H:i:s',$v['order_modify_at']);
         $list[$k]['username'] = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('nick_name'));
     }*/
     
     if($info['fx_level'] == 1){
         //$menu[0] = "所有";
         $menu[1] = "一级";
         $money_count= $money_count1;
     }
     if($info['fx_level'] == 2){
         //$menu[0] = "所有";
         $menu[1] = "一级";
         $menu[2] = "二级";
         $money_count= $money_count1 + $money_count2;
     }
     if($info['fx_level'] == 3){
         //$menu[0] = "所有";
         $menu[1] = "一级";
         $menu[2] = "二级";
         $menu[3] = "三级";
         $money_count= $money_count1 + $money_count2 + $money_count3;
     }
     
     return $money_count;
    }
    //查询订单列表
    public function orderlist($page){
     
        global $_W,$_GPC;
        /*$info = pdo_get('hcpdd_cset',array('uniacid'=>$_GPC['i']));
        $set = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        //$p_id      = '1000318_15130197';
        $client_secret = $set['client_secret'];
        $client_id = $set['client_id'];
        $data_type = 'JSON';        
        $start_update_time = strtotime(date("Y-m-d"),time());   //今日总订单
        $end_update_time =time();       
        $timestamp = time();
        $type = 'pdd.ddk.order.list.increment.get';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'end_update_time'.$end_update_time.'page'.$page.'start_update_time'.$start_update_time.'timestamp'.$timestamp.'type'.$type.$client_secret;
        $sign = md5($signold);
        //echo $signold;
        $sign = strtoupper($sign);
        $data = array (
            'type' => urlencode('pdd.ddk.order.list.increment.get'),
            'data_type' => 'JSON',
            'page' => $page,
            'start_update_time' => $start_update_time,
            'end_update_time' => $end_update_time,
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $result = $arr['order_list_get_response']['order_list'];*/

        $result = pdo_getall('hcpdd_allorder', array('uniacid' =>$_GPC['i']));

        return $result;
    }
    //查询当日订单列表
    public function todayorderlist($page){
     
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_cset',array('uniacid'=>$_GPC['i']));
        $set = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        //$p_id      = '1000318_15130197';
        $client_secret = $set['client_secret'];
        $client_id = $set['client_id'];
        $data_type = 'JSON';        
        $start_update_time = strtotime(date("Y-m-d"),time());   //今日总订单
        $end_update_time =time();       
        $timestamp = time();
        $type = 'pdd.ddk.order.list.increment.get';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'end_update_time'.$end_update_time.'page'.$page.'start_update_time'.$start_update_time.'timestamp'.$timestamp.'type'.$type.$client_secret;
        $sign = md5($signold);
        //echo $signold;
        $sign = strtoupper($sign);
        $data = array (
            'type' => urlencode('pdd.ddk.order.list.increment.get'),
            'data_type' => 'JSON',
            'page' => $page,
            'start_update_time' => $start_update_time,
            'end_update_time' => $end_update_time,
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $result = $arr['order_list_get_response']['order_list'];

        return $result;
    }
    

    //计算实时预估收入 佣金+提成
    public function account($user_id){   
     
     global $_W,$_GPC;
     //各种设置
     $info = pdo_get('hcpdd_cset',array('uniacid'=>$_GPC['i']));
     $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$user_id));
     $set = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));

     $client_secret = $set['client_secret'];
     $client_id = $set['client_id'];
     $data_type = 'JSON';            
     $start_update_time = strtotime(date("Y-m-d"),time());   //总订单1522512000
     $end_update_time =time();       
     $timestamp = time();
     $page = 1;
     $type = 'pdd.ddk.order.list.increment.get';
     $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'end_update_time'.$end_update_time.'page'.$page.'start_update_time'.$start_update_time.'timestamp'.$timestamp.'type'.$type.$client_secret;
     $sign = md5($signold);
        //echo $signold;
     $sign = strtoupper($sign);
     $data = array (
            'type' => urlencode('pdd.ddk.order.list.increment.get'),
            'data_type' => 'JSON',
            'page' => $page,
            'start_update_time' => $start_update_time,
            'end_update_time' => $end_update_time,
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'sign' => $sign
     );
     $url = 'http://gw-api.pinduoduo.com/api/router';
     load()->func('communication');
     $response = ihttp_post($url,$data);
     $arr = json_decode($response['content'],true);
     $result = $arr['order_list_get_response']['order_list'];
     $total_count = $arr['order_list_get_response']['total_count'];
     $pagecount = ceil($total_count/100);
        
        //获取全部订单
        for ($x=1; $x<=$pagecount; $x++){            
            $list[] = $this->todayorderlist($x);
        }
        //$list = pdo_getall('hcpdd_allorder', array('uniacid' =>$_GPC['i']));
        //筛选有效订单
        foreach ($list as $k => $v){
            foreach ($list[$k] as $key => $value) {
                if($value['order_status'] >= 0 and $value['order_status']<4 ){
                    $listall[] = $value;
                }     
            }
        }


     //各级各角色佣金比例
     if($user['is_daili'] == 1){
        $rate1 = $info['commission1'];
        $rate2 = $info['commission2'];
        $rate3 = $info['commission3'];
     }
     if($user['is_daili'] == 2){ 
        $rate1 = $info['zongjian_commission1'];
        $rate2 = $info['zongjian_commission2'];
        $rate3 = $info['zongjian_commission3'];
        $time  = pdo_getcolumn('hcpdd_orders',array('weid'=>$_GPC['i'],'uid'=>$user_id,'fid'=>1),array('paytime')); 
     }

     //一级下线
     $son1_daili = pdo_getall('hcpdd_users', array('fatherid' =>$user_id,'uniacid' =>$_GPC['i'],'is_daili !='=>0));
     $son1_huiyuan = pdo_getall('hcpdd_users', array('fatherid' =>$user_id,'uniacid' =>$_GPC['i'],'is_daili'=>0));
     $son1 = pdo_getall('hcpdd_users', array('fatherid' =>$user_id,'uniacid' =>$_GPC['i']));

     //二级下线    
     foreach ($son1_daili as $k => $v){
        $son2_daili[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_GPC['i'],'is_daili !='=>0));
        $son2_huiyuan[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_GPC['i'],'is_daili'=>0));       
        $son2[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_GPC['i']));
            //三级下线
            /*foreach ($son2_daili[$k] as $key => $value){
            $son3_daili[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i'],'is_daili !='=>0));
            $son3_huiyuan[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i'],'is_daili'=>0));
            $son3[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i']));
            }*/
     }

     //一级下线
             $pid1 = array_column($son1, 'pid');

          //二级下线
            foreach ($son2 as $k => $v) {
                foreach ($son2[$k] as $key => $value) {
                    $pid2[] = $value['pid'];
                }    
            }
            foreach ($son2_daili as $k => $v) {
                foreach ($son2_daili[$k] as $key => $value) {
                    $userid2[] = $value;
                }    
            }
            //三级下线
            foreach ($userid2 as $key => $value) {
                    $son3_daili[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i'],'is_daili !='=>0));
                    $son3_huiyuan[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i'],'is_daili'=>0));
                    $son3[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i']));
            } 
             
           //三级下线    
             foreach ($son3 as $k => $v) {
                foreach ($son3[$k] as $key => $value) {
                    $pid3[] = $value['pid'];
                }    
             }
           

           foreach ($listall as $key => $value) {
               if(in_array($value['p_id'],$pid1)){
                $order1[] = $value;
               }
               if(in_array($value['p_id'],$pid2)){
                $order2[] = $value;
               }
               if(in_array($value['p_id'],$pid3)){
                $order3[] = $value;
               }
               if($value['p_id'] == $user['pid']){
                $listlist[] = $value;
               }
           }

    //分享赚自省买佣金
        foreach ($listlist as $k => $v) {
            if($v['order_status'] >= 0 and $v['order_status'] < 4){
                $order[]=$v;
            }
        }

        $dailitime  = pdo_getcolumn('hcpdd_orders',array('weid'=>$_GPC['i'],'uid'=>$user_id,'fid'=>0),array('paytime'));
        $zongjiantime  = pdo_getcolumn('hcpdd_orders',array('weid'=>$_GPC['i'],'uid'=>$user_id,'fid'=>1),array('paytime'));

        $first = pdo_getcolumn('hcpdd_moneyrate', array('uniacid' =>$_GPC['i']), 'min(edittime)'); 
        $frate = pdo_get('hcpdd_moneyrate',array('uniacid'=>$_GPC['i'],'edittime'=>$first));


        if($user['is_daili'] == 0){
                foreach ($order as $k => $v) {
                    $rate = pdo_getall('hcpdd_moneyrate', array('uniacid' =>$_GPC['i']), array() , '','edittime DESC');
                        foreach ($rate as $key => $value) {
                            $set['moneyrate'] = $frate['moneyrate'];
                            if($v['order_create_time'] > $value['edittime']){
                                $set['moneyrate'] = $value['moneyrate'];
                                break;
                            }
                        }
                    $order111[$k]['ticheng'] = $v['promotion_amount']/100*$set['moneyrate'];
            } 
        }elseif($user['is_daili'] == 1){
                foreach ($order as $k => $v) {  
                    $rate = pdo_getall('hcpdd_moneyrate', array('uniacid' =>$_GPC['i']), array() , '','edittime DESC');
                        foreach ($rate as $key => $value) {
                            $set['moneyrate'] = $frate['moneyrate'];
                            $set['daili_moneyrate'] = $frate['daili_moneyrate'];
                            if($v['order_create_time'] > $value['edittime']){
                                $set['moneyrate'] = $value['moneyrate'];
                                $set['daili_moneyrate'] = $value['daili_moneyrate'];
                                break;
                            }
                        }
                if($v['order_create_time'] < $dailitime){
                    $order111[$k]['ticheng'] = $v['promotion_amount']/100*$set['moneyrate'];
                    }else{
                    $order111[$k]['ticheng'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                    }
                }
         }else{
                foreach ($order as $k => $v) {
                    $rate = pdo_getall('hcpdd_moneyrate', array('uniacid' =>$_GPC['i']), array() , '','edittime DESC');
                        foreach ($rate as $key => $value) {
                            $set['moneyrate'] = $frate['moneyrate'];
                            $set['daili_moneyrate'] = $frate['daili_moneyrate'];
                            $set['zongjian_moneyrate'] = $frate['zongjian_moneyrate'];
                            if($v['order_create_time'] > $value['edittime']){
                                $set['moneyrate'] = $value['moneyrate'];
                                $set['daili_moneyrate'] = $value['daili_moneyrate'];
                                $set['zongjian_moneyrate'] = $value['zongjian_moneyrate'];
                                break;
                            }
                        }                           
                    if($v['order_create_time'] < $zongjiantime and $v['order_create_time'] > $dailitime){
                    $order111[$k]['ticheng'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                    }
                    elseif($v['order_create_time'] < $dailitime){
                    $order111[$k]['ticheng'] = $v['promotion_amount']/100*$set['moneyrate'];
                    }else{
                    $order111[$k]['ticheng'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                    }
                 }
         }

         $money = array_sum(array_column($order111, 'ticheng'));
  



    if($user['is_daili'] == 1){
         foreach ($order1 as $k => $v) {
             $aaa = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));
             if($aaa == 0){
               $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['moneyrate']; 
             }elseif($aaa == 1){
               $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['daili_moneyrate']; 
             }else{
               $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['zongjian_moneyrate']; 
             }                         
         }
         foreach ($order2 as $k => $v) {
             $bbb = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));
             if($bbb == 0){
               $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['moneyrate']; 
             }elseif($bbb == 1){
               $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['daili_moneyrate']; 
             }else{
               $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['zongjian_moneyrate']; 
             }            
         }
         foreach ($order3 as $k => $v) {
             $ccc = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));
             if($ccc == 0){
               $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['moneyrate']; 
             }elseif($ccc == 1){
               $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['daili_moneyrate']; 
             }else{
               $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['zongjian_moneyrate']; 
             }           
         } 
    }

     if($user['is_daili'] == 2){
        foreach ($order1 as $k => $v) {
             $ddd = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));             
             if($order1[$k]['order_modify_at'] > $time){
                    if($ddd == 0){
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['moneyrate'];
                    }elseif($ddd == 1){
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['daili_moneyrate'];
                    }else{
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['zongjian_moneyrate'];
                    }                
             }else{
                    if($ddd == 0){
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission1']/100*$set['moneyrate'];
                    }elseif($ddd == 1){
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission1']/100*$set['daili_moneyrate'];
                    }else{
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission1']/100*$set['zongjian_moneyrate'];
                    }
             }
         }
         foreach ($order2 as $k => $v) {
             $eee = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));             
             if($order2[$k]['order_modify_at'] > $time){
                    if($eee == 0){
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['moneyrate'];
                    }elseif($eee == 1){
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['daili_moneyrate'];
                    }else{
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['zongjian_moneyrate'];
                    }                
             }else{
                    if($eee == 0){
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission2']/100*$set['moneyrate'];
                    }elseif($eee == 1){
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission2']/100*$set['daili_moneyrate'];
                    }else{
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission2']/100*$set['zongjian_moneyrate'];
                    }
             }
         }
         foreach ($order3 as $k => $v) {
             $fff = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));             
             if($order3[$k]['order_modify_at'] > $time){
                    if($fff == 0){
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['moneyrate'];
                    }elseif($fff == 1){
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['daili_moneyrate'];
                    }else{
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['zongjian_moneyrate'];
                    }                
             }else{
                    if($fff == 0){
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission3']/100*$set['moneyrate'];
                    }elseif($fff == 1){
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission3']/100*$set['daili_moneyrate'];
                    }else{
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission3']/100*$set['zongjian_moneyrate'];
                    }
             }
         }
     }  

     //各级下线佣金额
     $money_count1 = array_sum(array_column($order1, 'ticheng'));   //一级下线佣金总和
     $money_count2 = array_sum(array_column($order2, 'ticheng'));   //二级下线佣金总和
     $money_count3 = array_sum(array_column($order3, 'ticheng'));   //三级下线佣金总和
         
    
     if($info['fx_level'] == 1){
         $money_count= $money_count1;
     }
     if($info['fx_level'] == 2){
         $money_count= $money_count1 + $money_count2;
     }
     if($info['fx_level'] == 3){
         $money_count= $money_count1 + $money_count2 + $money_count3;
     }

     $zong = $money_count+$money;
     
     return $zong;
    }


    //计算实时预估收入 佣金+提成
    public function history($user_id){   
     global $_W,$_GPC;
     //各种设置
     $info = pdo_get('hcpdd_cset',array('uniacid'=>$_GPC['i']));
     $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$user_id));
     $set = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
     $todaytime = strtotime(date("Y-m-d"),time());
     //$list = pdo_getall('hcpdd_allorder', array('uniacid' => $_GPC['i']));
     //筛选有效订单
        /*foreach ($list as $key => $value) {
            if($value['order_status'] >= 0 and $value['order_status']<4 ){
                $listall[] = $value;
            }     
        }*/
     $listall = pdo_getall('hcpdd_allorder', array('uniacid' =>$_GPC['i'],'order_status >=' =>0,'order_status <'=>4));

     //各级各角色佣金比例
     if($user['is_daili'] == 1){
        $rate1 = $info['commission1'];
        $rate2 = $info['commission2'];
        $rate3 = $info['commission3'];
     }
     if($user['is_daili'] == 2){ 
        $rate1 = $info['zongjian_commission1'];
        $rate2 = $info['zongjian_commission2'];
        $rate3 = $info['zongjian_commission3'];
        $time  = pdo_getcolumn('hcpdd_orders',array('weid'=>$_GPC['i'],'uid'=>$user_id,'fid'=>1),array('paytime')); 
     }

     //一级下线
     $son1_daili = pdo_getall('hcpdd_users', array('fatherid' =>$user_id,'uniacid' =>$_GPC['i'],'is_daili !='=>0));
     $son1_huiyuan = pdo_getall('hcpdd_users', array('fatherid' =>$user_id,'uniacid' =>$_GPC['i'],'is_daili'=>0));
     $son1 = pdo_getall('hcpdd_users', array('fatherid' =>$user_id,'uniacid' =>$_GPC['i']));

     //二级下线    
     foreach ($son1_daili as $k => $v){
        $son2_daili[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_GPC['i'],'is_daili !='=>0));
        $son2_huiyuan[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_GPC['i'],'is_daili'=>0));       
        $son2[$k] = pdo_getall('hcpdd_users', array('fatherid' =>$v['user_id'],'uniacid' =>$_GPC['i']));
            //三级下线
            /*foreach ($son2_daili[$k] as $key => $value){
            $son3_daili[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i'],'is_daili !='=>0));
            $son3_huiyuan[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i'],'is_daili'=>0));
            $son3[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i']));
            }*/
     }

     //一级下线
        $pid1 = array_column($son1, 'pid');

      //二级下线
        foreach ($son2 as $k => $v) {
            foreach ($son2[$k] as $key => $value) {
                $pid2[] = $value['pid'];
            }    
         }
        foreach ($son2_daili as $k => $v) {
            foreach ($son2_daili[$k] as $key => $value) {
                $userid2[] = $value;
            }    
        }
        //三级下线
        foreach ($userid2 as $key => $value) {
                $son3_daili[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i'],'is_daili !='=>0));
                $son3_huiyuan[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i'],'is_daili'=>0));
                $son3[$key] = pdo_getall('hcpdd_users', array('fatherid' =>$value['user_id'],'uniacid' =>$_GPC['i']));
        } 
         
       //三级下线    
         foreach ($son3 as $k => $v) {
            foreach ($son3[$k] as $key => $value) {
                $pid3[] = $value['pid'];
            }    
         }
           

       foreach ($listall as $key => $value) {
           if(in_array($value['p_id'],$pid1)){
            $order1[] = $value;
           }
           if(in_array($value['p_id'],$pid2)){
            $order2[] = $value;
           }
           if(in_array($value['p_id'],$pid3)){
            $order3[] = $value;
           }
           if($value['p_id'] == $user['pid']){
            $listlist[] = $value;
           }
       }


    //分享赚自省买佣金
        foreach ($listlist as $k => $v) {
            if($v['order_status'] >= 0 and $v['order_status'] < 4){
                $order[]=$v;
            }
        }

        $dailitime  = pdo_getcolumn('hcpdd_orders',array('weid'=>$_GPC['i'],'uid'=>$user_id,'fid'=>0),array('paytime'));
        $zongjiantime  = pdo_getcolumn('hcpdd_orders',array('weid'=>$_GPC['i'],'uid'=>$user_id,'fid'=>1),array('paytime'));

        $first = pdo_getcolumn('hcpdd_moneyrate', array('uniacid' =>$_GPC['i']), 'min(edittime)'); 
        $frate = pdo_get('hcpdd_moneyrate',array('uniacid'=>$_GPC['i'],'edittime'=>$first));


        if($user['is_daili'] == 0){
                foreach ($order as $k => $v) {
                    $rate = pdo_getall('hcpdd_moneyrate', array('uniacid' =>$_GPC['i']), array() , '','edittime DESC');
                        foreach ($rate as $key => $value) {
                            $set['moneyrate'] = $frate['moneyrate'];
                            if($v['order_create_time'] > $value['edittime']){
                                $set['moneyrate'] = $value['moneyrate'];
                                break;
                            }
                        }
                    $order111[$k]['ticheng'] = $v['promotion_amount']/100*$set['moneyrate'];
            } 
        }elseif($user['is_daili'] == 1){
                foreach ($order as $k => $v) {  
                    $rate = pdo_getall('hcpdd_moneyrate', array('uniacid' =>$_GPC['i']), array() , '','edittime DESC');
                        foreach ($rate as $key => $value) {
                            $set['moneyrate'] = $frate['moneyrate'];
                            $set['daili_moneyrate'] = $frate['daili_moneyrate'];
                            if($v['order_create_time'] > $value['edittime']){
                                $set['moneyrate'] = $value['moneyrate'];
                                $set['daili_moneyrate'] = $value['daili_moneyrate'];
                                break;
                            }
                        }
                if($v['order_create_time'] < $dailitime){
                    $order111[$k]['ticheng'] = $v['promotion_amount']/100*$set['moneyrate'];
                    }else{
                    $order111[$k]['ticheng'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                    }
                }
         }else{
                foreach ($order as $k => $v) {
                    $rate = pdo_getall('hcpdd_moneyrate', array('uniacid' =>$_GPC['i']), array() , '','edittime DESC');
                        foreach ($rate as $key => $value) {
                            $set['moneyrate'] = $frate['moneyrate'];
                            $set['daili_moneyrate'] = $frate['daili_moneyrate'];
                            $set['zongjian_moneyrate'] = $frate['zongjian_moneyrate'];
                            if($v['order_create_time'] > $value['edittime']){
                                $set['moneyrate'] = $value['moneyrate'];
                                $set['daili_moneyrate'] = $value['daili_moneyrate'];
                                $set['zongjian_moneyrate'] = $value['zongjian_moneyrate'];
                                break;
                            }
                        }                           
                    if($v['order_create_time'] < $zongjiantime and $v['order_create_time'] > $dailitime){
                    $order111[$k]['ticheng'] = $v['promotion_amount']/100*$set['daili_moneyrate'];
                    }
                    elseif($v['order_create_time'] < $dailitime){
                    $order111[$k]['ticheng'] = $v['promotion_amount']/100*$set['moneyrate'];
                    }else{
                    $order111[$k]['ticheng'] = $v['promotion_amount']/100*$set['zongjian_moneyrate'];
                    }
                 }
         }

         $money = array_sum(array_column($order111, 'ticheng'));
  



    if($user['is_daili'] == 1){
         foreach ($order1 as $k => $v) {
             $aaa = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));
             if($aaa == 0){
               $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['moneyrate']; 
             }elseif($aaa == 1){
               $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['daili_moneyrate']; 
             }else{
               $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['zongjian_moneyrate']; 
             }                         
         }
         foreach ($order2 as $k => $v) {
             $bbb = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));
             if($bbb == 0){
               $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['moneyrate']; 
             }elseif($bbb == 1){
               $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['daili_moneyrate']; 
             }else{
               $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['zongjian_moneyrate']; 
             }            
         }
         foreach ($order3 as $k => $v) {
             $ccc = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));
             if($ccc == 0){
               $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['moneyrate']; 
             }elseif($ccc == 1){
               $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['daili_moneyrate']; 
             }else{
               $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['zongjian_moneyrate']; 
             }           
         } 
    }

     if($user['is_daili'] == 2){
        foreach ($order1 as $k => $v) {
             $ddd = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));             
             if($order1[$k]['order_modify_at'] > $time){
                    if($ddd == 0){
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['moneyrate'];
                    }elseif($ddd == 1){
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['daili_moneyrate'];
                    }else{
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$rate1/100*$set['zongjian_moneyrate'];
                    }                
             }else{
                    if($ddd == 0){
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission1']/100*$set['moneyrate'];
                    }elseif($ddd == 1){
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission1']/100*$set['daili_moneyrate'];
                    }else{
                        $order1[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission1']/100*$set['zongjian_moneyrate'];
                    }
             }
         }
         foreach ($order2 as $k => $v) {
             $eee = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));             
             if($order2[$k]['order_modify_at'] > $time){
                    if($eee == 0){
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['moneyrate'];
                    }elseif($eee == 1){
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['daili_moneyrate'];
                    }else{
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$rate2/100*$set['zongjian_moneyrate'];
                    }                
             }else{
                    if($eee == 0){
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission2']/100*$set['moneyrate'];
                    }elseif($eee == 1){
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission2']/100*$set['daili_moneyrate'];
                    }else{
                        $order2[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission2']/100*$set['zongjian_moneyrate'];
                    }
             }
         }
         foreach ($order3 as $k => $v) {
             $fff = pdo_getcolumn('hcpdd_users',array('pid'=>$v['p_id'],'uniacid' =>$_GPC['i']),array('is_daili'));             
             if($order3[$k]['order_modify_at'] > $time){
                    if($fff == 0){
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['moneyrate'];
                    }elseif($fff == 1){
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['daili_moneyrate'];
                    }else{
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$rate3/100*$set['zongjian_moneyrate'];
                    }                
             }else{
                    if($fff == 0){
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission3']/100*$set['moneyrate'];
                    }elseif($fff == 1){
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission3']/100*$set['daili_moneyrate'];
                    }else{
                        $order3[$k]['ticheng'] = $v['promotion_amount']/100*$info['commission3']/100*$set['zongjian_moneyrate'];
                    }
             }
         }
     }  

     //各级下线佣金额
     $money_count1 = array_sum(array_column($order1, 'ticheng'));   //一级下线佣金总和
     $money_count2 = array_sum(array_column($order2, 'ticheng'));   //二级下线佣金总和
     $money_count3 = array_sum(array_column($order3, 'ticheng'));   //三级下线佣金总和
         
    
     if($info['fx_level'] == 1){
         $money_count= $money_count1;
     }
     if($info['fx_level'] == 2){
         $money_count= $money_count1 + $money_count2;
     }
     if($info['fx_level'] == 3){
         $money_count= $money_count1 + $money_count2 + $money_count3;
     }

     //$zong = $money_count+$money;
     $zong['zisheng'] = $money;
     $zong['fenxiao'] = $money_count;

     return $zong;
    }

    /*public function Ordermoneydetail($p_id)
    {
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        //$p_id      = '1000318_15130197';
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';        
        $start_update_time = '1522512000';   //总订单
        $end_update_time =time();       
        $timestamp = time();
        $type = 'pdd.ddk.order.list.increment.get';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'end_update_time'.$end_update_time.'p_id'.$p_id.'start_update_time'.$start_update_time.'timestamp'.$timestamp.'type'.$type.$client_secret;
        $sign = md5($signold);
        //echo $signold;
        $sign = strtoupper($sign);
        $data = array (
            'type' => urlencode('pdd.ddk.order.list.increment.get'),
            'data_type' => 'JSON',
            'p_id' => $p_id,
            'start_update_time' => $start_update_time,
            'end_update_time' => $end_update_time,
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $result = $arr['order_list_get_response']['order_list'];


           return $result; 

        
    }*/

    /*public function ordercount($p_id,$status)
    {
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';
        if($status == 1){
            $start_update_time =time()-86400;    //过去24小时
            $end_update_time =time();
        }elseif($status == 0)
        {
            $start_update_time =time()-172800;   //过去48小时
            $end_update_time =time();
        }else{
            $start_update_time = '1522512000';   //总订单
            $end_update_time =time();
        }       
        $timestamp = time();
        $type = 'pdd.ddk.order.list.increment.get';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'end_update_time'.$end_update_time.'p_id'.$p_id.'start_update_time'.$start_update_time.'timestamp'.$timestamp.'type'.$type.$client_secret;
        $sign = md5($signold);
        //echo $signold;
        $sign = strtoupper($sign);
        $data = array (
            'type' => urlencode('pdd.ddk.order.list.increment.get'),
            'data_type' => 'JSON',
            'p_id' => $p_id,
            'start_update_time' => $start_update_time,
            'end_update_time' => $end_update_time,
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $result = $arr['order_list_get_response']['total_count']; 

        return $result;
    }*/

    /*public function ordermoney($p_id)
    {
        global $_W,$_GPC;
        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        //$p_id      = '1000318_15130197';
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';        
        $start_update_time = '1522512000';   //总订单
        $end_update_time =time();       
        $timestamp = time();
        $type = 'pdd.ddk.order.list.increment.get';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'end_update_time'.$end_update_time.'p_id'.$p_id.'start_update_time'.$start_update_time.'timestamp'.$timestamp.'type'.$type.$client_secret;
        $sign = md5($signold);
        //echo $signold;
        $sign = strtoupper($sign);
        $data = array (
            'type' => urlencode('pdd.ddk.order.list.increment.get'),
            'data_type' => 'JSON',
            'p_id' => $p_id,
            'start_update_time' => $start_update_time,
            'end_update_time' => $end_update_time,
            'timestamp' => urlencode($timestamp),
            'client_id' => $client_id,
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $result = $arr['order_list_get_response']['order_list']; 

        
        $sum = array_sum(array_column($result, 'promotion_amount'))/100;
        //var_dump($sum);
        return $sum;
    }*/

    public function doPagePay() {
        global $_GPC, $_W;
        $uid = $_GPC['user_id'];
        $fid = $_GPC['fid'];
        $weid= $_GPC['i'];
        //查询当前商品价格
        if($fid == 0){
            $price = pdo_getcolumn('hcpdd_cset',array('uniacid'=>$weid),array('dailifei'));
        }else{
            $price = pdo_getcolumn('hcpdd_cset',array('uniacid'=>$weid),array('zongjianfei'));
        }
        

        $data = array(
            'weid' => $weid,
            'uid'  => $uid,
            'fid'  => $fid,
            'fee'      => $price,
            'ordersn'  => date('YmdHis').time().rand(100000,999999),
            'status'   => 1,
            'createtime'=>time()
        );
        $res = pdo_insert('hcpdd_orders',$data);
        if(!empty($res)){
            $oid = pdo_insertid();
            $pay_params = $this->payment($oid);
            if (is_error($pay_params)) {
                return $this->result(1, '支付失败，请重试');
            }
            return $this->result(0, '', $pay_params);
        }else{
            return $this->result(1, '操作失败');
        }
    }
    /**
     * 调起微信支付
     */
    public function payment($order_id){
        global $_GPC, $_W;
        $weid = $_GPC['i'];
        load()->model('payment');
        load()->model('account');
        $setting = uni_setting($weid, array('payment'));
        $wechat_payment = array(
            'appid'   => $_W['account']['key'],
            'signkey' => $setting['payment']['wechat']['signkey'],
            'mchid'   => $setting['payment']['wechat']['mchid'],
        );
        //echo "<pre>";print_r($wechat_payment);die;
        $order  = pdo_get('hcpdd_orders',array('id'=>$order_id,'weid'=>$weid));

        $openid = pdo_getcolumn('hcpdd_users',array('user_id'=>$order['uid']),array('open_id'));
        //返回小程序参数
        $notify_url = $_W['siteroot'].'addons/hc_pdd/wxpay.php';
        $res = $this->getPrePayOrder($wechat_payment,$notify_url,$order,$openid);
        //echo "<pre>";print_r($res);die;
        if($res['return_code']=='FAIL'){
            return $this->result(1, '操作失败',$res['return_msg']);
        }
        if($res['result_code']=='FAIL'){
            return $this->result(1, '操作失败',$res['err_code'].$res['err_code_des']);
        }

        if($res['return_code']=='SUCCESS'){
            $wxdata = $this->getOrder($res['prepay_id'],$wechat_payment);
            //echo "<pre>";print_r($wxdata);
            pdo_update('hcpdd_orders', array('package'=>$res['prepay_id']), array('id'=>$order_id));

            return $this->result(0, '操作成功',$wxdata);
        }else{
            return $this->result(1, '操作失败');
        }
    }
    //微信统一支付
    public function getPrePayOrder($wechat_payment,$notify_url,$order,$openid){
        $model = new HcfkModel();
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        
        $data["appid"] = $wechat_payment['appid'];
        $data["body"] = $order['ordersn'];
        $data["mch_id"] = $wechat_payment['mchid'];
        $data["nonce_str"] = $model->getRandChar(32);
        $data["notify_url"] = $notify_url;
        $data["out_trade_no"] = $order['ordersn'];
        $data["spbill_create_ip"] = $model->get_client_ip();
        $data["total_fee"] = $order['fee']*100;
        $data["trade_type"] = "JSAPI";
        $data["openid"] = $openid;
        $data["sign"] = $model->getSign($data,$wechat_payment['signkey']);
    
        $xml = $model->arrayToXml($data);
        $response = $model->postXmlCurl($xml, $url);
        return $model->xmlstr_to_array($response);
    }
    
    // 执行第二次签名，才能返回给客户端使用
    public function getOrder($prepayId,$wechat_payment){
        $model = new HcfkModel();
        $data["appId"] = $wechat_payment['appid'];
        $data["nonceStr"] = $model->getRandChar(32);
        $data["package"] = "prepay_id=".$prepayId;
        $data['signType'] = "MD5";
        $data["timeStamp"] = time();
        $data["sign"] = $model->getSign1($data,$wechat_payment['signkey']);
        return $data;
    }
    public function doPageCreateShareposter(){
        global $_GPC, $_W;
        $imgid = $_POST['imgid'];
        ob_end_clean(); 
        if($imgid ==0){
            $url = $_W['siteroot']."addons/hc_pdd/template/poster/poster1.png";
        }
        if($imgid ==1){
            $url = $_W['siteroot']."addons/hc_pdd/template/poster/poster2.png";
        }
        if($imgid ==2){
            $url = $_W['siteroot']."addons/hc_pdd/template/poster/poster3.png";
        }       
        return $this->result(0, '海报',$url);
    }
    //获取用户手机号
    public function doPageGetsessionkey(){
        global $_GPC, $_W;

        $code = $_GPC['code'];
        $account = pdo_get('account_wxapp', array('uniacid' => $_GPC['i']));
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $account['key'] . '&secret=' . $account['secret'] . '&js_code=' . $code . '&grant_type=authorization_code';
        $result = $this->get_url_content($url);
        $result = json_decode($result, true);
        
        return $this->result(0, '操作成功',$result);

    }

    public function doPageUsermobile(){
        global $_GPC, $_W;

        $uid           = $_GPC['user_id'];
        $encryptedData = $_GPC['encryptedData'];
        $iv            = $_GPC['iv'];
        $sessionKey    = $_GPC['session_key'];
        $appid = $_W['account']['key'];
        $pc = new WXBizDataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data);
        if ($errCode == 0) {
            $phone = json_decode($data,'true');
            pdo_update('hcpdd_users',array('mobile'=>$phone['phoneNumber']),array('user_id'=>$uid));
            return $this->result(0, '操作成功',$phone);
        } else {
            return $this->result(1, array('errcode'=>$errCode,'appid'=>$appid));
        }

    }

    public function doPageShareposter(){
        ob_end_clean();
        ob_clean();
        global $_W,$_GPC;
        $imgid = $_POST['imgid'];
        $userid = $_POST['user_id']; 
        $info = pdo_get('hcpdd_cset',array('uniacid'=>$_GPC['i']));
        if($imgid == 0){
           $dst_path = $_W['attachurl'].$info['inviteposter1'];//背景图 
        }   
        if($imgid == 1){
           $dst_path = $_W['attachurl'].$info['inviteposter2'];//背景图 
        }
        if($imgid == 2){
           $dst_path = $_W['attachurl'].$info['inviteposter3'];//背景图 
        }    
        
        //qr_path = $_W['siteroot']."addons/hc_pdd/erweima.png";//小程序码
        $qr_path = $this->CreateQrcode($userid);
        //$qr_path = $this->GetQrcode($goods_id,$user_id);//小程序码
        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        $qr = imagecreatefromstring(file_get_contents($qr_path));       
        //获取水印图片的宽高
        list($qr_w, $qr_h) = getimagesize($qr_path);
        $new_x = 150;
        $new_y = 150;
        $image_p = imagecreatetruecolor($new_x, $new_y); //设置缩略图
        imagecopyresampled($image_p, $qr, 0, 0, 0, 0, $new_x, $new_y, $qr_w, $qr_h);
        imagecopymerge($dst,$image_p,144,560,0,0,$new_x,$new_y,100);
        //输出图片
  
        if($imgid ==0){
            $filename = dirname(__FILE__)."/template/poster/poster1.png";
        }
        if($imgid ==1){
            $filename = dirname(__FILE__)."/template/poster/poster2.png";
        }
        if($imgid ==2){
            $filename = dirname(__FILE__)."/template/poster/poster3.png";
        }    
        imagepng($dst,$filename);
        imagedestroy($dst);
    }
    //红包树海报
    public function doPageTreeposter(){
        ob_end_clean();
        ob_clean();
        global $_W,$_GPC;  
        $set = pdo_get('hcpdd_set', array('uniacid' => $_W['uniacid'])); 
        $user_id = $_POST['user_id'];
        $hb_id = $_POST['hb_id'];
        $avatarUrl = $_POST['avatarUrl'];
        $nickName = $_POST['nickName'];    
        if(empty($set['treeposter'])){
           $dst_path = $_W['siteroot']."addons/hc_pdd/tree.png";//背景图
        }else{
           $dst_path = tomedia($set['treeposter']);//背景图 
        }   
        
        //$qr_path = $_W['siteroot']."addons/hc_pdd/yaoqing.png";//背景图
        $qr_path = $this->CreateTreeqrcode($user_id,$hb_id,$avatarUrl,$nickName);//小程序码
        //创建图片的实例
        $dst = imagecreatefromstring(file_get_contents($dst_path));
        $qr = imagecreatefromstring(file_get_contents($qr_path));

        //获取水印图片的宽高
        list($qr_w, $qr_h) = getimagesize($qr_path);
        $new_x = 150;
        $new_y = 150;
        $image_p = imagecreatetruecolor($new_x, $new_y); //设置缩略图
        imagecopyresampled($image_p, $qr, 0, 0, 0, 0, $new_x, $new_y, $qr_w, $qr_h);
        imagecopymerge($dst,$image_p,337,950,0,0,$new_x,$new_y,100);
        //输出图片
        list($dst_w, $dst_h, $dst_type) = getimagesize($dst_path);
        switch ($dst_type) {
        case 1://GIF
           //header('Content-Type: image/gif');
           imagegif($dst);
           break;
        case 2://JPG
           //header('Content-Type: image/jpeg');
           imagejpeg($dst);
           break;
        case 3://PNG
           //header('Content-Type: image/png');          
           imagepng($dst);
           break;
        default:
           break;
        }
        
        $filename = dirname(__FILE__)."/template/poster/treeposter.png";
        imagepng($dst,$filename);
        imagedestroy($dst);
    }
    //邀请好友小程序码
    public function CreateQrcode($user_id){
        global $_GPC, $_W;
        // 获取access_token
        //$accessTokenObject = json_decode(file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$_W['account']['key'].'&secret='.$_W['account']['secret']));
        //二维码接口
        //$url="https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".$accessTokenObject->access_token;
        //菊花码
        //$url = "https://api.weixin.qq.com/wxa/getwxacode?access_token=".$accessTokenObject->access_token;
        $token = $this->getToken();
        $url = "https://api.weixin.qq.com/wxa/getwxacode?access_token=".$token;
        //$goods_id = '447250186';
        $width = '430';
        $path = '/hc_pdd/pages/yaoqing/yaoqing?user_id='.$user_id;
        $json='{"path":"'.$path.'","width":'.$width.'}';
        //$json = '{"scene": "/user_id/'.$user_id.'", "width": 50, "page": ""}';
        //$data=$this->api_notice_increment($url,$json);
        $data=$this->request_post($url,$json);
        $filename = dirname(__FILE__)."/yaoqing.png";
        $local_file = fopen($filename, 'w');
        if (false !== $local_file) {
            if (false !== fwrite($local_file, $data)) {
                fclose($local_file);
            }
        }
        //file_put_contents($filename,$data);
        return $_W['siteroot']."addons/hc_pdd/yaoqing.png";
    }

    //红包树发红包二维码
    public function CreateTreeqrcode($user_id,$hb_id,$avatarUrl,$nickName){
        global $_GPC, $_W;
        // 获取access_token
        //$accessTokenObject = json_decode(file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$_W['account']['key'].'&secret='.$_W['account']['secret']));
        //二维码接口
        //$url="https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".$accessTokenObject->access_token;
        //菊花码
        //$url = "https://api.weixin.qq.com/wxa/getwxacode?access_token=".$accessTokenObject->access_token;
        //$goods_id = '447250186';
        $token = $this->getToken();
        $url = "https://api.weixin.qq.com/wxa/getwxacode?access_token=".$token;
        $width = '430';
        //$path = 'hc_pdd/component/pages/redbag/redbag?outuser_id='.$user_id.'&hb_id='.$hb_id.'&avatarUrl='.$avatarUrl.'&nickName='.$nickName;
        $path = 'hc_pdd/component/pages/redbag/redbag?outuser_id='.$user_id.'&hb_id='.$hb_id;
        $json='{"path":"'.$path.'","width":'.$width.'}';
        //$json = '{"scene": "/user_id/'.$user_id.'", "width": 50, "page": ""}';
        //$data=$this->api_notice_increment($url,$json);
        $data=$this->request_post($url,$json);
        $filename = dirname(__FILE__)."/treeqrcode.png";
        $local_file = fopen($filename, 'w');
        if (false !== $local_file) {
            if (false !== fwrite($local_file, $data)) {
                fclose($local_file);
            }
        }
        //file_put_contents($filename,$data);
        return $_W['siteroot']."addons/hc_pdd/treeqrcode.png";
    }

    //邀请好友小程序码
    public function doPageSaveqrcode(){
        global $_GPC, $_W;
        $user_id = $_GPC['user_id'];
        // 获取access_token
        //$accessTokenObject = json_decode(file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$_W['account']['key'].'&secret='.$_W['account']['secret']));
        //二维码接口
        //$url="https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=".$accessTokenObject->access_token;
        //菊花码
        //$url = "https://api.weixin.qq.com/wxa/getwxacode?access_token=".$accessTokenObject->access_token;
        //$goods_id = '447250186';
        $token = $this->getToken();
        $url = "https://api.weixin.qq.com/wxa/getwxacode?access_token=".$token;
        $width = '430';
        $path = '/hc_pdd/pages/yaoqing/yaoqing?user_id='.$user_id;
        $json='{"path":"'.$path.'","width":'.$width.'}';
        //$json = '{"scene": "/user_id/'.$user_id.'", "width": 50, "page": ""}';
        //$data=$this->api_notice_increment($url,$json);
        $data=$this->request_post($url,$json);
        $filename = dirname(__FILE__)."/yaoqing.png";
        $local_file = fopen($filename, 'w');
        if (false !== $local_file) {
            if (false !== fwrite($local_file, $data)) {
                fclose($local_file);
            }
        }
        //file_put_contents($filename,$data);
    }

    //红包商品列表
    public function doPageHongbaolist(){

        global $_GPC, $_W;
        
        $hb = pdo_get('hcpdd_hongbao',array('uniacid'=>$_GPC['i']));
        //$log = pdo_get('hcpdd_hblog',array('uniacid'=>$_GPC['i']));
        

        $time=date('Y-m-d',time());
        $hhh = pdo_get('hcpdd_hblog', array('hongbaotime'=>$time,'uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));
        $hb['status'] = $hhh['status'];

        $hb['start_time'] = $hhh['s_time'];
        $hb['end_time'] = $hhh['e_time'];

        if(empty($hb['open_bg'])){
            $hb['open_bg']='';           
        }elseif(strpos($hb['open_bg'],'https') !== false){
            $hb['open_bg'] = $hb['open_bg'];
        }else{
            $hb['open_bg'] = $_W['attachurl'].$hb['open_bg'];
        }
        if(empty($hb['fenxiangpic'])){
            $hb['fenxiangpic']='';           
        }elseif(strpos($hb['fenxiangpic'],'https') !== false){
            $hb['fenxiangpic'] = $hb['fenxiangpic'];
        }else{
            $hb['fenxiangpic'] = $_W['attachurl'].$hb['fenxiangpic'];
        }
        
        $user_id = $_GPC['user_id'];
        $user = pdo_get('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));
        $pageNum = $_POST['pageNum'];     //页数
        if(empty($pageNum)){
            $pageNum = 0;
        }
        $sort_type = 0;

        $hbmoney = $_GPC['hbmoney'];
        $hongbao = $hbmoney*100;

        $range_list = '[{"range_id":3,"range_from":'.$hongbao.',"range_to":'.$hongbao.'}]'; //大额券
        
        $page=1+$pageNum;
        $page = max(intval($page), 1);



        $info = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $client_secret = $info['client_secret'];
        $client_id = $info['client_id'];
        $data_type = 'JSON';
        $timestamp = time();
        $type = 'pdd.ddk.goods.search';
        $signold = $client_secret.'client_id'.$client_id.'data_type'.$data_type.'page'.$page.'page_size20range_list'.$range_list.'sort_type'.$sort_type.'timestamp'.$timestamp.'type'.$type.'with_couponfalse'.$client_secret;
        $sign = md5($signold);
        $sign = strtoupper($sign);

        //echo $sign;
        $data = array (
            'type' => urlencode('pdd.ddk.goods.search'),
            'data_type' => 'JSON',
            'timestamp' => urlencode($timestamp),
            'range_list'=> $range_list,
            'client_id' => $client_id,
            'page'      => $page,
            'page_size' => '20',
            'sort_type' => $sort_type,
            'with_coupon' => 'false',
            'sign' => $sign
        );
        $url = 'http://gw-api.pinduoduo.com/api/router';
        load()->func('communication');
        $response = ihttp_post($url,$data);
        $arr = json_decode($response['content'],true);
        $list = $arr['goods_search_response']['goods_list'];

        foreach ($list as $k => $v) {
            $list[$k]['min_normal_price'] = $v['min_normal_price'] / 100;//最低单买价
            $list[$k]['min_group_price']  = $v['min_group_price']  / 100;//最低拼团价，原价
            $list[$k]['coupon_discount']  = $v['coupon_discount']  / 100;//优惠券面额
            $list[$k]['now_price']        = ($v['min_group_price'] - $v['coupon_discount'])/100;//现价
            $list[$k]['sold_quantity']    = $v['sales_tip'];   //销量
        }
        
        $this->result(0, '红包列表',array('list'=>$list,'hongbao'=>$hb));
        
  
    }

    //记录红包开启的次数
    public function doPageHblog(){

        global $_GPC, $_W;
        
        $data['uniacid'] = $_GPC['i'];
        $data['user_id'] = $_GPC['user_id'];
        $data['hongbaotime'] = date('Y-m-d',time());
        $data['s_time'] = time();
        $data['e_time'] = time() + 7200;
        $data['status'] = 0;

        $time=date('Y-m-d',time());
        
        $hb = pdo_get('hcpdd_hblog', array('hongbaotime'=>$time,'uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));

        if(empty($hb)){
           $result = pdo_insert('hcpdd_hblog', $data); 
        }
        

        $this->result(0, '红包记录',$result);
          
    }

    //红包树列表
    public function doPageTreelist(){

        global $_GPC, $_W;

        $tree[0] = array('0'=>array(1,2,3),'1'=>array(4,5,6),'2'=>array(7,8,9));
        $tree[1] = array('0'=>array(10,11,12),'1'=>array(13,14,15),'2'=>array(16,17,18),'3'=>array(19,20,21),'4'=>array(22,23,24));
        $tree[2] = array('0'=>array(25,26,27),'1'=>array(28,29,30),'2'=>array(31,32,33),'3'=>array(34,35,36),'4'=>array(37,38,39));
        $tree[3] = array('0'=>array(40,41,42),'1'=>array(43,44,45),'2'=>array(46,47,48),'3'=>array(49,50,51),'4'=>array(52,53,54));
        $tree[4] = array('0'=>array(55,56,57),'1'=>array(58,59,60),'2'=>array(61,62,63),'3'=>array(64,65,66),'4'=>array(67,68,69));
        $tree[5] = array('0'=>array(70,71,72),'1'=>array(73,74,75),'2'=>array(76,77,78),'3'=>array(79,80,81),'4'=>array(82,83,84));
        $tree[6] = array('0'=>array(85,86,87),'1'=>array(88,89,90),'2'=>array(91,92,93),'3'=>array(94,95,96),'4'=>array(97,98,99));

        foreach($tree[0] as $key => $value){
            foreach ($tree[0][$key] as $k => $v){
                $list[0][$key][$k]['id'] = $v;
                $aaa = pdo_get('hcpdd_treelog', array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id'],'hb_id'=>$v));
                if(!empty($aaa)){
                  $list[0][$key][$k]['status'] = 1; //已经开过
                  $son = pdo_get('hcpdd_users', array('uniacid'=>$_GPC['i'],'user_id'=>$aaa['son_id']));
                  $list[0][$key][$k]['head_pic'] = $son['head_pic']; //已经开过
                  $list[0][$key][$k]['nick_name'] = $son['nick_name']; //已经开过
                  $list[0][$key][$k]['hbmoney'] = $aaa['hbmoney']; //已经开过
                }else{
                  $list[0][$key][$k]['status'] = 0; //没开过
                }            
            }
        }
        foreach($tree[1] as $key => $value){
            foreach ($tree[1][$key] as $k => $v){
                $list[1][$key][$k]['id'] = $v;
                $aaa = pdo_get('hcpdd_treelog', array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id'],'hb_id'=>$v));
                if(!empty($aaa)){
                  $list[1][$key][$k]['status'] = 1; //已经开过
                  $son = pdo_get('hcpdd_users', array('uniacid'=>$_GPC['i'],'user_id'=>$aaa['son_id']));
                  $list[1][$key][$k]['head_pic'] = $son['head_pic']; //已经开过
                  $list[1][$key][$k]['nick_name'] = $son['nick_name']; //已经开过
                  $list[1][$key][$k]['hbmoney'] = $aaa['hbmoney']; //已经开过
                }else{
                  $list[1][$key][$k]['status'] = 0; //没开过
                }            
            }
        }
        foreach($tree[2] as $key => $value){
            foreach ($tree[2][$key] as $k => $v){
                $list[2][$key][$k]['id'] = $v;
                $aaa = pdo_get('hcpdd_treelog', array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id'],'hb_id'=>$v));
                if(!empty($aaa)){
                  $list[2][$key][$k]['status'] = 1; //已经开过
                  $son = pdo_get('hcpdd_users', array('uniacid'=>$_GPC['i'],'user_id'=>$aaa['son_id']));
                  $list[2][$key][$k]['head_pic'] = $son['head_pic']; //已经开过
                  $list[2][$key][$k]['nick_name'] = $son['nick_name']; //已经开过
                  $list[2][$key][$k]['hbmoney'] = $aaa['hbmoney']; //已经开过
                }else{
                  $list[2][$key][$k]['status'] = 0; //没开过
                }            
            }
        }
        foreach($tree[3] as $key => $value){
            foreach ($tree[3][$key] as $k => $v){
                $list[3][$key][$k]['id'] = $v;
                $aaa = pdo_get('hcpdd_treelog', array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id'],'hb_id'=>$v));
                if(!empty($aaa)){
                  $list[3][$key][$k]['status'] = 1; //已经开过
                  $son = pdo_get('hcpdd_users', array('uniacid'=>$_GPC['i'],'user_id'=>$aaa['son_id']));
                  $list[3][$key][$k]['head_pic'] = $son['head_pic']; //已经开过
                  $list[3][$key][$k]['nick_name'] = $son['nick_name']; //已经开过
                  $list[3][$key][$k]['hbmoney'] = $aaa['hbmoney']; //已经开过
                }else{
                  $list[3][$key][$k]['status'] = 0; //没开过
                }            
            }
        }
        foreach($tree[4] as $key => $value){
            foreach ($tree[4][$key] as $k => $v){
                $list[4][$key][$k]['id'] = $v;
                $aaa = pdo_get('hcpdd_treelog', array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id'],'hb_id'=>$v));
                if(!empty($aaa)){
                  $son = pdo_get('hcpdd_users', array('uniacid'=>$_GPC['i'],'user_id'=>$aaa['son_id']));
                  $list[4][$key][$k]['status'] = 1; //已经开过
                  $list[4][$key][$k]['head_pic'] = $son['head_pic']; //已经开过
                  $list[4][$key][$k]['nick_name'] = $son['nick_name']; //已经开过
                  $list[4][$key][$k]['hbmoney'] = $aaa['hbmoney']; //已经开过
                }else{
                  $list[4][$key][$k]['status'] = 0; //没开过
                }            
            }
        }
        foreach($tree[5] as $key => $value){
            foreach ($tree[5][$key] as $k => $v){
                $list[5][$key][$k]['id'] = $v;
                $aaa = pdo_get('hcpdd_treelog', array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id'],'hb_id'=>$v));
                if(!empty($aaa)){
                  $list[5][$key][$k]['status'] = 1; //已经开过
                  $son = pdo_get('hcpdd_users', array('uniacid'=>$_GPC['i'],'user_id'=>$aaa['son_id']));
                  $list[5][$key][$k]['head_pic'] = $son['head_pic']; //已经开过
                  $list[5][$key][$k]['nick_name'] = $son['nick_name']; //已经开过
                  $list[5][$key][$k]['hbmoney'] = $aaa['hbmoney']; //已经开过
                }else{
                  $list[5][$key][$k]['status'] = 0; //没开过
                }            
            }
        }
        foreach($tree[6] as $key => $value){
            foreach ($tree[6][$key] as $k => $v){
                $list[6][$key][$k]['id'] = $v;
                $aaa = pdo_get('hcpdd_treelog', array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id'],'hb_id'=>$v));
                if(!empty($aaa)){
                  $list[6][$key][$k]['status'] = 1; //已经开过
                  $son = pdo_get('hcpdd_users', array('uniacid'=>$_GPC['i'],'user_id'=>$aaa['son_id']));
                  $list[6][$key][$k]['head_pic'] = $son['head_pic']; //已经开过
                  $list[6][$key][$k]['nick_name'] = $son['nick_name']; //已经开过
                  $list[6][$key][$k]['hbmoney'] = $aaa['hbmoney']; //已经开过
                }else{
                  $list[6][$key][$k]['status'] = 0; //没开过
                }            
            }
        }

        $treelist = pdo_getall('hcpdd_treelog', array('uniacid' => $_GPC['i'],'user_id'=>$_GPC['user_id']), array(),'','id asc');
        $data['treenum'] = count($treelist);
        $data['treeall'] = array_sum(array_column($treelist,'hbmoney'));
         
        $this->result(0, '红包记录',array('data'=>$list,'res'=>$data));
          
    }

    //接收红包是否已转发
    public function doPageHbzhuanfa(){

        global $_GPC, $_W;
        
        if($_GPC['zhuanfa']){
          $data['user_id'] = $_GPC['user_id'];
          $data['status'] = 1;  
          $result = pdo_update('hcpdd_hblog', $data, array('user_id' => $data['user_id']));
        }

        $this->result(0, '是否转发',$result);
          
    }

    //我的红包
    public function doPageMyhongbao(){
        
        global $_GPC, $_W;  
        $time=date('Y-m-d',time());
        $hb = pdo_get('hcpdd_hblog', array('hongbaotime'=>$time,'uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id']));
        
        if(empty($hb)){
           $this->result(1, '未领取红包'); 
        }elseif(time() > $hb['e_time']){
           $this->result(1, '红包已过期'); 
        }else{
          $this->result(0, '我的红包',$hb);  
        }           
    
    }

    //首页变色框
    public function doPageIndexcolorbox(){

        global $_GPC, $_W;
        $list = array();
        $set = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $info = pdo_get('hcpdd_theme', array('uniacid' => $_GPC['i']));
        if($set['is_kouhong'] == 1){
            if(empty($set['kouhong_pic'])){
                $list[0]['pic'] = $_W['siteroot']."addons/hc_pdd/template/img/kouhong.png"; 
            }else{
                $list[0]['pic'] = tomedia($set['kouhong_pic']); 
            }       
            $list[0]['type'] = 1;  //口红
            if(empty($set['kouhong_color'])){
                $list[0]['color'] = "#ff0080"; 
            }else{
                $list[0]['color'] = $set['kouhong_color']; 
            } 
            
            if(empty($info['banner'])){
                $list[1]['pic'] = $_W['siteroot']."addons/hc_pdd/template/img/resou.png"; 
            }else{
                $list[1]['pic'] = tomedia($info['banner']); 
            } 
            $list[1]['type'] = 2;  //热搜
            if(empty($info['zhuti_color'])){
                $list[1]['color'] = "#8600ff"; 
            }else{
                $list[1]['color'] = $info['zhuti_color']; 
            }
        }else{
            if(empty($info['banner'])){
                $list[0]['pic'] = $_W['siteroot']."addons/hc_pdd/template/img/resou.png"; 
            }else{
                $list[0]['pic'] = tomedia($info['banner']); 
            } 
            $list[0]['type'] = 2;  //热搜
            if(empty($info['zhuti_color'])){
                $list[0]['color'] = "#8600ff"; 
            }else{
                $list[0]['color'] = $info['zhuti_color']; 
            }
        }
        
        
        $this->result(0, '首页变色盒',$list);         
    }

    //口红奖品展示
    public function doPageKouhonglist(){

        global $_GPC, $_W;
        $set = pdo_get('hcpdd_set',array('uniacid'=>$_GPC['i']));
        $set['kouhong_sharepic'] = tomedia($set['kouhong_sharepic']);     
        $kouhong = $set['kouhong_ids'];
        if(!empty($kouhong)){
            $kouhong = explode(",",$kouhong);
            foreach ($kouhong as $k => $v){
                $list[$k] = $this->singlegoods($v,$user_id);
            }
        }

        $time=date('Y-m-d',time()); 
        $log = pdo_get('hcpdd_kouhonglog', array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id'],'createday'=>$time));
        $invite = $log['invite_id'];
        $res = explode(",",$invite);
        /*foreach ($res as $k => $v) {
            $peoplelist[$k] = pdo_getcolumn('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$v),array('head_pic'));
        }*/
        if(!empty($res[0])){
            $peoplelist[0] = pdo_getcolumn('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$res[0]),array('head_pic'));
        }else{
            $peoplelist[0] = "";
        }
        if(!empty($res[1])){
            $peoplelist[1] = pdo_getcolumn('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$res[1]),array('head_pic'));
        }else{
            $peoplelist[1] = "";
        }
        if(!empty($res[2])){
            $peoplelist[2] = pdo_getcolumn('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$res[2]),array('head_pic'));
        }else{
            $peoplelist[2] = "";
        }
        if(!empty($res[3])){
            $peoplelist[3] = pdo_getcolumn('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$res[3]),array('head_pic'));
        }else{
            $peoplelist[3] = "";
        }
        if(!empty($res[4])){
            $peoplelist[4] = pdo_getcolumn('hcpdd_users',array('uniacid'=>$_GPC['i'],'user_id'=>$res[4]),array('head_pic'));
        }else{
            $peoplelist[4] = "";
        }    
        
        $this->result(0, '首页变色盒',array('list'=>$list,'url'=>$url,'peoplelist'=>$peoplelist,'title'=>$set['kouhong_sharetitle'],'pic'=>$set['kouhong_sharepic']));         
    }
    //口红挑战开始
    public function doPageGame(){

        global $_GPC, $_W;    
        $time=date('Y-m-d',time()); 
        $log = pdo_get('hcpdd_kouhonglog', array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['user_id'],'createday'=>$time));
        //$url = $_W['siteroot'].'app/index.php?i='.$_GPC['i'].'&c=entry&m=hc_pdd&do=play&goods_id='.$_GPC['goods_id'];
        $url = $_W['siteroot'].'addons/hc_pdd/kouhong/play.html?goods_id='.$_GPC['goods_id'];
        if(empty($log)){
            $data['uniacid'] = $_GPC['i'];
            $data['user_id'] = $_GPC['user_id'];
            $data['createtime'] = time();
            $data['createday'] = $time;
            $data['goods_id'] = $_GPC['goods_id'];
            $data['status'] = 0;
            $data['cishu'] = 1;
            $result = pdo_insert('hcpdd_kouhonglog', $data);
            $this->result(0, '获取成功',$url);      
        }elseif($log['cishu'] == 0){
            pdo_update('hcpdd_kouhonglog',array('cishu'=>1,'goods_id'=>$_GPC['goods_id']),array('id'=>$log['id']));
            $this->result(0, '获取成功',$url);   
        }elseif($log['cishu'] == 1){
            $invite = $log['invite_id'];
            $kouhong = explode(",",$invite);
            $count = count($kouhong);
            if($count < 5){
               $this->result(0, '邀请好友获得一次游戏机会',array('status'=>1));
            }else{
               pdo_update('hcpdd_kouhonglog',array('cishu'=>2,'goods_id'=>$_GPC['goods_id']),array('id'=>$log['id']));
               $this->result(0, '获取成功',$url);
            }
        }elseif($log['cishu'] == 2){
            $this->result(0, '今日挑战次数已达上限，请明天再来吧',array('status'=>2));
        }               
    }
    //口红邀请好友
    public function doPageGamezhuce()
    {
        ob_end_clean();
        global $_GPC, $_W;
        $data['uniacid'] = $_GPC['i'];
        $data['city'] = $_POST['city'];
        $data['country'] = $_POST['country'];
        $data['gender'] = $_POST['gender'];
        $data['open_id'] = $_POST['openid'];
        $data['nick_name'] = $_POST['nickname'];
        $data['head_pic'] = $_POST['avatar'];
        $data['province'] = $_POST['province'];
        $stact = 1;
        if(empty($data['open_id'])){
            $this->result(0, $stact, '');
        }
        $uid = pdo_getcolumn('hcpdd_users', array('open_id' => $data['open_id'], 'uniacid' => $data['uniacid']), 'user_id', 1);
        if (empty($uid)){
            $data['pid'] = $this->CreatePid();
            $stact = 0;
            $result = pdo_insert('hcpdd_users', $data, $replace = true);
            $uid = pdo_insertid();
            if(!empty($_GPC['invite_id'])){
                $time = date('Y-m-d',time()); 
                $log = pdo_get('hcpdd_kouhonglog', array('uniacid'=>$_GPC['i'],'user_id'=>$_GPC['invite_id'],'createday'=>$time));
                if(empty($log)){
                    $res['uniacid'] = $_GPC['i'];
                    $res['user_id'] = $_GPC['invite_id'];
                    $res['createtime'] = time();
                    $res['createday'] = $time;
                    $res['invite_id'] = $uid;
                    $res['status'] = 0;
                    $res['cishu'] = 0;
                    $result = pdo_insert('hcpdd_kouhonglog', $res);  
                }else{
                    if(empty($log['invite_id'])){
                       pdo_update('hcpdd_kouhonglog',array('invite_id'=>$uid),array('id'=>$log['id'])); 
                    }else{
                       $invite_id = $log['invite_id'].','.$uid;
                       pdo_update('hcpdd_kouhonglog',array('invite_id'=>$invite_id),array('id'=>$log['id'])); 
                    }
                }
            }
            $this->result(0, $stact,$uid);
        }else{
            $this->result(0, $stact,$uid);
        }        
    }

    //骗审
    public function doPageShenhe(){

        global $_GPC, $_W;
    
        $shenhe = pdo_get('hcpdd_set', array('uniacid'=>$_GPC['i']));

        if($shenhe['version'] == $_GPC['v']){
            $data['shenhe'] = 1;
        }else{
            $data['shenhe'] = 0;
        }

        $data['shenhe_pic'] = $shenhe['shenhe_pic'];
        if(strpos($shenhe['shenhe_pic'],'https') !== false){
               $data['shenhe_pic'] = $data['shenhe_pic'];
            }else{
               $data['shenhe_pic'] = $_W['attachurl'].$data['shenhe_pic'];
            }

        $data['v'] = $_GPC;
        
        $this->result(0, '是否骗审',$data);      
          
    }

    //页面
    public function doPageShenheset(){
        global $_GPC, $_W;            
        ob_end_clean();

        $shenhe=pdo_get('hcpdd_shenhe', array('id' => $_GPC['id']));
        $this->result(0, '获取成功', $shenhe);
    }

    //骗审页面列表
    public function doPageShenhelist(){
        global $_GPC, $_W;
        $shenhe = pdo_getall('hcpdd_shenhe', array('stact'=>1,'uniacid' => $_GPC['i']), array(),'','sort asc');
        foreach ($shenhe as $key => $val) {
            $shenhe[$key]['icon'] = $_W['attachurl'].$val['img'];
        }              
        $this->result(0, '获取成功', $shenhe);
    }

    //骗审页面列表
    public function doPageNewshenhe(){
        global $_GPC, $_W;
        $shenhe = pdo_get('hcpdd_shenheset', array('uniacid'=>$_GPC['i']));
        if(empty($shenhe['banner1'])){
            $shenhe['banner1']='';           
        }elseif(strpos($shenhe['banner1'],'https') !== false){
            $shenhe['banner1'] = $shenhe['banner1'];
        }else{
            $shenhe['banner1'] = $_W['attachurl'].$shenhe['banner1'];
        }
        if(empty($shenhe['banner2'])){
            $shenhe['banner2']='';           
        }elseif(strpos($shenhe['banner2'],'https') !== false){
            $shenhe['banner2'] = $shenhe['banner2'];
        }else{
            $shenhe['banner2'] = $_W['attachurl'].$shenhe['banner2'];
        }
        if(empty($shenhe['banner3'])){
            $shenhe['banner3']='';           
        }elseif(strpos($shenhe['banner3'],'https') !== false){
            $shenhe['banner3'] = $shenhe['banner3'];
        }else{
            $shenhe['banner3'] = $_W['attachurl'].$shenhe['banner3'];
        }
        if(empty($shenhe['goodspic1'])){
            $shenhe['goodspic1']='';           
        }elseif(strpos($shenhe['goodspic1'],'https') !== false){
            $shenhe['goodspic1'] = $shenhe['goodspic1'];
        }else{
            $shenhe['goodspic1'] = $_W['attachurl'].$shenhe['goodspic1'];
        }
        if(empty($shenhe['goodspic2'])){
            $shenhe['goodspic2']='';           
        }elseif(strpos($shenhe['goodspic2'],'https') !== false){
            $shenhe['goodspic2'] = $shenhe['goodspic2'];
        }else{
            $shenhe['goodspic2'] = $_W['attachurl'].$shenhe['goodspic2'];
        }
        if(empty($shenhe['goodspic3'])){
            $shenhe['goodspic3']='';           
        }elseif(strpos($shenhe['goodspic3'],'https') !== false){
            $shenhe['goodspic3'] = $shenhe['goodspic3'];
        }else{
            $shenhe['goodspic3'] = $_W['attachurl'].$shenhe['goodspic3'];
        }
        if(empty($shenhe['goodspic4'])){
            $shenhe['goodspic4']='';           
        }elseif(strpos($shenhe['goodspic4'],'https') !== false){
            $shenhe['goodspic4'] = $shenhe['goodspic4'];
        }else{
            $shenhe['goodspic4'] = $_W['attachurl'].$shenhe['goodspic4'];
        }
        if(empty($shenhe['goodspic5'])){
            $shenhe['goodspic5']='';           
        }elseif(strpos($shenhe['goodspic5'],'https') !== false){
            $shenhe['goodspic5'] = $shenhe['goodspic5'];
        }else{
            $shenhe['goodspic5'] = $_W['attachurl'].$shenhe['goodspic5'];
        }
        if(empty($shenhe['goodspic6'])){
            $shenhe['goodspic6']='';           
        }elseif(strpos($shenhe['goodspic6'],'https') !== false){
            $shenhe['goodspic6'] = $shenhe['goodspic6'];
        }else{
            $shenhe['goodspic6'] = $_W['attachurl'].$shenhe['goodspic6'];
        }
        if(empty($shenhe['goodspic7'])){
            $shenhe['goodspic7']='';           
        }elseif(strpos($shenhe['goodspic7'],'https') !== false){
            $shenhe['goodspic7'] = $shenhe['goodspic7'];
        }else{
            $shenhe['goodspic7'] = $_W['attachurl'].$shenhe['goodspic7'];
        }
        if(empty($shenhe['goodspic8'])){
            $shenhe['goodspic8']='';           
        }elseif(strpos($shenhe['goodspic8'],'https') !== false){
            $shenhe['goodspic8'] = $shenhe['goodspic8'];
        }else{
            $shenhe['goodspic8'] = $_W['attachurl'].$shenhe['goodspic8'];
        }
        if(empty($shenhe['goodspic9'])){
            $shenhe['goodspic9']='';           
        }elseif(strpos($shenhe['goodspic9'],'https') !== false){
            $shenhe['goodspic9'] = $shenhe['goodspic9'];
        }else{
            $shenhe['goodspic9'] = $_W['attachurl'].$shenhe['goodspic9'];
        }
           
        $this->result(0, '获取成功', $shenhe);
    }

    public function doPageFormid(){
        ob_end_clean();
        global $_GPC, $_W;
        $data['user_id']=$_GPC['user_id'];
        $data['formid']=$_GPC['formid'];
        //$aa=$this->getMessagemoney($user_id,$money);
        if(strpos($data['formid']," ")){
            $this->result(0, 'formid不正确');
        }elseif(empty($_GPC['formid']))
        {
            $this->result(0, 'formid为空');
        }else{
            pdo_insert('hcpdd_formid', $data);
            $cid = pdo_insertid();
            $this->result(0, '获取成功',$_GPC);
        }

    }

    public function doPageCanyusccess(){
        ob_end_clean();
        global $_GPC, $_W;
        $user_id=$_GPC['user_id'];
        $user = pdo_get('hcpdd_users', array('user_id' => $user_id));
        $aa=$this->getMessagemoney($user_id);
        $this->result(0, '获取成功', $aa);
    }

    public function getMessagemoney($user_id) {
        global $_GPC, $_W;
        $setup = pdo_get('hcpdd_message', array('uniacid' => $_GPC['i']));
        $formidall=pdo_getall('hcpdd_formid', array('user_id' => $user_id,'status'=>0), array() , '',array('id desc') , array());
        $formid=$formidall[0];
        //$setup = pdo_get('dati_setup', array('uniacid' => $_W['uniacid']));
        //$setup['msgstr']=json_decode($setup['msgstr'],true);
        $user=pdo_get('hcpdd_users', array('user_id' => $user_id));
        $tishi='红包领取成功，请在两小时内使用';
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$this->wx_get_token();
        $data['touser']=$user['open_id'];
        $data['template_id']=$setup['hongbao_msgid'];
        $data['form_id']=$formid['formid'];
        $data['page']='hc_pdd/pages/index/index';
        $data['data']['keyword1']['value']='拼多多无门槛红包';
        $data['data']['keyword1']['color']='#173177';
        $data['data']['keyword2']['value']='两小时';
        $data['data']['keyword2']['color']='#173177';
        $data['data']['keyword3']['value']=$tishi;
        $data['data']['keyword3']['color']='#000000';
        $json = json_encode($data);
        $data=$this->api_notice_increment($url,$json);
        pdo_update('hcpdd_formid', array('status' => 1), array('id' => $formid['id']));
        return $data;
    }

    public function getMessage($user_id,$status) {
        global $_GPC, $_W;
        $formidall=pdo_getall('dati_formid', array('user_id' => $user_id,'status'=>0), array() , '',array('id DESC') , array());
        $formid=$formidall[0];
        $setup = pdo_get('dati_setup', array('uniacid' => $_W['uniacid']));
        $user=pdo_get('dati_users', array('user_id' => $user_id));
        if($status==1){
           $tishi='恭喜您挑战成功';
        }else{
           $tishi='挑战失败，下次继续努力';
        }
        $setup['msgstr']=json_decode($setup['msgstr'],true);
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$this->wx_get_token();
        $data['touser']=$user['open_id'];
        $data['template_id']=$setup['jieguo_msg'];
        $data['form_id']=$formid['formid'];
        $data['page']='hc_dati/pages/index/index';
        $data['data']['keyword1']['value']=$setup['msgstr']['msgstr_name'];
        $data['data']['keyword1']['color']='#173177';
        $data['data']['keyword2']['value']=date('Y-m-d H:i:s', time());
        $data['data']['keyword2']['color']='#173177';
        $data['data']['keyword3']['value']=$tishi;
        $data['data']['keyword3']['color']='#000000';
        $json = json_encode($data);
        $data=$this->api_notice_increment($url,$json);
        pdo_update('hcpdd_formid', array('status' => 1), array('id' => $formid['id']));
        return $data;
    }

    function wx_get_token() {
        global $_GPC, $_W;
        /*$appid=$_W['account']['key'];
        $AppSecret=$_W['account']['secret'];
        $res = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$AppSecret);
        $res = json_decode($res, true);
        $token = $res['access_token'];*/
        $token = $this->getToken();
        return $token;
    }

}