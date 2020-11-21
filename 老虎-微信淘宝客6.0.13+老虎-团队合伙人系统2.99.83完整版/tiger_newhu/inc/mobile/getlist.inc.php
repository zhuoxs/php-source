<?php
global $_W, $_GPC;
       $cfg = $this->module['config'];
        $typeid=$_GPC['typeid'];
        $dluid=$_GPC['dluid'];//share id
        $sy=$_GPC['sy'];
        $weid=$_W['uniacid'];
        if(!empty($cfg['gyspsj'])){
          $weid=$cfg['gyspsj'];
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


        if($cfg['mmtype']==1){
            if(empty($_GPC['pid'])){
              $pid=$cfg['ptpid'];
            }else{
              $pid=$_GPC['pid'];
            }
           if(!empty($tj)){
              if($tj==1){
                   $_GPC['key']='9.9';
                }elseif($tj==2){
                   $_GPC['key']='19.9';
                }else{
                  $where.=" and tj={$tj}";
                }
           }
           
            

            if(!empty($typeid)){
              $fltype=pdo_fetch ( 'select * from ' . tablename ( $this->modulename . "_fztype" ) . " where weid='{$weid}' and id='{$typeid}'" );
              if(empty($_GPC['key'])){
                $_GPC['key']=$fltype['title'];
              }
            }
            //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--12.txt","\n old:".$_GPC['key'],FILE_APPEND);

            $page=$_GPC['limit'];
            //$list=$this->goodlist($_GPC['key'],$pid,$page,$xzprice);
            include IA_ROOT . "/addons/tiger_newhu/inc/sdk/tbk/tb.php"; 
            

            if(empty($_GPC['key'])){
              $_GPC['key']=$cfg['sylmkey'];
              $arrkey=explode('|',$_GPC['key']);
              $ar_num=array_rand($arrkey,1);
              $_GPC['key']=$arrkey[$ar_num];
            }
            //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--page.txt","\n".json_encode($page),FILE_APPEND);
            
            if($sy==1){
              $list=getgyapigoodsindex($_GPC['key'],$_W,$pid,$page,$cfg);
            }else{
              $list=getgyapigoods($_GPC['key'],$_W,$pid,$page,$cfg);
            }


            //file_put_contents(IA_ROOT."/addons/tiger_newhu/log--12.txt","\n old:".json_encode($list),FILE_APPEND);
            
            if (!empty($list['list'])){
                $list['list']=array_values($list['list']);
                $status=1;
            }else{
                $status=2;
            }
            exit(json_encode(array('status' => $status, 'content' => $list['list'],'lm'=>1)));
        }





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

        if(!empty($tj)){
          if($tj==1){
            $where .=" and price<10";
          }elseif($tj==2){
          $where .=" and price<20 and price>10";
          }else{
              $where.=" and tj={$tj}";
            }
        
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
        if(!empty($zt)){
           $where .=" and zt={$zt}";
        }


            $page=$_GPC['limit'];
            $pindex = max(1, intval($page));
		    $psize = 10;

            $list = pdo_fetchall("select * from ".tablename($this->modulename."_tbgoods")." where weid='{$weid}' and coupons_end>={$dtime} {$where} order by {$sort} LIMIT " . ($pindex - 1) * $psize . ",{$psize}");
            $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->modulename.'_tbgoods')." where coupons_end>={$dtime} and  weid='{$weid}' {$where}");

            $dblist = pdo_fetchall("select * from ".tablename($this->modulename."_cdtype")." where weid='{$_W['uniacid']}' and fftype=1  order by px desc");//底部菜单


            if (!empty($list)){
                $status=1;
            }else{
                $status=2;
            }

            exit(json_encode(array('status' => $status, 'content' => $list,'lm'=>0)));
            
        

//        $style=$cfg['qtstyle'];
//        if(empty($style)){
//            $style='style1';        
//        }
//
//       //include $this->template ( 'tbgoods/'.$style.'/getlist' );