<?php
    //参数设置
    defined('IN_IA') or exit('Access Denied');
    global $_W,$_GPC;
    $uniacid = $_W['uniacid'];
    $kuaidi100 =  pdo_fetch("SELECT * FROM".tablename('hyb_yl_kuaidi100')."where uniacid='{$uniacid}'");
    $post_data = array();
    $post_data["customer"] = $kuaidi100['customer'];
    $key=  $kuaidi100['key'];
    $com =$_GPC['com'];
    $num =$_GPC['num'];
    $datas['com']=$com;  //查询的快递公司的编码， 一律用小写字母
    $datas['num']=$num;  //查询的快递单号， 单号的最大长度是32个字符 358263398950
    $post_data["param"] =json_encode($datas);
    $url='http://poll.kuaidi100.com/poll/query.do';
    $post_data["sign"] = md5($post_data["param"].$key.$post_data["customer"]);
    $post_data["sign"] = strtoupper($post_data["sign"]);
    $o="";
    foreach ($post_data as $k=>$v)
    {
        $o.= "$k=".urlencode($v)."&";   //默认UTF-8编码格式
    }
    $post_data=substr($o,0,-1);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $result = curl_exec($ch);
    $data = str_replace("\"",'"',$result );
    $data = json_decode($data,true);
    json_encode($data);

