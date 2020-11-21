<?php 
function dopagegivemoney($orderid){
    global $_GPC, $_W;
    $uniacid = $_W['uniacid'];
    $guiz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
    $order = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_ls')." WHERE uniacid = :uniacid and order_id = :orderid" , array(':uniacid' => $uniacid,':orderid'=>$orderid));
    pdo_update("sudu8_page_fx_ls",array("flag"=>2),array("order_id"=>$orderid));
    $me = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['openid'] ,':uniacid' => $_W['uniacid']));
    $me_p_get_money = $me['p_get_money'];
    $me_p_p_get_money = $me['p_p_get_money'];
    $me_p_p_p_get_money = $me['p_p_p_get_money'];
    // 启动一级分销提成
    if($guiz['fx_cj'] == 1){
        if($order['parent_id']){
            $puser = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['parent_id'] ,':uniacid' => $_W['uniacid']));
            $kdata = array(
                "fx_allmoney" => $puser['fx_allmoney'] + $order['parent_id_get'],
                "fx_money" => $puser['fx_money'] + $order['parent_id_get']
            );
            pdo_update("sudu8_page_user",$kdata,array('openid' => $order['parent_id'] ,'uniacid' => $uniacid));
            // 我给我的父级贡献的钱
            $new_p_get_money = $me_p_get_money*1 + $order['parent_id_get']*1;
            pdo_update("sudu8_page_user",array("p_get_money" => $new_p_get_money),array('openid' => $order['openid'] ,'uniacid' => $uniacid));
        }
    }
    // 启动二级分销提成
    if($guiz['fx_cj'] == 2){
        if($order['parent_id']){
            $puser = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['parent_id'] ,':uniacid' => $_W['uniacid']));
            $kdata = array(
                "fx_allmoney" => $puser['fx_allmoney'] + $order['parent_id_get'],
                "fx_money" => $puser['fx_money'] + $order['parent_id_get']
            );
            pdo_update("sudu8_page_user",$kdata,array('openid' => $order['parent_id'] ,'uniacid' => $uniacid));
            // 我给我的父级贡献的钱
            $new_p_get_money = $me_p_get_money*1 + $order['parent_id_get']*1;
            pdo_update("sudu8_page_user",array("p_get_money" => $new_p_get_money),array('openid' => $order['openid'] ,'uniacid' => $uniacid));
        }
        if($order['p_parent_id']){
            $puser = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['p_parent_id'] ,':uniacid' => $_W['uniacid']));
            $kdata = array(
                "fx_allmoney" => $puser['fx_allmoney'] + $order['p_parent_id_get'],
                "fx_money" => $puser['fx_money'] + $order['p_parent_id_get']
            );
            pdo_update("sudu8_page_user",$kdata,array('openid' => $order['p_parent_id'] ,'uniacid' => $uniacid));
            // 我给我的父级的父级贡献的钱
            $new_p_p_get_money = $me_p_p_get_money*1 + $order['p_parent_id_get']*1;
            pdo_update("sudu8_page_user",array("p_p_get_money" => $new_p_p_get_money),array('openid' => $order['openid'] ,'uniacid' => $uniacid));
        }
    }
    // 启动三级分销提成
    if($guiz['fx_cj'] == 3){
        if($order['parent_id']){
            $puser = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['parent_id'] ,':uniacid' => $_W['uniacid']));
            $kdata = array(
                "fx_allmoney" => $puser['fx_allmoney'] + $order['parent_id_get'],
                "fx_money" => $puser['fx_money'] + $order['parent_id_get']
            );
            pdo_update("sudu8_page_user",$kdata,array('openid' => $order['parent_id'] ,'uniacid' => $uniacid));
            // 我给我的父级贡献的钱
            $new_p_get_money = $me_p_get_money*1 + $order['parent_id_get']*1;
            pdo_update("sudu8_page_user",array("p_get_money" => $new_p_get_money),array('openid' => $order['openid'] ,'uniacid' => $uniacid));
        }
        if($order['p_parent_id']){
            $puser = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['p_parent_id'] ,':uniacid' => $_W['uniacid']));
            $kdata = array(
                "fx_allmoney" => $puser['fx_allmoney'] + $order['p_parent_id_get'],
                "fx_money" => $puser['fx_money'] + $order['p_parent_id_get']
            );
            pdo_update("sudu8_page_user",$kdata,array('openid' => $order['p_parent_id'] ,'uniacid' => $uniacid));
            // 我给我的父级的父级贡献的钱
            $new_p_p_get_money = $me_p_p_get_money*1 + $order['p_parent_id_get']*1;
            pdo_update("sudu8_page_user",array("p_p_get_money" => $new_p_p_get_money),array('openid' => $order['openid'] ,'uniacid' => $uniacid));
        }
        if($order['p_p_parent_id']){
            $puser = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $order['p_p_parent_id'] ,':uniacid' => $_W['uniacid']));
            $kdata = array(
                "fx_allmoney" => $puser['fx_allmoney'] + $order['p_p_parent_id_get'],
                "fx_money" => $puser['fx_money'] + $order['p_p_parent_id_get']
            );
            pdo_update("sudu8_page_user",$kdata,array('openid' => $order['p_p_parent_id'] ,'uniacid' => $uniacid));
            // 我给我的父级的父级的附近贡献的钱
            $new_p_p_p_get_money = $me_p_p_p_get_money*1 + $order['p_p_parent_id_get']*1;
            pdo_update("sudu8_page_user",array("p_p_p_get_money" => $new_p_p_p_get_money),array('openid' => $order['openid'] ,'uniacid' => $uniacid));
        }
    }
}

