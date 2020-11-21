<?php 


global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $opt = $_GPC['opt'];
        $ops = array('display', 'hx', 'fahuo','fh');
        $opt = in_array($opt, $ops) ? $opt : 'display';
        if($opt == "hx"){  //核销
            $order = $_GPC['order'];
            $data['hxtime'] = time();
            $data['flag'] = 2;
            $res = pdo_update('sudu8_page_duo_products_order', $data, array('id' => $order));

            // 核销完成后去检测要不要进行分销商返现
            $orderinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and id = :id" , array(':uniacid' => $uniacid,':id' => $order));
            $order_id = $orderinfo['order_id'];
            $openid = $orderinfo['openid'];

            $fxsorder = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_ls')." WHERE uniacid = :uniacid and order_id = :orderid" , array(':uniacid' => $uniacid,':orderid'=>$order_id));
            if($fxsorder){
                $this->dopagegivemoney($openid,$order_id);
            }

            message('核销成功!', $this->createWebUrl('Orderset', array('op'=>'scddfh','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');

        }
        if($opt == "fh"){  
            $order = $_GPC['order'];
            $data['flag'] = 2;
            $res = pdo_update('sudu8_page_duo_products_order', $data, array('id' => $order));

            message('成功!', $this->createWebUrl('Orderset', array('op'=>'scddfh','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');

        }
        if($opt == "fahuo"){  //发货
            $order = $_GPC['orderid'];
            $data['hxtime'] = time();
            $data['kuadi'] = $_GPC['kuadi'];
            $data['kuaidihao'] = $_GPC['kuaidihao'];
            $data['flag'] = 4;
            pdo_update("sudu8_page_duo_products_order",$data,array('id'=>$order));
            message('成功!', $this->createWebUrl('Orderset', array('op'=>'scddfh','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');

        }

        // 处理已发货并且过了7天还没有确定的订单
        $clorders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and flag = 4" , array(':uniacid' => $_W['uniacid']));
        foreach ($clorders as $key => &$res) {
            $st = $res['hxtime'] + 3600*24*7;
            if($st < time()){
                $adata = array(
                    "hxtime" => $st,
                    "flag" => 2
                );
                pdo_update("sudu8_page_duo_products_order",$adata,array('id'=>$res['id']));

                // 核销完成后去检测要不要进行分销商返现
                $order_id = $res['order_id'];
                $openid = $res['openid'];

                $fxsorder = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_ls')." WHERE uniacid = :uniacid and order_id = :orderid" , array(':uniacid' => $uniacid,':orderid'=>$order_id));
                if($fxsorder){
                    $this->dopagegivemoney($openid,$order_id);
                }

            }
        }
        // 处理30分钟未付款的订单
        $wforders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and flag = 0" , array(':uniacid' => $_W['uniacid']));
        foreach ($wforders as $key => &$res) {
            $st = $res['creattime'] + 1800;
            if($st < time()){
                $adata = array(
                    "flag" => 3
                );
                pdo_update("sudu8_page_duo_products_order",$adata,array('id'=>$res['id']));
                pdo_update("sudu8_page_fx_ls",$adata,array('uniacid' => $uniacid,'orderid'=>$res['order_id']));

            }
        }


        $order_id = $_GPC['order_id'];
        if($order_id){
            $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and nav = 1 and order_id LIKE :order_id order by creattime desc" , array(':uniacid' => $_W['uniacid'],':order_id' => '%'.$order_id.'%'));
            foreach ($orders as $key => &$res) {
                $res['jsondata'] = unserialize($res['jsondata']);
                $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
                $res['userinfo'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $res['openid'] ,':uniacid' => $_W['uniacid']));
                $res['counts'] = count($res['jsondata']);
                $coupon =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $res['coupon'] ,':uniacid' => $uniacid));
                $couponinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $coupon['cid'] ,':uniacid' => $uniacid));
                $res['couponinfo'] = $couponinfo;

                // 重新算总价
                $allprice = 0;
                foreach ($res['jsondata'] as $key2 => &$reb) {
                    $allprice += ($reb['num']*1)*($reb['proinfo']['price']);
                }
                $res['allprice'] = $allprice;

                // 积分转钱
                //积分转换成金钱
                $jf_gz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_rechargeconf')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
                if(!$jf_gz){
                    $gzscore = 10000;
                    $gzmoney = 1;
                }else{
                    $gzscore = $jf_gz['scroe'];
                    $gzmoney = $jf_gz['money'];
                }
                $res['jfmoney'] = $res['jf']*$gzmoney/$gzscore;



                // 转换地址
                if($res['address']!=0){
                    $res['address_get'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_address') ." WHERE openid = :openid and id = :id", array(':openid'=>$res['openid'],':id'=>$res['address']));
                }else{
                    $res['address_get'] = $res['m_address'];
                }
            }
        }else{
            $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and nav = 1 order by creattime desc" , array(':uniacid' => $_W['uniacid']));
            foreach ($orders as $key => &$res) {
                $res['jsondata'] = unserialize($res['jsondata']);
                $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
                $res['hxtime'] = $res['hxtime'] == 0?"未核销":date("Y-m-d H:i:s",$res['hxtime']);
                $res['userinfo'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
                $res['counts'] = count($res['jsondata']);
                $coupon =  pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $res['coupon'] ,':uniacid' => $uniacid));
                $couponinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $coupon['cid'] ,':uniacid' => $uniacid));
                $res['couponinfo'] = $couponinfo;

                // 重新算总价
                $allprice = 0;
                foreach ($res['jsondata'] as $key2 => &$reb) {
                    $allprice += ($reb['num']*1)*($reb['proinfo']['price']);
                }
                $res['allprice'] = $allprice;

                // 积分转钱
                //积分转换成金钱
                $jf_gz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_rechargeconf')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
                if(!$jf_gz){
                    $gzscore = 10000;
                    $gzmoney = 1;
                }else{
                    $gzscore = $jf_gz['scroe'];
                    $gzmoney = $jf_gz['money'];
                }
                $res['jfmoney'] = $res['jf']*$gzmoney/$gzscore;


                // 转换地址
                if($res['address']!=0){
                    $res['address_get'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_address') ." WHERE openid = :openid and id = :id", array(':openid'=>$res['openid'],':id'=>$res['address']));
                }else{
                    $res['address_get'] = $res['m_address'];
                }
            }
        }





return include self::template('web/Orderset/scddzt');
