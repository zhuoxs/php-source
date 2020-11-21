<?php 
load()->func('tpl');

        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $opt = $_GPC['opt'];
        $ops = array('display', 'txsz' ,'shenhe');
        $opt = in_array($opt, $ops) ? $opt : 'display';

        if($opt == "display"){
            $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_fx_tx')." WHERE uniacid = :uniacid", array(':uniacid' => $_W['uniacid']));
            $pageindex = max(1, intval($_GPC['page']));
            $pagesize = 10;
            $start = ($pageindex-1) * $pagesize;
            $pager = pagination($total, $pageindex, $pagesize);
            $sqtx = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_fx_tx')." WHERE uniacid = :uniacid order by id desc LIMIT ".$start.",".$pagesize, array(':uniacid' => $_W['uniacid']));
            foreach ($sqtx as $key => &$res) {
                $user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $res['openid'] ,':uniacid' => $uniacid));
                $user['nickname'] = rawurldecode($user['nickname']);
                $res['userinfo'] = $user;
                $res['creattime'] = date("Y-m-d H:i:s", $res['creattime']);
            }
        }
        if($opt == "shenhe"){
            $id = $_GPC['id'];
            $val = $_GPC['val'];
    
            if($val==2){
                // 更新信息
                $sqtx = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_tx')." WHERE uniacid = :uniacid and id = :id" , array(':uniacid' => $uniacid,':id'=>$id));
                $openid = $sqtx['openid'];
                $money = $sqtx['money'];
 
                $user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid" , array(':uniacid' => $uniacid,':openid' => $openid));
                $user_fxgetmoney = $user['fx_getmoney'];
                $user_fxmoney = $user['fx_money'];
                $user_money = $user['money'];


                if($sqtx['types']==1){  //支付到余额
                    $user_money = $user_money + $money;  //我的钱
                    $user_fxgetmoney = $user_fxgetmoney + $money;  //分销获得过的钱

                    $adata = array(
                        "money" => $user_money,
                        "fx_getmoney" => $user_fxgetmoney,
                    );

                    pdo_update("sudu8_page_user",$adata,array("openid"=>$openid));
                    pdo_update("sudu8_page_fx_tx",array("flag"=>2,"txtime"=>time()),array("id"=>$id));

                    $jdata['uniacid'] = $uniacid;
                    $jdata['orderid'] = "";
                    $jdata['uid'] = $user['id'];
                    $jdata['type'] = "add";
                    $jdata['score'] = $money;
                    $jdata['message'] = "分销提现到余额";
                    $jdata['creattime'] = time();
                    pdo_insert('sudu8_page_money', $jdata);

                }

                if($sqtx['types']==2){  //支付到微信

                    $app = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
                    $paycon = pdo_fetch("SELECT * FROM ".tablename('uni_settings')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
                    $datas = unserialize($paycon['payment']);
                     
                    $openid= $sqtx['openid'];    //申请者的openid
                    $money= $sqtx['money'];  //申请了提现多少钱

                    $userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
                    $nickname = $userinfo['nickname'];

                    $mchid = $datas['wechat']['mchid'];   //商户号
                    $apiKey = $datas['wechat']['signkey'];    //商户的秘钥

                    $appid = $app['key'];                 //小程序的id
                    $appkey = $app['secret'];            //小程序的秘钥

                    include ROOT_PATH.'weixin_zf.php';

                    //②、付款
                    $now = time();
                    $order_id = $order = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);

                    $wxPay = new WxpayService($mchid,$appid,$appkey,$apiKey);
                    $result = $wxPay->createJsBizPackage($openid,$money,$order_id,$nickname,$uniacid);

                    if($result){
                        $user_fxgetmoney = $user_fxgetmoney + $money;

                        $adata = array(
                            "fx_getmoney" => $user_fxgetmoney,
                        );

                        pdo_update("sudu8_page_user",$adata,array("openid"=>$openid));
                        pdo_update("sudu8_page_fx_tx",array("flag"=>2,"txtime"=>time()),array("id"=>$id));
                    }


                    
                }

                if($sqtx['types']==3 ){  //支付到支付宝
                    $user_fxgetmoney = $user_fxgetmoney + $money;
                    $adata = array(
                        "fx_getmoney" => $user_fxgetmoney,
                    );

                    pdo_update("sudu8_page_user",$adata,array("openid"=>$openid));
                    pdo_update("sudu8_page_fx_tx",array("flag"=>2,"txtime"=>time()),array("id"=>$id));

          
                }
                if($sqtx['types']==4 ){  //支付到银行卡
                    $user_fxgetmoney = $user_fxgetmoney + $money;
                    $adata = array(
                        "fx_getmoney" => $user_fxgetmoney,
                    );

                    pdo_update("sudu8_page_user",$adata,array("openid"=>$openid));
                    pdo_update("sudu8_page_fx_tx",array("flag"=>2,"txtime"=>time()),array("id"=>$id));

          
                }
                message('提现成功!', $this->createWebUrl('Distributionset', array('op'=>'tixian','opt'=>"display",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');


            }
            if($val==3){
                pdo_update("sudu8_page_fx_tx",array("flag"=>3,"txtime"=>time()),array("id"=>$id));
                // 并吧钱还原过去
                $sqtx = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_tx')." WHERE uniacid = :uniacid and id = :id" , array(':uniacid' => $uniacid,':id'=>$id));
                $openid = $sqtx['openid'];
                $money = $sqtx['money'];

                $user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid" , array(':uniacid' => $uniacid,':openid' => $openid));

                $fx_money = $user['fx_money'];
                $new_fx_money = $fx_money*1 + $money*1;

                pdo_update("sudu8_page_user",array("fx_money"=>$new_fx_money),array('openid' => $openid ,'uniacid' => $_W['uniacid']));

                message('提现不通过!!', $this->createWebUrl('Distributionset', array('op'=>'tixian','opt'=>"display",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'error');
            }

            

        }

        if($opt == "txsz"){
            $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_gz') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
            if (checksubmit('submit')) {
                $txmoney = $_GPC['txmoney'];
                // $cert = $_GPC['certtext'];
                // $key = $_GPC['keytext'];
                // $ca = $_GPC['catext'];
                $data = array(
                    "txmoney" => $txmoney,
                    "uniacid" => $uniacid,
                    // "certtext" => $cert,
                    // "keytext" => $key,
                    // "catext" => $ca
                );

                if($item){
                    pdo_update("sudu8_page_fx_gz",$data,array("uniacid"=>$uniacid));
                }else{
                    pdo_insert("sudu8_page_fx_gz",$data);
                }
                message('提现设置 新增/修改成功!!', $this->createWebUrl('Distributionset', array('op'=>'tixian','opt'=>"txsz",'cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
            }

        }


return include self::template('web/Distributionset/tixian');