<?php 




global $_GPC, $_W;
        $uniacid = $_W['uniacid'];
        $opt = $_GPC['opt'];
        $ops = array('display', 'sxj', 'xieyiv', 'fenx');
        $opt = in_array($opt, $ops) ? $opt : 'display';

        $item = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_gz') ." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));

        if($opt == "display"){

            if (checksubmit('submit')) {
                $fxcj = $_GPC['fx_cj'];
                $data = array(
                    "uniacid" => $uniacid,
                    "fxs_name" => $_GPC['fxs_name'],
                    "fx_cj" => $fxcj,
                    "one_bili" => $_GPC['one_bili'],
                    "two_bili" => $_GPC['two_bili'],
                    "three_bili" => $_GPC['three_bili'],
                    "sq_thumb" => $_GPC['sq_thumb'],
                    "txmoney" => $_GPC['txmoney']
                );

                if($_GPC['types']){
                    $data['tx_type'] = implode(",", $_GPC['types']);
                }else{
                    $data['tx_type'] = "1,2,3";
                }

                if($item){
                    pdo_update("sudu8_page_fx_gz",$data,array("uniacid"=>$uniacid));
                }else{
                    pdo_insert("sudu8_page_fx_gz",$data);
                }
                
                message('分销基础设置 新增/修改成功!', $this->createWebUrl('Distributionset', array('op'=>'display','opt'=>'display','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
            }

        }

        if($opt == "fenx"){

            if (checksubmit('submit')) {
                $fxcj = $_GPC['fx_cj'];
                $data = array(
                    "uniacid" => $uniacid,
                    "thumb" => $_GPC['thumb']
                ); 


                if($item){
                    pdo_update("sudu8_page_fx_gz",$data,array("uniacid"=>$uniacid));
                }else{
                    pdo_insert("sudu8_page_fx_gz",$data);
                }
                
                message('分享推广设置 新增/修改成功!', $this->createWebUrl('Distributionset', array('op'=>'display','opt'=>'fenx','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
            }

        }


        if($opt == "sxj"){

            if (checksubmit('submit')) {
                $sxj_gx = $_GPC['sxj_gx'];
                $fxs_sz = $_GPC['fxs_sz'];
                $fxs_sz_val = $_GPC['fxs_sz_val'];

                $data = array(
                    "uniacid" => $uniacid,
                    "sxj_gx" => $sxj_gx,
                    "fxs_sz" => $fxs_sz,
                    "fxs_sz_val" => $fxs_sz_val 
                );

                if($item){
                    pdo_update("sudu8_page_fx_gz",$data,array("uniacid"=>$uniacid));
                }else{
                    pdo_insert("sudu8_page_fx_gz",$data);
                }

                message('上下级关系及分销资格 设置 新增/修改成功!', $this->createWebUrl('Distributionset', array('op'=>'display','opt'=>'sxj','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
            }

        }


        if($opt == "xieyiv"){

            if (checksubmit('submit')) {

                $data = array(
                    "fxs_xy" => htmlspecialchars_decode($_GPC['fxs_xy'], ENT_QUOTES)
                );

                if($item){
                    pdo_update("sudu8_page_fx_gz",$data,array("uniacid"=>$uniacid));
                }else{
                    pdo_insert("sudu8_page_fx_gz",$data);
                }

                message('分销商申请协议 设置 新增/修改成功!', $this->createWebUrl('Distributionset', array('op'=>'display','opt'=>'xieyiv','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
            }

        }





return include self::template('web/Distributionset/display');