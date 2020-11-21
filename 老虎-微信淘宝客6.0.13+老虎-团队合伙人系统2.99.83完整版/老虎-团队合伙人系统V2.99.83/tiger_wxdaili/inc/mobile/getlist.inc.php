 <?php
 global $_W, $_GPC;
       
       $cfg = $this->module['config'];
        $typeid=$_GPC['typeid'];
        //var_dump($typeid);
        //exit;
        $day=date("Y/m/d",time());
        $dtime=strtotime($day);
        $openid=$_GPC['openid'];
        $share=pdo_fetch("select * from ".tablename('tiger_newhu_share')." where weid='{$_W['uniacid']}' and from_user='{$openid}'");
        $bl=pdo_fetch("select * from ".tablename('tiger_wxdaili_set')." where weid='{$_W['uniacid']}'");

        $weid=$_W['uniacid'];

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

        $fs=$this->jcbl($share,$bl);

        if(empty($share['dlbl'])){
          $dlbl=$bl['dlbl1'];
        }else{
          $dlbl=$fs['bl'];
        }

            if(empty($share['dlptpid'])){
              $pid=$cfg['ptpid'];
            }else{
              $pid=$share['dlptpid'];
            }


          if($cfg['dlmmtype']==1){
   
                $page=$_GPC['limit'];
                //$list=$this->goodlist($key,$pid,$page,$dlbl,$bl);
                //file_put_contents(IA_ROOT."/addons/tiger_wxdaili/log--page.txt","\n".json_encode($page),FILE_APPEND);

                if(empty($key)){
                  $key=$cfg['sylmkey'];
                  $arrkey=explode('|',$key);
                  $ar_num=array_rand($arrkey,1);
                  $key=$arrkey[$ar_num];
                }
                //file_put_contents(IA_ROOT."/addons/tiger_wxdaili/log--key.txt","\n".json_encode($key),FILE_APPEND);

                include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
                $list=getgyapigoods($key,$_W,$pid,$page);
                //file_put_contents(IA_ROOT."/addons/tiger_wxdaili/log--.txt","\n goodsid:".json_encode($list),FILE_APPEND);
                if (!empty($list['list'])){
                    $list['list']=array_values($list['list']);
                    foreach($list['list'] as $k=>$v){
                       $dlyj=($v['tk_rate']*$v['price']/100);
                       if(!empty($bl['dlkcbl'])){
                         $dlyj=$dlyj*(100-$bl['dlkcbl'])/100;
                       }
                      // file_put_contents(IA_ROOT."/addons/tiger_wxdaili/log--.txt","\n goodsid:".json_encode($dlyj."--".$v['tk_rate']."--".$v['price']."--".$dlbl.">>>".number_format($dlyj*$dlbl/100,2)),FILE_APPEND);
                       $list1[$k]['title']=$v['title'];
                       $list1[$k]['pic_url']=$v['pic_url'];
                       $list1[$k]['price']=$v['price'];
                       $list1[$k]['org_price']=$v['org_price'];
                       $list1[$k]['coupons_price']=$v['coupons_price'];
                       $list1[$k]['tk_rate']=$v['tk_rate'];
                       $list1[$k]['lxtype']=$v['lxtype'];
                       $list1[$k]['dlyj']=number_format($dlyj*$dlbl/100,2);//代理佣金
                       $list1[$k]['id']=$v['id'];
                       $list1[$k]['num_iid']=$v['num_iid'];
                       $list1[$k]['coupons_take']=$v['coupons_take'];
                       $list1[$k]['coupons_total']=$v['coupons_total'];
                       $list1[$k]['goods_sale']=$v['goods_sale'];
                       $list1[$k]['url']=$v['url'];
                    }
                    $status=1;

                }else{
                    $status=2;
                }
                exit(json_encode(array('status' => $status, 'content' =>$list1,'lm'=>1)));
          }




        if(!empty($typeid)){
           $where =" and type='{$typeid}'";
        }
        
//        if(!empty($_GPC['key'])){
//            $arr=$this->getfc($_GPC['key']);
//            $arr=explode(" ",$arr);
//            $arr=explode(" ",$_GPC['key']);
//             foreach($arr as $v){
//                 if (empty($v)) continue;
//                $where.=" and title like '%{$v}%'";
//             }
//            $where .=" and title like '%{$_GPC['key']}%'";
//        }

        if(!empty($_GPC['key'])){
            //$arr=$this->getfc($_GPC['key']);
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

            $page=$_GPC['limit'];
            $pindex = max(1, intval($page));
		    $psize = 10;          
            $list = pdo_fetchall("select * from ".tablename("tiger_newhu_tbgoods")." where weid='{$weid}' and coupons_take<>'' and coupons_end>={$dtime} {$where} order by {$rand} {$sort} LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('tiger_newhu_tbgoods')." where coupons_end>={$dtime} and coupons_take<>'' and  weid='{$weid}' {$where}");

            
            



            if (!empty($list)){
                $status=1;
                
                foreach($list as $k=>$v){
                   $dlyj=($v['tk_rate']*$v['price']/100);
                   if(!empty($bl['dlkcbl'])){
                     $dlyj=$dlyj*(100-$bl['dlkcbl'])/100;
                   }
                   $list[$k]['title']=$v['title'];
                   $list[$k]['pic_url']=$v['pic_url'];
                   $list[$k]['price']=$v['price'];
                   $list[$k]['coupons_price']=$v['coupons_price'];
                   $list[$k]['tk_rate']=$v['tk_rate'];
                   $list[$k]['lxtype']=$v['lxtype'];
                   $list[$k]['dlyj']=number_format($dlyj*$dlbl/100,2);//代理佣金
                   $list[$k]['id']=$v['id'];
                   $list[$k]['coupons_take']=$v['coupons_take'];
                   $list[$k]['coupons_total']=$v['coupons_total'];
                   $list[$k]['goods_sale']=$v['goods_sale'];
                }
            }else{
                $status=2;
            }

        exit(json_encode(array('status' => $status, 'content' => $list)));
       ?>