load()->func('tpl');
        global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $opt = $_GPC['opt'];
        $ops = array('display', 'heixiao');
        $opt = in_array($opt, $ops) ? $opt : 'display';

        pdo_query("UPDATE ".tablename("sudu8_page_fx_ls")." as a join ".tablename("sudu8_page_duo_products_order")." as b on a.order_id = b.order_id and a.uniacid = b.uniacid SET a.flag = 3 WHERE b.flag in (5, 8) and a.uniacid = :uniacid", array(":uniacid"=>$uniacid));

        // pdo_query("UPDATE ".tablename("sudu8_page_fx_ls")." as a join ".tablename("sudu8_page_order")." as b on a.order_id = b.order_id and a.uniacid = b.uniacid SET a.flag = 3 WHERE b.flag in (5, 8) and a.uniacid = :uniacid", array(":uniacid"=>$uniacid));

        //更新分销订单状态
        $fxorders = pdo_fetchall("SELECT a.* FROM ".tablename("sudu8_page_fx_ls")." as a JOIN ".tablename("sudu8_page_duo_products_order")." as b on a.order_id = b.order_id and a.uniacid = b.uniacid WHERE a.uniacid = :uniacid and a.flag = 1 and date_add(now(), interval -1 week) > from_unixtime(b.hxtime) and (b.flag = 2 or b.flag = 4)", array(":uniacid"=>$uniacid));

        if($fxorders){
            foreach ($fxorders as $key => &$value) {
                dopagegivemoney($value['order_id']);
            }
        }

        $dan_orders = pdo_fetchall("SELECT a.* FROM ".tablename("sudu8_page_fx_ls")." as a JOIN ".tablename("sudu8_page_order")." as b on a.order_id = b.order_id and a.uniacid = b.uniacid WHERE a.uniacid = 
            :uniacid and a.flag = 1 and date_add(now(), interval -1 week) > from_unixtime(b.custime) and b.flag = 1", array(":uniacid" => $uniacid));
        if($dan_orders){
            foreach ($dan_orders as $key => &$value) {
                dopagegivemoney($value['order_id']);
            }
        }

        $total = pdo_fetchcolumn("SELECT count(*) FROM ".tablename('sudu8_page_fx_ls')." WHERE uniacid = :uniacid", array(':uniacid' => $_W['uniacid']));
        $pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;  
        $start = ($pageindex-1) * $pagesize;
        $pager = pagination($total, $pageindex, $pagesize);
        $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_fx_ls')." WHERE uniacid = :uniacid order by id desc LIMIT ".$start.",".$pagesize , array(':uniacid' => $_W['uniacid']));


        foreach ($orders as $key => &$res) {
            $v = 0;
            $bili = 0;

            // 根据订单号去订单里面去jsondata
            $orderinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and order_id = :order_id" , array(':uniacid' => $_W['uniacid'],':order_id' => $res['order_id']));     
            $jsdata = unserialize($orderinfo['jsondata']);
            $one_bili = $jsdata[0]['one_bili'];
            $two_bili = $jsdata[0]['two_bili'];
            $three_bili = $jsdata[0]['three_bili'];


            $res['gmz'] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid=:openid" , array(':uniacid' => $_W['uniacid'],':openid' => $res['openid']));
            $res['gmz']['nickname'] = rawurldecode($res['gmz']['nickname']);

            if($res['parent_id']){
                $v = 1;
                $bili = $one_bili;
                $res["v1"] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid=:openid" , array(':uniacid' => $_W['uniacid'],':openid' => $res['parent_id']));
                $res["v1"]['hmoney'] = $res['parent_id_get'];
                $res["v1"]['nickname'] = rawurldecode($res['v1']['nickname']);

                //var_dump($res["v1"]['hmoney']);
                // die();
            }
            if($res['p_parent_id']){
                $v = 2;
                $bili = $two_bili;
                $res["v2"] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid=:openid" , array(':uniacid' => $_W['uniacid'],':openid' => $res['p_parent_id']));
                $res["v2"]['hmoney'] = $res['p_parent_id_get'];
                $res["v2"]['nickname'] = rawurldecode($res['v2']['nickname']);

            }
            if($res['p_p_parent_id']){
                $v = 3;
                $bili = $three_bili;
                $res["v3"] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid=:openid" , array(':uniacid' => $_W['uniacid'],':openid' => $res['p_p_parent_id']));
                $res["v3"]['hmoney'] = $res['p_p_parent_id_get'];
                $res["v3"]['nickname'] = rawurldecode($res['v3']['nickname']);

            }


            $order = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_duo_products_order')." WHERE uniacid = :uniacid and order_id = :orderid" , array(':uniacid' => $uniacid,':orderid'=>$res['order_id']));
            
            $res['datas'] = unserialize($order['jsondata']);

            $res['order'] = $order;

            $res['counts'] = count(unserialize($order['jsondata']));
            $res['creattime'] = date("Y-m-d H:i",$res['creattime']);

            if($res['order']['hxtime']){
                $res['order']['hxtime'] = date("Y-m-d H:i",$res['order']['hxtime']);
            }
            
            $res['v'] = $v;

        } 

return include self::template('web/Distributionset/fxorder');