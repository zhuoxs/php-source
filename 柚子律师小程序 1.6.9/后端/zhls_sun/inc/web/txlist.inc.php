<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$type=empty($_GPC['type']) ? 'all' :$_GPC['type'];
$state=$_GPC['state'];
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$where=' WHERE  uniacid=:uniacid';
$data[':uniacid']=$_W['uniacid'];
if($_GPC['keywords']){
    $op=$_GPC['keywords'];
    $where.=" and name LIKE  concat('%', :name,'%') ";    
    $data[':name']=$op;
}
if($type=='all'){    
  $sql="SELECT * FROM ".tablename('zhls_sun_withdrawal') .  "  ". $where." ORDER BY time DESC";
  $total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('zhls_sun_withdrawal') ."".$where." ORDER BY time DESC",$data);
}else{
    $where.= " and state=".$state;
    $sql="SELECT * FROM ".tablename('zhls_sun_withdrawal') .  " ".$where." ORDER BY time DESC";
    $data[':uniacid']=$_W['uniacid'];
    $total=pdo_fetchcolumn("SELECT count(*) FROM ".tablename('zhls_sun_withdrawal') .  " ".$where." ORDER BY time DESC",$data);    
}
$list=pdo_fetchall( $sql,$data);
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql,$data);
$pager = pagination($total, $pageindex, $pagesize);
if($operation=='adopt'){//审核通过（提现）
    $id=$_GPC['id'];
    $list=pdo_get('zhls_sun_withdrawal',array('id'=>$_GPC['id']));
    $user=pdo_get('zhls_sun_user',array('id'=>$list['user_id']));
    //获取系统打款方式
    $xtsystem=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
    $client_ip=$_SERVER['SERVER_ADDR'];
    if(empty($client_ip)){
        $client_ip=$xtsystem['client_ip'];
    }
    if($list['type']==2&&$xtsystem['tx_mode']==2){

////////////////打款//////////////////////
        function arraytoxml($data){
            $str='<xml>';
            foreach($data as $k=>$v) {
                $str.='<'.$k.'>'.$v.'</'.$k.'>';
            }
            $str.='</xml>';
            return $str;
        }
        function xmltoarray($xml) {
            //禁止引用外部xml实体
            libxml_disable_entity_loader(true);
            $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
            $val = json_decode(json_encode($xmlstring),true);
            return $val;
        }
        function curl($param="",$url) {
            global $_GPC, $_W;
            $postUrl = $url;
            $curlPost = $param;
            $ch = curl_init();                                      //初始化curl
            curl_setopt($ch, CURLOPT_URL,$postUrl);                 //抓取指定网页
            curl_setopt($ch, CURLOPT_HEADER, 0);                    //设置header
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);            //要求结果为字符串且输出到屏幕上
            curl_setopt($ch, CURLOPT_POST, 1);                      //post提交方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);           // 增加 HTTP Header（头）里的字段
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);        // 终止从服务端进行验证
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch,CURLOPT_SSLCERT,IA_ROOT . "/addons/zhls_sun/cert/".'apiclient_cert_' . $_W['uniacid'] . '.pem'); //这个是证书的位置绝对路径
            curl_setopt($ch,CURLOPT_SSLKEY,IA_ROOT . "/addons/zhls_sun/cert/".'apiclient_key_' . $_W['uniacid'] . '.pem'); //这个也是证书的位置绝对路径
            $datas = curl_exec($ch);//运行curl
            curl_close($ch);
            return $datas;
        }
        $system=pdo_get('zhls_sun_system',array('uniacid'=>$_W['uniacid']));
        $new_data['mch_appid']=$system['appid'];//商户的应用appid
        $new_data['mchid']=$system['mchid'];//商户ID
        $new_data['nonce_str']=rand(10000, 90000) . rand(10000, 90000);//unicode();//这个据说是唯一的字符串下面有方法
        $new_data['partner_trade_no']=time().rand(11111,99999);//.time();//这个是订单号。
        $new_data['openid']=$user['openid'];//这个是授权用户的openid。。这个必须得是用户授权才能用
        $new_data['check_name']='NO_CHECK';//这个是设置是否检测用户真实姓名的 , 这里为不验证
        $new_data['re_user_name']=$list['user_name'];//用户的真实名字
        $new_data['amount']=$list['sj_cost']*100;//提现金额
//        $new_data['amount']=1*100;//提现金额
        $new_data['desc']='提现打款';//订单描述
        $new_data['spbill_create_ip']=$_SERVER['SERVER_ADDR'];//这个最烦了，，还得获取服务器的ip
        $secrect_key=$system['wxkey'];///这个就是个API密码。32位的。。随便MD5一下就可以了
        $new_data=array_filter($new_data);
        ksort($new_data);
        $str='';
        foreach($new_data as $k=>$v) {
            $str.=$k.'='.$v.'&';
        }
        $str.='key='.$secrect_key;
        $new_data['sign']=md5($str);
        $xml=arraytoxml($new_data);
        $url='https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        $res=curl($xml,$url);
        $return=xmltoarray($res);
    if($return['result_code']=='SUCCESS'){
      $res=pdo_update('zhls_sun_withdrawal',array('state'=>2,'sh_time'=>time()),array('id'=>$id));
      message('审核成功',$this->createWebUrl('txlist',array()),'success');
    }else{
      message($return['err_code_des'],$this->createWebUrl('txlist',array()),'error');
    }

}else{
    $res=pdo_update('zhls_sun_withdrawal',array('state'=>2,'sh_time'=>time()),array('id'=>$id));
    if($res){
        message('审核成功',$this->createWebUrl('txlist',array()),'success');
    }else{
        message('审核失败','','error');
    }
  }
}
if($operation=='reject'){
     $id=$_GPC['id'];
     $list=pdo_get('zhls_sun_withdrawal',array('id'=>$id));
     $res=pdo_update('zhls_sun_withdrawal',array('state'=>3,'sh_time'=>time()),array('id'=>$id));
     if($res){
        pdo_update('zhls_sun_lawmoney',array('money +='=>$list['tx_cost']),array('uniacid'=>$_W['uniacid'],'ls_id'=>$list['ls_id']));
        message('拒绝成功',$this->createWebUrl('txlist',array()),'success');
    }else{
        message('拒绝失败','','error');
    }
}
if($operation=='delete'){
     $id=$_GPC['id'];
     $res=pdo_delete('zhls_sun_withdrawal',array('id'=>$id));
     if($res){
        message('删除成功',$this->createWebUrl('txlist',array()),'success');
    }else{
        message('删除失败','','error');
    }

}

include $this->template('web/txlist');