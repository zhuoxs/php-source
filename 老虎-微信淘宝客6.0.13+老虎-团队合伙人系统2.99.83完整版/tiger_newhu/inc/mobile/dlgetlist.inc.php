<?php
global $_W, $_GPC;
       $cfg = $this->module['config'];
        $typeid=$_GPC['typeid'];
        $dluid=$_GPC['dluid'];//share id
        //var_dump($typeid);
        //exit;
        $fans=$this->islogin();
        if(empty($fans['tkuid'])){
        	$fans = mc_oauth_userinfo();	        
        }
//        $fans=$_W['fans'];
//        if(empty($fans)){
//          $fans=mc_oauth_userinfo();
//        }
        $openid=$fans['openid'];
        $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
        $day=date("Y/m/d",time());
        $dtime=strtotime($day);
        $id=$_GPC['id'];
        $tj=$_GPC['tj'];
        $key=$_GPC['key'];
        $op=$_GPC['op'];
        $sort1=$_GPC['sort'];
        $sort=$_GPC['sort'];
        if($sort=='id'){
           $sort='(id+0) desc';
        }elseif($sort=='new'){
           $sort='(id+0) desc';
        }elseif($sort=='hot'){//月销售
           $sort='(goods_sale+0) desc';
        }elseif($sort=='price'){//价格
           $sort='(price+0) asc';
        }elseif($sort=='hit'){//人气
            $sort='(hit+0) desc';
        }else{
          $sort='(id+0) desc';
        }




        if(!empty($typeid)){
           $where =" and type='{$typeid}'";
        }
        
        if(!empty($_GPC['key'])){
            $arr=explode(" ",$_GPC['key']);
             foreach($arr as $v){
                 if (empty($v)) continue;
                $where.=" and title like '%{$v}%'";
             }
            //$where .=" and title like '%{$_GPC['key']}%'";
        }
        if($tj==1){
            $where .=" and price<10";
        }elseif($tj==2){
          $where .=" and price<20 and price>10";
        }

        if($op=='seach'){
            $strprice=$_GPC['strprice'];
            $endprice=$_GPC['endprice'];
            if(!empty($strprice)){
               $where .=" and price<{$strprice}";
            }
            if(!empty($endprice)){
               $where .=" and price>{$endprice}";
            }
        
        }

           if(!empty($cfg['hpx'])){
              $rand=" rand(),";
            }

            $page=$_GPC['pageIndex']+1;
            $pindex = max(1, intval($page));
		    $psize = 10;          
            $list = pdo_fetchall("select * from ".tablename($this->modulename."_tbgoods")." where weid='{$_W['uniacid']}' and coupons_end>={$dtime} {$where} order by {$rand} {$sort} LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_tbgoods')." where coupons_end>={$dtime} and  weid='{$_W['uniacid']}' {$where}");
            if(empty($list)){
              exit('');
            }
            
            
        

        $style=$cfg['qtstyle'];
        if(empty($style)){
            $style='style1';        
        }

       include $this->template ( 'tbgoods/'.$style.'/getlist' );