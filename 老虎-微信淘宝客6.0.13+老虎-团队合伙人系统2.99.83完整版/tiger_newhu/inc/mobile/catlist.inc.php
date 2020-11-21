<?php
global $_W, $_GPC;
        $cfg = $this->module['config'];
        $typeid=$_GPC['typeid'];
        $dluid=$_GPC['dluid'];//share id
        $weid=$_W['uniacid'];
        if(!empty($cfg['gyspsj'])){
          $weid=$cfg['gyspsj'];
        }

        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();	        
        }


        $msg = pdo_fetchall("SELECT * FROM " . tablename($this->modulename."_msg") . " WHERE weid = '{$_W['uniacid']}' order by rand() desc limit 100");
        if(!empty($dluid)){
          $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and id='{$dluid}'");
        }else{
          //$fans=mc_oauth_userinfo();
          $openid=$fans['openid'];
          $zxshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
        }
        if($zxshare['dltype']==1){
            if(!empty($zxshare['dlptpid'])){
               $cfg['ptpid']=$zxshare['dlptpid'];
            }
            
        }else{
           if(!empty($zxshare['helpid'])){//查询有没有上级
                 $sjshare=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and dltype=1 and openid='{$zxshare['helpid']}'");           
            }
        }
        if(!empty($sjshare['dlptpid'])){
            if(!empty($sjshare['dlptpid'])){
              $cfg['ptpid']=$sjshare['dlptpid'];
            }            
        }else{
           if($share['dlptpid']){
               if(!empty($share['dlptpid'])){
                 $cfg['ptpid']=$share['dlptpid'];
               }               
            }
        }
        //var_dump($typeid);
        //exit;
        $day=date("Y/m/d",time());
        $dtime=strtotime($day);
        $id=$_GPC['id'];
        $tj=$_GPC['tj'];
        $zt=$_GPC['zt'];
        $key=$_GPC['key'];
        $op=$_GPC['op'];
        $sort1=$_GPC['sort'];
        $sort=$_GPC['sort'];
        if($sort=='id'){
           $sort='id desc';
        }elseif($sort=='new'){
           $sort='id desc';
        }elseif($sort=='hot'){//月销售
           $sort='(goods_sale+0) desc';
        }elseif($sort=='price'){//价格
           $sort='(price+0) asc';
        }elseif($sort=='hit'){//人气
            $sort='(hit+0) desc';
        }else{
          $sort='id desc';
        }
        if(!empty($zt)){
           $ztview=pdo_fetch("select * from ".tablename('tiger_newhu_zttype')." where weid='{$weid}' and id='{$zt}'");  
        }

        $fans=$_W['fans'];
            if(empty($fans)){
              $fans=mc_oauth_userinfo();
            }
            $openid=$fans['openid'];



        if(!empty($typeid)){
           $where =" and type='{$typeid}'";
        }

       

        
        
        if(!empty($_GPC['key'])){
//            if($cfg['fcss']==1){
//               $arr=$this->getfc($_GPC['key']);
//               //$arr=explode(" ",$arr);
//            }else{
//               $arr=explode(" ",$_GPC['key']);
//            }
             include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
             $arr=getfc($_GPC['key'],$_W);

            
             foreach($arr as $v){
                 if (empty($v)) continue;
                $where.=" and title like '%{$v}%'";
             }
        }





        if($tj==1){
            $where .=" and price<10";
        }elseif($tj==2){
          $where .=" and price<20 and price>10";
        }

        //if($op=='seach'){
            $strprice=$_GPC['strprice'];
            $endprice=$_GPC['endprice'];
            if(!empty($strprice)){
               $where .=" and price<{$strprice}";
            }
            if(!empty($endprice)){
               $where .=" and price>{$endprice}";
            }
        
        //}
        //echo $where;





        if(!empty($typeid)){
          $fzview = pdo_fetch("select * from ".tablename($this->modulename."_fztype")." where weid='{$weid}' and id='{$typeid}'");
          $fzarr=explode("|", $fzview['tag']); 
        }

        $fzlist = pdo_fetchall("select * from ".tablename($this->modulename."_fztype")." where weid='{$weid}'  order by px desc");

           if(!empty($cfg['hpx'])){
              $rand=" rand(),";
            }
            
            $list10 = pdo_fetchall("select * from ".tablename($this->modulename."_tbgoods")." where weid='{$weid}' and coupons_end>={$dtime} {$where} order by {$rand} {$sort} LIMIT 10");

        $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单

        $style=$cfg['qtstyle'];
        if(empty($style)){
            $style='style1';        
        }


       include $this->template ( 'tbgoods/'.$style.'/catlist' );